<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with([
            'user:id,name', 
            'cruiseLine:id,name', 
            'payment'
        ])->latest()
          ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function destroy(Booking $booking)
    {

        try {       
            DB::transaction(function () use ($booking) {
                if ($booking->status === Booking::STATUS_RESERVED) {
                    $booking->cancel();          
                }
                if ($booking->status === Booking::STATUS_CONFIRMED) {
                    $booking->cruiseLine()->increment('available_seats', $booking->seats);
                }
                $booking->delete();
            });            
            return back()->with('success', 'Бронирование удалено.');
        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при удалении бронирования: '.$e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', [
            'booking' => $booking->load(['user', 'cruiseLine', 'payment'])
        ]);
    }

    public function cancel(Booking $booking)
    {
        try {

        $booking->cancel();
        return back()->with('success', 'Бронирование отменено.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting booking: '.$e->getMessage());
        } 

    }
    
}