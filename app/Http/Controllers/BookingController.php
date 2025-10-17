<?php

namespace App\Http\Controllers;

use App\Models\CruiseLine;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use App\Traits\HandlesPayments;
use App\Services\TicketService;

class BookingController extends Controller
{
    use HandlesPayments;

    public function process(Request $request, CruiseLine $cruise)
{
    if (!$cruise->vessel) {
        return back()->with('error', 'This cruise is not available for booking');
    }
    \Log::debug('Booking process started', [
        'user' => auth()->id(),
        'cruise' => $cruise->toArray(),
        'request' => $request->all()
    ]);

    try {
        $this->authorize('book', $cruise);
        
        if ($cruise->price_per_seat <= 0) {
            throw new \Exception('Invalid cruise price');
        }

        $validated = $request->validate([
            'seats' => [
                'required',
                'integer',
                'min:1',
                'max:'.min($cruise->available_seats, 8)
            ]
        ]);

        DB::beginTransaction();


        $booking = Booking::create([
            'user_id' => auth()->id(),
            'cruise_line_id' => $cruise->id,
            'seats' => $validated['seats'],
            'total_price' => $cruise->price_per_seat * $validated['seats'],
            'status' => 'reserved',
            'reserved_until' => now()->addMinutes(1)
        ]);

        if (!$booking->exists) {
            throw new \Exception('Booking not created');
        }

        // Stripe
        $stripe = new StripeClient(config('services.stripe.secret'));
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $cruise->name . ' Cruise Booking',
                        'description' => $validated['seats'] . ' seat(s)'
                    ],
                    'unit_amount' => $cruise->price_per_seat * 100,
                ],
                'quantity' => $validated['seats'],
            ]],
            'mode' => 'payment',
            'success_url' => route('booking.success', $booking).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('booking.cancel', $booking),
            'expires_at' => now()->addMinutes(1)->unix(),
            'metadata' => [
                'booking_id' => $booking->id,
                'type' => 'cruise'
            ]
        ]);

        if (empty($session->url)) {
            throw new \Exception('Stripe session URL missing');
        }

        $booking->update(['stripe_session_id' => $session->id]);
        DB::commit();

        return redirect($session->url);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Booking error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return back()->with('error', 'Booking failed: ' . $e->getMessage());
    }
}

    public function success(Request $request, Booking $booking)
    {
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'Бронирование отменено.');
        }
        abort_unless($booking->user_id === auth()->id(), 403);

        if (in_array($booking->status, ['pending', 'reserved'])) {
            try {
                $stripe = new StripeClient(config('services.stripe.secret'));
                $session = $stripe->checkout->sessions->retrieve(
                    $request->query('session_id')
                );

                if ($session->payment_status === 'paid') {
                    DB::transaction(function () use ($booking, $session) {
                        $booking->update([
                            'status' => 'confirmed',
                            'reserved_until' => null
                        ]);
                        
                        // $booking->cruiseLine->decrement('available_seats', $booking->seats);
                        
                        $this->updateOrCreatePayment($booking, $session, 'cruise');
                        
                        if (!$booking->ticket) {
                            $ticketService = new TicketService();
                            $ticketService->generateTicket($booking);
                            $booking->refresh();
                        }
                    });
                }
            } catch (ApiErrorException $e) {
                \Log::error('Stripe API error: '.$e->getMessage());
                return redirect()->back()->with('error', 'Payment verification failed');
            }
        }

        $booking->load('ticket', 'cruiseLine');
        
        return view('booking.success', [
            'booking' => $booking,
            'cruise' => $booking->cruiseLine
        ]);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\Exception $e) {
            \Log::error('Stripe webhook error: '.$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 403);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            
            if (isset($session->metadata->booking_id)) {
                $booking = Booking::find($session->metadata->booking_id);
                
                if ($booking && $booking->status !== 'confirmed') {
                    DB::transaction(function () use ($booking, $session) {
                        $booking->update([
                            'status' => 'confirmed',
                            'reserved_until' => null
                        ]);
                        
                        $booking->cruiseLine->decrement('available_seats', $booking->seats);
                        
                        $this->updateOrCreatePayment($booking, $session, 'cruise');
                    });
                }
            }
        }

        return response()->json(['success' => true]);
    }
}