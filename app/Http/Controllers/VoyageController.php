<?php

namespace App\Http\Controllers;

use App\Models\Voyage;
use Illuminate\Http\Request;

class VoyageController extends Controller
{
    public function index()
    {
        $voyages = Voyage::with(['vessel', 'departurePort', 'arrivalPort'])
            ->orderBy('departure_time')
            ->paginate(10);

        return view('voyages.index', compact('voyages'));
    }

    public function show(Voyage $voyage)
    {
        $voyage->load(['vessel', 'departurePort', 'arrivalPort']);
        return view('voyages.show', compact('voyage'));
    }



}