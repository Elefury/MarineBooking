<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\VoyageBooking;
use Carbon\Carbon;

class UserController extends Controller
{
    public function bookings()
    {
        $user = auth()->user();
        $now = Carbon::now();
        
        $cruiseBookings = $user->bookings()
            ->with(['cruiseLine' => function($query) {
                $query->with('vessel');
            }])
            ->get();
            
        $voyageBookings = $user->voyageBookings()
            ->with(['voyage' => function($query) {
                $query->with(['departurePort', 'arrivalPort', 'vessel']);
            }])
            ->get();
            
        $allBookings = $cruiseBookings->merge($voyageBookings);
        
        $upcomingBookings = $allBookings->filter(function($booking) use ($now) {
            $departureTime = $booking instanceof Booking 
                ? $booking->cruiseLine->departure_time 
                : $booking->voyage->departure_time;
                
            return $booking->status === 'confirmed' && 
                   $departureTime > $now;
        })->sortBy(function($booking) {
            return $booking instanceof Booking 
                ? $booking->cruiseLine->departure_time 
                : $booking->voyage->departure_time;
        });
        
        $completedBookings = $allBookings->filter(function($booking) use ($now) {
            $departureTime = $booking instanceof Booking 
                ? $booking->cruiseLine->departure_time 
                : $booking->voyage->departure_time;
                
            return $booking->status === 'confirmed' && 
                   $departureTime <= $now;
        })->sortByDesc(function($booking) {
            return $booking instanceof Booking 
                ? $booking->cruiseLine->departure_time 
                : $booking->voyage->departure_time;
        });
        
        $otherBookings = $allBookings->filter(function($booking) {
            return in_array($booking->status, ['reserved', 'cancelled']);
        })->sortByDesc('created_at');

        return view('user.bookings.index', [
            'upcomingBookings' => $upcomingBookings,
            'completedBookings' => $completedBookings,
            'otherBookings' => $otherBookings
        ]);
    }
}