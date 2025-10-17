<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\VoyageBooking;

class CleanExpiredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean expired cruise and voyage bookings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // for cruise bookings
        $expiredCruiseBookings = Booking::where('status', Booking::STATUS_RESERVED)
            ->where('reserved_until', '<', now())
            ->get();

        foreach ($expiredCruiseBookings as $booking) {
            try {
                $booking->cancel();
                \Log::info('Cancelled expired cruise booking', ['booking_id' => $booking->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to cancel cruise booking', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        // for voyage bookings
        $expiredVoyageBookings = VoyageBooking::where('status', VoyageBooking::STATUS_RESERVED)
            ->where('reserved_until', '<', now())
            ->get();

        foreach ($expiredVoyageBookings as $booking) {
            try {
                $booking->cancel();
                \Log::info('Cancelled expired voyage booking', ['booking_id' => $booking->id]);
            } catch (\Exception $e) {
                \Log::error('Failed to cancel voyage booking', [
                    'booking_id' => $booking->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $this->info(sprintf(
            "Cleaned %d cruise and %d voyage expired reservations",
            $expiredCruiseBookings->count(),
            $expiredVoyageBookings->count()
        ));
    }
}
