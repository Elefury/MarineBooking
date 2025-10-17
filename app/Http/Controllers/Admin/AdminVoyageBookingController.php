<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VoyageBooking;
use App\Models\Voyage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVoyageBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $bookings = VoyageBooking::with(['user', 'voyage.vessel', 'voyage.departurePort', 'voyage.arrivalPort'])
            ->latest()
            ->paginate(15);

        return view('admin.voyage-bookings.index', compact('bookings'));
    }

    public function show(VoyageBooking $voyageBooking)
    {
        return view('admin.voyage-bookings.show', compact('voyageBooking'));
    }

    public function destroy(VoyageBooking $voyageBooking)
    {
        try {
            DB::transaction(function () use ($voyageBooking) {
                if ($voyageBooking->status === VoyageBooking::STATUS_RESERVED) {
                    $voyageBooking->cancel();    
                }
                if ($voyageBooking->status === VoyageBooking::STATUS_CONFIRMED) {
                    $voyageBooking->voyage()->increment('available_seats', $voyageBooking->seats);
                }
                $voyageBooking->delete();
            });
            
            return back()->with('success', 'Бронирование удалено.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel(VoyageBooking $voyageBooking)
    {
        try {
            $voyageBooking->cancel();
            return back()->with('success', 'Бронирование отменено.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}