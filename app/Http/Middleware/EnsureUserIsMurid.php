<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMurid
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role === 'murid') {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}
