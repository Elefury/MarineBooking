<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'rating', 'is_approved'];
    protected $dates = ['created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeHighestRated($query)
    {
        return $query->orderBy('rating', 'desc');
    }

    public function scopeLowestRated($query)
    {
        return $query->orderBy('rating', 'asc');
    }


}