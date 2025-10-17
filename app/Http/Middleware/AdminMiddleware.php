<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Доступ запрещён');
        }
        
        config(['app.is_admin_area' => true]);
        
        return $next($request);
    }
}