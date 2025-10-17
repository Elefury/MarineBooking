<?php

namespace App\Http\Controllers;

use App\Models\CruiseLine;
use App\Models\Voyage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $advantages = [
            [
                'icon' => '<svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>',
                'title' => 'Гибкая оплата',
                'description' => 'Различные способы оплаты, включая рассрочку'
            ],
            [
                'icon' => '<svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
                'title' => 'Лучшие цены',
                'description' => 'Гарантия лучшей цены или возврат разницы'
            ],
            [
                'icon' => '<svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
                'title' => 'Поддержка 24/7',
                'description' => 'Наша служба поддержки всегда на связи'
            ]
        ];

        $featuredCruises = CruiseLine::active()
            ->select('*', DB::raw('available_seats / total_seats AS occupancy_rate'))
            ->orderByDesc('occupancy_rate')
            ->take(3)
            ->get();

        $featuredVoyages = Voyage::active()
            ->select('*', DB::raw('available_seats / passenger_capacity AS occupancy_rate'))
            ->orderByDesc('occupancy_rate')
            ->take(3)
            ->with(['departurePort', 'arrivalPort', 'vessel'])
            ->get();

        return view('dashboard', compact('advantages', 'featuredCruises', 'featuredVoyages'));
    }
}