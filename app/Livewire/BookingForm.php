<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CruiseLine;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;

class BookingForm extends Component
{
    public CruiseLine $cruise;
    public int $seats = 1;
    public float $totalPrice = 0;
    public string $stripeError = '';
    public bool $isProcessing = false;
    public ?Booking $booking = null;

    public function mount(CruiseLine $cruise)
    {
        $this->cruise = $cruise;
        $this->calculateTotal();
    }

    public function rules()
    {
        return [
            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:8',
                function ($attribute, $value, $fail) {
                    if ($value > $this->cruise->available_seats) {
                        $fail('Недостаточно свободных мест');
                    }
                    if ($this->cruise->departure_time <= now()->addDay()) {
                        $fail('Период бронирования истёк');
                    }
                }
            ]
        ];
    }

    public function updatedSeats($value)
    {
        $this->seats = max(1, min((int)$value, $this->cruise->available_seats));
        $this->validateOnly('seats');
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->totalPrice = $this->cruise->price_per_seat * $this->seats;
    }

    public function initiatePayment()
    {
        $this->validate();
        
        if ($this->isProcessing) {
            return;
        }

        $this->isProcessing = true;
        $this->stripeError = '';

        try {
            DB::beginTransaction();

            $cruise = CruiseLine::where('id', $this->cruise->id)
                ->lockForUpdate()
                ->first();

            if ($cruise->available_seats < $this->seats) {
                throw new \Exception('Недостаточно свободных мест');
            }

            $this->booking = Booking::create([
                'user_id' => Auth::id(),
                'cruise_line_id' => $cruise->id,
                'seats' => $this->seats,
                'total_price' => $this->totalPrice,
                'status' => Booking::STATUS_RESERVED,
                'reserved_until' => now()->addMinutes(1)
            ]);

            $cruise->decrement('available_seats', $this->seats);

            $stripe = new StripeClient(config('services.stripe.secret'));

            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => $cruise->name . ' Cruise',
                                'description' => $this->seats . ' seat(s)'
                            ],
                            'unit_amount' => (int)round($this->totalPrice * 100),
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('booking.success', $this->booking) . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('booking.cancel', $this->booking),
                'metadata' => [
                    'booking_id' => $this->booking->id,
                    'type' => 'cruise'
                ],
            ]);

            $this->booking->update(['stripe_session_id' => $session->id]);

            DB::commit();
            
            return redirect()->away($session->url);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->stripeError = $e->getMessage();
            \Log::error('Booking error: ' . $e->getMessage(), [
                'exception' => $e,
                'cruise_id' => $this->cruise->id,
                'user_id' => Auth::id()
            ]);
            return;
        } finally {
            $this->isProcessing = false;
        }
    }

    public function render()
    {
        return view('livewire.booking-form')->layout('layouts.app');
    }
}