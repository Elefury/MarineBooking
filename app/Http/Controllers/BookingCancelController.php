<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingCancelController extends Controller
{
    public function __invoke(Booking $booking)
    {

        if ($booking->user_id !== auth()->id()) {
            Log::warning('Unauthorized cancel attempt', [
                'user_id' => auth()->id(),
                'booking_id' => $booking->id,
                'ip' => request()->ip()
            ]);
            
            abort(403, 'You are not authorized to cancel this booking');
        }


        if (!in_array($booking->status, [Booking::STATUS_RESERVED, Booking::STATUS_PENDING])) {
            Log::warning('Invalid booking status for cancellation', [
                'booking_id' => $booking->id,
                'current_status' => $booking->status
            ]);
            
            return redirect()
                   ->back()
                   ->with('error', 'This booking cannot be cancelled');
        }

        DB::beginTransaction();

        try {

            $booking->cancel();
            
            Log::info('Booking cancelled successfully', [
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'seats_returned' => $booking->seats
            ]);

            DB::commit();
            
            return redirect()
                   ->route('booking.form', $booking->cruise_line_id)
                   ->with('success', 'Booking successfully cancelled');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Booking cancellation failed', [
                'booking_id' => $booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                   ->with('error', 'Failed to cancel booking. Please try again.');
        }
    }
}