<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        // dd($request->expectsJson());
        if (!$user || !$user->role || $user->role !== User::ROLE[1]) {
            return $request->expectsJson() 
                ? response()->json(['error' => 'You are not allowed to access this page'])
                : redirect()->route('public.home')->with('error', 'You are not allowed to access this page');
        }
        return $next($request);
    }
}
