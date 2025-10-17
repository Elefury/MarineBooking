<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vessel;
use App\Models\Port;
use App\Models\Voyage;
use Illuminate\Http\Request;

class AdminVoyageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $voyages = Voyage::with(['vessel', 'departurePort', 'arrivalPort'])
            ->when(request('search'), function($query) {
                $query->where('voyage_number', 'like', '%'.request('search').'%')
                    ->orWhereHas('vessel', function($q) {
                        $q->where('name', 'like', '%'.request('search').'%');
                    });
            })
            ->orderBy('departure_time', 'desc')
            ->paginate(10);

        return view('admin.voyages.index', compact('voyages'));
    }

    public function create()
    {
        $vessels = Vessel::all();
        $ports = Port::all();
        
        return view('admin.voyages.create', compact('vessels', 'ports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'voyage_number' => 'required|string|max:50|unique:voyages',
            'vessel_id' => 'required|exists:vessels,id',
            'departure_port_id' => 'required|exists:ports,id',
            'arrival_port_id' => 'required|exists:ports,id|different:departure_port_id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'price_per_seat' => 'required|numeric|min:0|max:999999',
            'passenger_capacity' => 'required|integer|min:1|max:10000',
            'type' => 'required|in:regular,cruise,charter'
        ]);

        try {
                $validated['available_seats'] = $validated['passenger_capacity'];
                Voyage::create($validated);
                
                return redirect()->route('admin.voyages.index')
                    ->with('success', 'Voyage created successfully');
            } catch (\Exception $e) {
                return back()->withInput()
                    ->with('error', 'Error creating voyage: ' . $e->getMessage());
            }
    }

    public function edit(Voyage $voyage)
    {
        $vessels = Vessel::all();
        $ports = Port::all();
        
        return view('admin.voyages.edit', compact('voyage', 'vessels', 'ports'));
    }

    public function update(Request $request, Voyage $voyage)
    {
        $validated = $request->validate([
            'voyage_number' => 'required|string|max:50|unique:voyages,voyage_number,'.$voyage->id,
            'vessel_id' => 'required|exists:vessels,id',
            'departure_port_id' => 'required|exists:ports,id',
            'arrival_port_id' => 'required|exists:ports,id|different:departure_port_id',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price_per_seat' => 'required|numeric|min:0|max:999999',
            'passenger_capacity' => 'required|integer|min:1|max:10000',
            'type' => 'required|in:regular,cruise,charter'
        ]);


        try {
            if ($voyage->passenger_capacity != $validated['passenger_capacity']) {
                $diff = $validated['passenger_capacity'] - $voyage->passenger_capacity;
                $validated['available_seats'] = max($voyage->available_seats + $diff, 0);
            }

            $voyage->update($validated);

            return redirect()->route('admin.voyages.index')
                ->with('success', 'Данные рейса успешно обновлены.');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Ошибка при изменении рейса: ' . $e->getMessage());
        }
    }

    public function destroy(Voyage $voyage)
    {
        if ($voyage->bookings()->exists()) {
            return redirect()->back()
                ->with('error', 'Нельзя удалить рейс, имеющий бронирования');
        }

        $voyage->delete();

        return redirect()->route('admin.voyages.index')
            ->with('success', 'Рейс удален.');
    }
}