<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Voyage;
use App\Models\VoyageBooking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class VoyageBookingForm extends Component
{
    public Voyage $voyage;
    public int $seats = 1;
    public float $totalPrice = 0;
    public string $stripeError = '';
    public bool $isProcessing = false;
    public ?VoyageBooking $booking = null;

    public function mount(Voyage $voyage)
    {
        $this->voyage = $voyage;
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalPrice = $this->voyage->price_per_seat * $this->seats;
    }

    public function initiatePayment()
    {
        $this->validate([
            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:' . min($this->voyage->available_seats, 8),
                function ($attribute, $value, $fail) {
                    if ($this->voyage->departure_time <= now()->addDay()) {
                        $fail('Период бронирования истёк');
                    }
                }
            ]
        ]);

        if ($this->isProcessing) {
            return;
        }

        $this->isProcessing = true;
        $this->stripeError = '';

        try {
            DB::beginTransaction();

            $voyage = Voyage::where('id', $this->voyage->id)
                ->lockForUpdate()
                ->first();

            if ($voyage->available_seats < $this->seats) {
                throw new \Exception('Недостаточно свободных мест');
            }

            $this->booking = VoyageBooking::create([
                'user_id' => Auth::id(),
                'voyage_id' => $voyage->id,
                'seats' => $this->seats,
                'total_price' => $this->totalPrice,
                'status' => VoyageBooking::STATUS_RESERVED,
                'reserved_until' => now()->addMinutes(1)
            ]);

            $voyage->decrement('available_seats', $this->seats);

            $stripe = new StripeClient(config('services.stripe.secret'));

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => "Voyage #{$voyage->voyage_number}: {$voyage->departurePort->name} → {$voyage->arrivalPort->name}"
                        ],
                        'unit_amount' => $this->totalPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('voyage-booking.success', $this->booking->id) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('voyage-booking.cancel', $this->booking->id),
                'metadata' => [
                    'booking_id' => $this->booking->id,
                    'voyage_id' => $voyage->id,
                    'seats' => $this->seats,
                    'type' => 'voyage'
                ],
            ]);

            $this->booking->update(['stripe_session_id' => $session->id]);

            DB::commit();
            return redirect()->away($session->url);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->stripeError = $e->getMessage();
            \Log::error('Voyage payment error: ' . $e->getMessage(), [
                'exception' => $e,
                'voyage_id' => $this->voyage->id,
                'user_id' => Auth::id()
            ]);
            return;
        } finally {
            $this->isProcessing = false;
        }
    }

    public function submit()
    {
        $this->validate([
            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:'.$this->voyage->available_seats
            ]
        ]);

        return redirect()->route('voyage-booking.process', [
            'voyage' => $this->voyage->id,
            'seats' => $this->seats
        ]);
    }

    public function render()
    {
        return view('livewire.voyage-booking-form')
            ->layout('layouts.app'); 
    }
}