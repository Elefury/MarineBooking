<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'latitude',
        'longitude'
    ];

    public function departureVoyages()
    {
        return $this->hasMany(Voyage::class, 'departure_port_id');
    }

    public function arrivalVoyages()
    {
        return $this->hasMany(Voyage::class, 'arrival_port_id');
    }
}