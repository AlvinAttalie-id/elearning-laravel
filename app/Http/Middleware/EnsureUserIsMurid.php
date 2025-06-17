<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMurid
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->hasRole('murid')) {
            return $next($request);
        }

        abort(403, 'Unauthorized: Hanya murid yang boleh mengakses halaman ini.');
    }
}
