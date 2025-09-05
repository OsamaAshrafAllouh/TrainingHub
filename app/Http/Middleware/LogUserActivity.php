<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
//        dd(Auth::check());
//        if (Auth::check()) {
//            $user = Auth::user();
//            if ($user) {
//                $logMessage = 'User activity: ' . $user->id . ' ' . $user->name . ' ' . $request->method() . ' ' . $request->getRequestUri();
//                Log::info($logMessage);
//            }
//        }
//
//        return $next($request);
    }
}
