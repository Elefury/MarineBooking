<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CruiseLine;
use App\Models\Vessel;
use App\Http\Middleware\AdminMiddleware;

class AdminCruiseController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); 
    }

    public function index()
    {
        $cruises = CruiseLine::with('vessel')
            ->when(request('search'), function ($query) {
                $query->where('name', 'like', '%'.request('search').'%')
                    ->orWhereHas('vessel', function($q) {
                        $q->where('name', 'like', '%'.request('search').'%');
                    });
            })
            ->paginate(10);

        return view('admin.cruises.index', compact('cruises'));
    }

    public function create()
    {
        $vessels = Vessel::all();
        return view('admin.cruises.create', compact('vessels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vessel_id' => 'required|exists:vessels,id',
            'meeting_point' => 'nullable|string|max:255',
            'meeting_latitude' => 'nullable|numeric|between:-90,90',
            'meeting_longitude' => 'nullable|numeric|between:-180,180',
            'departure_time' => 'required|date',
            'price_per_seat' => 'required|numeric|min:0|max:999999',
            'total_seats' => 'required|integer|min:1|max:10000',
            'image_url' => 'nullable|url|max:255',
            'type' => 'required|in:regular,cruise,charter'
        ]);

        try {
            CruiseLine::create([
                ...$validated,
                'available_seats' => $validated['total_seats']
            ]);
            
            return redirect()->route('admin.cruises.index')
                ->with('success', 'Круиз успешно создан.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Ошибка при создании круиза: ' . $e->getMessage());
        }
    }

    public function edit(CruiseLine $cruise)
    {
        $vessels = Vessel::all();
        return view('admin.cruises.edit', compact('cruise', 'vessels'));
    }

    public function update(Request $request, CruiseLine $cruise)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'vessel_id' => 'required|exists:vessels,id',
            'meeting_point' => 'nullable|string|max:255',
            'meeting_latitude' => 'nullable|numeric|between:-90,90',
            'meeting_longitude' => 'nullable|numeric|between:-180,180',
            'departure_time' => 'required|date',
            'price_per_seat' => 'required|numeric|min:0|max:999999',
            'total_seats' => 'required|integer|min:1|max:10000',
            'image_url' => 'nullable|url|max:255',
            'type' => 'required|in:regular,cruise,charter'
        ]);

        try {
            if ($cruise->total_seats != $validated['total_seats']) {
                $diff = $validated['total_seats'] - $cruise->total_seats;
                $validated['available_seats'] = max($cruise->available_seats + $diff, 0);
            }

            $cruise->update($validated);
            
            return redirect()->route('admin.cruises.index')
                ->with('success', 'Изменения для круиза применены.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Ошибка при изменении круиза: ' . $e->getMessage());
        }
    }
    
    public function destroy(CruiseLine $cruise)
    {
        $cruise->delete();
        return redirect()->route('admin.cruises.index')
            ->with('success', 'Круиз успешно удален.');
    }
}