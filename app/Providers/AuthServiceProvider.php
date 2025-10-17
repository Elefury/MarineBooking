<?php

namespace App\Providers;

use App\Models\CruiseLine;
use App\Policies\CruisePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        CruiseLine::class => CruisePolicy::class,
        Ticket::class => TicketPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            \Log::info("Attempting {$ability}", [
                'user' => $user?->id,
                'time' => now()
            ]);
        });
    }
}