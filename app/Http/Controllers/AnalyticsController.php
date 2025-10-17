<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\CruiseLine;
use ConsoleTVs\Charts\Classes\C3\Chart;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{

public function index()
{
    $chart = new Chart;
    $chart->labels(Booking::groupByMonth()->pluck('month'))
        ->dataset('Bookings', 'line', Booking::groupByMonth()->pluck('count'));

    $metrics = [
        'revenue' => Payment::sum('amount') ?? 0,
        'occupancy' => CruiseLine::averageOccupancy(),
        'popular' => CruiseLine::mostPopular()->first(),
    ];

    return view('admin.analytics', compact('chart', 'metrics'));
}

}