<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vessel;
use Illuminate\Http\Request;

class AdminVesselController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $vessels = Vessel::latest()->paginate(10);
        return view('admin.vessels.index', compact('vessels'));
    }

    public function create()
    {
        return view('admin.vessels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        Vessel::create($validated);

        return redirect()->route('admin.vessels.index')
            ->with('success', 'Vessel created successfully');
    }

    public function edit(Vessel $vessel)
    {
        return view('admin.vessels.edit', compact('vessel'));
    }

    public function update(Request $request, Vessel $vessel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        $vessel->update($validated);

        return redirect()->route('admin.vessels.index')
            ->with('success', 'Vessel updated successfully');
    }

    public function destroy(Vessel $vessel)
    {
        if ($vessel->voyages()->exists() || $vessel->cruiseLines()->exists()) {


            if ($vessel->voyages()->exists() && $vessel->cruiseLines()->exists()) {
                $countVoyages = $vessel->voyages()->count();
                $countCruises = $vessel->cruiseLines()->count();            
                return back()->with('error', "Судно удалить нельзя. Оно используется для круизов ($countCruises) и для рейсов ($countVoyages).");
            } else if ($vessel->voyages()->exists()) {
                $count = $vessel->voyages()->count();            
                return back()->with('error', "Судно удалить нельзя. Оно используется для рейсов ($count).");
            } else {
                $count = $vessel->cruiseLines()->count();            
                return back()->with('error', "Судно удалить нельзя. Оно используется для круизов ($count).");
            }



        }

        $vessel->delete();
        return back()->with('success', 'Судно было удалено.');
    }
}