<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CruiseLine;
use Illuminate\Support\Facades\Cache;

class CruiseController extends Controller
{
    public function index()
    {
        $cruises = Cache::remember('cruises', 3600, function () {
            return CruiseLine::available()
                ->orderBy('departure_time')
                ->paginate(15); 
        });

        return view('cruises.index', compact('cruises'));
    }

    public function show(CruiseLine $cruise)
    {
        $cruise->load('vessel');
        //$weather = (new WeatherService())->getForecast($cruise);
        
        return view('cruises.show', [
            'cruise' => $cruise,
            //'weather' => $weather,
            'meeting_point' => $cruise->meeting_point,
            'vessel' => $cruise->vessel
        ]);
    }

    public function search(Request $request) //del?
    {
        return CruiseLine::search($request->q)
            ->with(['reviews', 'schedule'])
            ->paginate(10);
    }


    // <!--         @if($weather)    // to show blade if add weather
    //         <div class="mt-4 bg-white p-4 rounded shadow">
    //             <h2 class="text-xl font-semibold">Weather Forecast</h2>
    //             @foreach($weather as $day)
    //                 <div class="mt-2">
    //                     <p>Date: {{ $day['date'] }}</p>
    //                     <p>Max Temp: {{ $day['day']['maxtemp_c'] }}°C</p>
    //                 </div>
    //             @endforeach
    //         </div>
    //     @endif -->


}
