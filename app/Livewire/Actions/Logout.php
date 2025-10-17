<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke(): void
    {
        auth()->guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        
        session()->flush();
        session()->regenerate();
    }

//     public function __invoke(): void
// {
//     \Log::debug('Attempting logout');
    
//     try {
//         Auth::guard('web')->logout();
//         Session::invalidate();
//         Session::regenerateToken();
        
//         \Log::debug('Logout successful', [
//             'user' => auth()->id(), // Должен быть null после logout
//             'session' => session()->all()
//         ]);
//     } catch (\Exception $e) {
//         \Log::error('Logout failed: '.$e->getMessage());
//         throw $e;
//     }
// }
    
}
