<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSupervisor
{
    public function handle(Request $request, Closure $next)
    {
        if (session('role') !== 'supervisor') {
            return redirect('/login')->with('error', 'Access denied.');
        }
        return $next($request);
    }
}