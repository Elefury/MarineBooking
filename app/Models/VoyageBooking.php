<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Stripe\StripeClient;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log; 


class VoyageBooking extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_RESERVED = 'reserved';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'voyage_id',
        'seats',
        'total_price',
        'status',
        'reserved_until',
        'stripe_session_id'
    ];

    protected $casts = [
        'reserved_until' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_RESERVED && 
               $this->reserved_until && 
               $this->reserved_until->isPast();
    }

    public function ticket(): MorphOne
    {
        return $this->morphOne(Ticket::class, 'bookable');
    }

    public function cancel(): void
    {
        if ($this->status === self::STATUS_CANCELLED) {
            throw new \RuntimeException('Voyage booking is already cancelled');
        }

        if ($this->status === self::STATUS_CONFIRMED) {
            throw new \RuntimeException('Cannot cancel confirmed voyage booking');
        }

        DB::transaction(function () {
            $stripe = new StripeClient(config('services.stripe.secret'));
            
            try {
                if ($this->stripe_session_id && $this->status === self::STATUS_RESERVED) {
                    $stripe->checkout->sessions->expire($this->stripe_session_id);
                }
            } catch (\Exception $e) {
                Log::error("Failed to expire Stripe session for voyage booking {$this->id}: ".$e->getMessage());
            }

            // делаем проверку еще раз внутри транзакции на случай параллельных запросов
            if ($this->status === self::STATUS_RESERVED || $this->status === self::STATUS_PENDING) {
                $this->update(['status' => self::STATUS_CANCELLED]);
                
                if ($this->voyage) {
                    $this->voyage()->increment('available_seats', $this->seats);
                }
                Log::info("Voyage booking {$this->id} cancelled successfully");
            } else {
                Log::warning("Attempted to cancel voyage booking {$this->id} with invalid status: {$this->status}");
            }
        });
    }
}