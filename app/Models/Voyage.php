<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    use HasFactory;

    protected $fillable = [
        'voyage_number', 'vessel_id', 'departure_port_id',
        'arrival_port_id', 'departure_time', 'arrival_time',
        'passenger_capacity', 'available_seats', 'price_per_seat', 'type'
    ];

    protected $casts = [
    'departure_time' => 'datetime',
    'arrival_time' => 'datetime',
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function departurePort()
    {
        return $this->belongsTo(Port::class, 'departure_port_id');
    }

    public function arrivalPort()
    {
        return $this->belongsTo(Port::class, 'arrival_port_id');
    }

    public function bookings()
    {
        return $this->hasMany(VoyageBooking::class);
    }

    public function isBookable()
    {
        return $this->departure_time > now()->addDay() 
               && $this->available_seats > 0;
    }

    public function scopeActive($query)
    {
        return $query->where('departure_time', '>', now()->addDay())
                     ->where('available_seats', '>', 0);
    }
}