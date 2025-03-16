<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrevenDirectLogoutMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('employee')->check() && !$request->session()->has('logout_allowed')) {
            return redirect('/dashboard')->withErrors(provider: ['error' => 'Redirect logout via url isnot allowed!' ]);
        }
        return $next($request);
    }
}
