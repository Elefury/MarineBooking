<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CruiseLine extends Model
{
    use HasFactory;

    protected $casts = [
        'departure_time' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'description',
        'vessel_id',
        'meeting_point',
        'meeting_longitude',
        'meeting_latitude',
        'departure_time',
        'total_seats',
        'available_seats',
        'price_per_seat',
        'type',
        'image_url'
    ];

    public function getBookingsCountAttribute()
    {
        return $this->bookings()->count();
    }
    

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function vessel() {
        return $this->belongsTo(Vessel::class);
    }

    public function scopeSearch($query, $term)
    {
        return $query->whereRaw(
            "MATCH(name, description) AGAINST(? IN BOOLEAN MODE)", 
            [$term]
        );
    }

    public function scopeAvailable($query)
    {
        return $query->where('available_seats', '>', 0);
    }
    public function scopeAverageOccupancy($query)
    {
        return $query->selectRaw('AVG((total_seats - available_seats) / total_seats * 100) as occupancy');
    }
    public function scopeMostPopular($query)
    {
        return $query->withCount('bookings')->orderByDesc('bookings_count');
    }

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'cruise_line_id');
    }
    public static function averageOccupancy()
    {
        $result = self::selectRaw('AVG((total_seats - available_seats) / total_seats * 100) as occupancy')
            ->first();
            
        return $result->occupancy ?? 0; 
    }
    public function scopeActive($query)
    {
        return $query->where('departure_time', '>', now()->addHours(24))
                     ->where('available_seats', '>', 0);
    }
    public function scopeBookable($query)
    {
        return $query->where('departure_time', '>', now()->addHours(24)) 
                     ->where('available_seats', '>', 0);
    }

    public function isBookable()
    {
        $departureTime = $this->departure_time->timezone(config('app.timezone'));
        return $departureTime->subDay()->isFuture() 
               && $this->available_seats > 0;
    }
       
        public function getRouteKeyName()
    {
        return 'id'; 
    }
}