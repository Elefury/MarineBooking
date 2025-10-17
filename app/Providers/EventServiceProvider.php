<?php

namespace App\Providers;
// ???

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BookingCreated::class => [
            SendBookingConfirmation::class,
            UpdateInventory::class,
            NotifyAdmin::class,
        ],
    ];
}
