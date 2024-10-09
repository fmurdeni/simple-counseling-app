<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the role of 1
        if (Auth::check() && Auth::user()->hasRole(1) ) {
            return $next($request);
        }

        // If the user does not have access, redirect to home or another page
        return redirect(route('dashboard'))->with('error', 'Akses dibatasi.');
    }
}
