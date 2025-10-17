<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Livewire\CruiseLinesList;
use Livewire\Livewire;
use App\Models\CruiseLine;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   

    public function boot(): void
    {
        Livewire::component('cruise-lines-list', CruiseLinesList::class);
        //Livewire::component('booking-form', \App\Http\Livewire\BookingForm::class);
        //Paginator::defaultView('vendor.pagination.tailwind');
        CruiseLine::creating(function ($cruise) {
        if (!$cruise->vessel_id) {
            throw new \Exception("A cruise must be associated with a vessel");
        }
    });
    }
}
