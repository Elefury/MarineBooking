<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use Illuminate\Http\Request;

class AdminPortController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $ports = Port::latest()->paginate(10);
        return view('admin.ports.index', compact('ports'));
    }

    public function create()
    {
        return view('admin.ports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        Port::create($validated);

        return redirect()->route('admin.ports.index')
            ->with('success', 'Port created successfully');
    }

    public function edit(Port $port)
    {
        return view('admin.ports.edit', compact('port'));
    }

    public function update(Request $request, Port $port)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180'
        ]);

        $port->update($validated);

        return redirect()->route('admin.ports.index')
            ->with('success', 'Данные порта успешно обновлены.');
    }

    public function destroy(Port $port)
    {
        if ($port->departureVoyages()->exists() || $port->arrivalVoyages()->exists()) {
            $count = $port->departureVoyages()->count() + $port->arrivalVoyages()->count();
            return back()->with('error', "Порт не удалить, так как используется в рейсах ($count).");
        }

        $port->delete();
        return back()->with('success', 'Порт был удален.');
    }
}