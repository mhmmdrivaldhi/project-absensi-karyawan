<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EmployeeAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('employee')->check()) {
            return redirect('/')->withErrors([
                'access' => 'Unauthorized!'
        ]);
    }
    return $next($request);
    }
}
