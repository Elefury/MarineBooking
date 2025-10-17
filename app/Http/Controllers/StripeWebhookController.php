<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\VoyageBooking;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\BookingConfirmed;
use App\Jobs\SendBookingConfirmation;
use Stripe\StripeClient;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('Stripe Webhook Received', ['type' => $request->type]);

        try {
            $event = $this->constructEvent($request);
            
            switch ($event->type) {
                case 'checkout.session.completed':
                    $this->handleCompletedSession($event->data->object);
                    break;
                    
                case 'checkout.session.expired':
                    $this->handleExpiredSession($event->data->object);
                    break;
                    
                case 'checkout.session.async_payment_failed':
                    $this->handleFailedPayment($event->data->object);
                    break;
                    
                default:
                    Log::info('Unhandled event type', ['type' => $event->type]);
            }

            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            Log::error('Webhook Error: '.$e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    protected function constructEvent(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        
        // Проверяем оба секрета (основной и для рейсов)
        try {
            return \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            Log::info('Trying voyage webhook secret...');
            return \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.voyage_webhook_secret')
            );
        }
    }

    protected function handleCompletedSession($session)
    {
        Log::info('Processing checkout.session.completed', [
            'session_id' => $session->id,
            'payment_status' => $session->payment_status
        ]);

        if ($session->payment_status !== 'paid') {
            Log::warning('Session not paid', ['session' => $session]);
            return;
        }

        DB::transaction(function() use ($session) {
            $type = $session->metadata->type ?? 'cruise';
            
            if ($type === 'cruise') {
                $booking = Booking::where('stripe_session_id', $session->id)
                    ->orWhere('id', $session->metadata->booking_id ?? null)
                    ->first();
            } else {
                $booking = VoyageBooking::where('stripe_session_id', $session->id)
                    ->orWhere('id', $session->metadata->booking_id ?? null)
                    ->first();
            }

            if (!$booking) {
                Log::error('Booking not found for session', [
                    'session_id' => $session->id,
                    'type' => $type
                ]);
                return;
            }

            $booking->update([
                'status' => $type === 'cruise' 
                    ? Booking::STATUS_CONFIRMED 
                    : VoyageBooking::STATUS_CONFIRMED,
                'total_price' => $session->amount_total / 100,
                'reserved_until' => null
            ]);

            Payment::updateOrCreate(
                ['stripe_payment_id' => $session->payment_intent],
                [
                    'bookable_type' => $type === 'cruise' ? 'cruise' : 'voyage',
                    'bookable_id' => $booking->id,
                    'amount' => $session->amount_total / 100,
                    'status' => 'completed',
                    'metadata' => [
                        'type' => $type,
                        'stripe_object' => 'session'
                    ]
                ]
            );

            Log::info('Booking confirmed', [
                'booking_id' => $booking->id,
                'type' => $type
            ]);

            $booking->user->notify(new BookingConfirmed($booking));
            dispatch(new SendBookingConfirmation($booking));
        });
    }

    protected function handleExpiredSession($session)
    {
        Log::info('Processing checkout.session.expired', [
            'session_id' => $session->id
        ]);

        DB::transaction(function () use ($session) {
            $type = $session->metadata->type ?? 'cruise';
            
            if ($type === 'cruise') {
                $booking = Booking::where('stripe_session_id', $session->id)
                    ->where('status', Booking::STATUS_RESERVED)
                    ->first();
            } else {
                $booking = VoyageBooking::where('stripe_session_id', $session->id)
                    ->where('status', VoyageBooking::STATUS_RESERVED)
                    ->first();
            }

            if ($booking) {
                $booking->cancel();
                Log::info('Expired booking cancelled', [
                    'booking_id' => $booking->id,
                    'type' => $type
                ]);
            } else {
                Log::warning('No reserved booking found for expired session', [
                    'session_id' => $session->id,
                    'type' => $type
                ]);
            }
        });
    }

    protected function handleFailedPayment($session)
    {
        Log::warning('Processing failed payment', [
            'session_id' => $session->id,
            'payment_status' => $session->payment_status
        ]);

        DB::transaction(function () use ($session) {
            $type = $session->metadata->type ?? 'cruise';
            
            if ($type === 'cruise') {
                $booking = Booking::where('stripe_session_id', $session->id)
                    ->whereIn('status', [Booking::STATUS_RESERVED, Booking::STATUS_PENDING])
                    ->first();
            } else {
                $booking = VoyageBooking::where('stripe_session_id', $session->id)
                    ->whereIn('status', [VoyageBooking::STATUS_RESERVED, VoyageBooking::STATUS_PENDING])
                    ->first();
            }

            if ($booking) {
                $booking->cancel();
                Log::info('Booking cancelled due to failed payment', [
                    'booking_id' => $booking->id,
                    'type' => $type
                ]);
            }
        });
    }
}