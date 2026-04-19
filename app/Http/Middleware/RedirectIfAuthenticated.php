<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            return match (Auth::user()->role) {
                'manajemen' => redirect()->route('manajemen.dashboard'),
                'wasit'     => redirect()->route('wasit.dashboard'),
                default     => redirect()->route('home'),
            };
        }

        return $next($request);
    }
}
