<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\CruiseLine;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'revenue' => Payment::sum('amount') ?? 0,
            'occupancy' => CruiseLine::averageOccupancy(), 
            'popular' => CruiseLine::mostPopular()->first(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}