<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; 
use Stripe\StripeClient;

class Booking extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_RESERVED = 'reserved';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'cruise_line_id',
        'seats',
        'total_price',
        'status',
        'reserved_until',
        'stripe_session_id'
    ];

    protected $casts = [
        'reserved_until' => 'datetime'
    ];

    public function isExpired(): bool
    {
        return $this->status === self::STATUS_RESERVED && 
               $this->reserved_until && 
               $this->reserved_until->isPast();
    }

    public function cancel(): void
    {
        if ($this->status === self::STATUS_CANCELLED) {
            throw new \RuntimeException('Booking is already cancelled');
        }

        if ($this->status === self::STATUS_CONFIRMED) {
            throw new \RuntimeException('Cannot cancel confirmed booking');
        }

        DB::transaction(function () {
            $stripe = new StripeClient(config('services.stripe.secret'));
            
            try {
                if ($this->stripe_session_id && $this->status === self::STATUS_RESERVED) {
                    $stripe->checkout->sessions->expire($this->stripe_session_id);
                }
            } catch (\Exception $e) {
                Log::error("Failed to expire Stripe session for booking {$this->id}: ".$e->getMessage());
            }

            // делаем проверку еще раз внутри транзакции на случай параллельных запросов
            if ($this->status === self::STATUS_RESERVED || $this->status === self::STATUS_PENDING) {
                $this->update(['status' => self::STATUS_CANCELLED]);
                $this->cruiseLine()->increment('available_seats', $this->seats);
                Log::info("Booking {$this->id} cancelled successfully");
            } else {
                Log::warning("Attempted to cancel booking {$this->id} with invalid status: {$this->status}");
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cruiseLine()
    {
        return $this->belongsTo(CruiseLine::class);
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'bookable');
    }

    public function scopeGroupByMonth($query)
    {
        return $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month');
    }
    public function promoCodes()
    {
        return $this->belongsToMany(PromoCode::class, 'booking_promo_code');
    }
    
    public function ticket(): MorphOne
    {
        return $this->morphOne(Ticket::class, 'bookable');
    }


}
