<?php

namespace App\Http\Controllers;

use App\Models\VoyageBooking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use App\Traits\HandlesPayments;
use App\Services\TicketService;

class VoyageBookingController extends Controller
{
    use HandlesPayments; 

    public function process(Request $request, $voyageId)
    {
        $voyage = \App\Models\Voyage::findOrFail($voyageId);
        
        $validated = $request->validate([
            'seats' => 'required|integer|min:1|max:'.$voyage->available_seats
        ]);

        $stripe = new StripeClient(config('services.stripe.secret'));
        
        $booking = VoyageBooking::create([
            'user_id' => auth()->id(),
            'voyage_id' => $voyage->id,
            'seats' => $validated['seats'],
            'total_price' => $voyage->price_per_seat * $validated['seats'],
            'status' => 'pending'
        ]);

        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Voyage #'.$voyage->voyage_number
                    ],
                    'unit_amount' => $booking->total_price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('voyage-booking.success', $booking->id),
            'cancel_url' => route('voyage-booking.cancel', $booking->id),
        ]);

        return redirect($session->url);
    }
        
    public function success(Request $request, VoyageBooking $booking)
    {
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
                            'reserved_until' => now()->addMinutes(1)
                        ]);
                        
                        $this->updateOrCreatePayment($booking, $session, 'voyage');
                        
                        // Перенести создание билета внутрь транзакции
                        if (!$booking->ticket) {
                            $ticketService = new TicketService();
                            $ticketService->generateTicket($booking);
                        }
                    });
                }
            } catch (ApiErrorException $e) {
                \Log::error('Stripe API error: '.$e->getMessage());
                return redirect()->back()->with('error', 'Payment verification failed');
            }
        }

        $booking->load('ticket', 'voyage.departurePort', 'voyage.arrivalPort');
        
        return view('voyage-booking.success', compact('booking'));
    }

    public function cancel(VoyageBooking $booking)
    {
        if ($booking->status === 'cancelled') {
            return redirect()->back()->with('error', 'This booking was cancelled');
        }
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->cancel();
        
        return redirect()->route('voyages.show', $booking->voyage_id)
            ->with('message', 'Booking cancelled successfully');
    }
}