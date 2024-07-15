<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        // echo "Middleware Auth: {$user->email}<br>";
        if (!$user) {
            return redirect()->route('home')->with([
                'status' => 'error',
                'message' => 'You are not allowed to access this page'
            ]);
        }
        return $next($request);
    }
}
