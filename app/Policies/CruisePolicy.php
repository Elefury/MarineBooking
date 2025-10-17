<?php

namespace App\Policies;

use App\Models\CruiseLine;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CruisePolicy
{
    public function book(?User $user, CruiseLine $cruise)
    {
        $isBookable = $cruise->departure_time->gt(now()->addDay()) 
            && $cruise->available_seats > 0;

        return $isBookable
            ? Response::allow()
            : Response::deny(
                $cruise->available_seats <= 0 
                    ? 'No available seats' 
                    : 'Booking closed (departure in less than 24 hours)'
            );
    }

    public function view(User $user, Ticket $ticket)
    {
        if (!$ticket->bookable) {
            return false;
        }
        
        if (method_exists($ticket->bookable, 'user')) {
            return $user->id === $ticket->bookable->user_id;
        }
        
        return false;
    }
}
