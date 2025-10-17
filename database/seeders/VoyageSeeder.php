<?php

namespace Database\Seeders;

use App\Models\Port;
use App\Models\Vessel;
use App\Models\Voyage;
use Illuminate\Database\Seeder;

class VoyageSeeder extends Seeder
{
    public function run()
    {
        $ports = Port::factory()->count(5)->create();
      
        $vessels = Vessel::factory()->count(3)->create();
      
        Voyage::factory()->count(10)->create([
            'departure_port_id' => fn() => $ports->random()->id,
            'arrival_port_id' => fn() => $ports->random()->id,
            'vessel_id' => fn() => $vessels->random()->id,
        ]);
    }
}