<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'qr_code',
        'status',
        'checked_in_at'
    ];
    protected $with = ['bookable'];

    protected $casts = [
        'checked_in_at' => 'datetime'
    ];

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public static function generateTicketNumber(): string
    {
        return 'TKT-' . strtoupper(uniqid());
    }
}