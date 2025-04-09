<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\utility\Util;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Util::Auth();

        if(!$user || $user->role !== User::$isAdmin){
            return response()->json(['success' => false, 'message' => 'UnAuthorized'], 403);
        }
        return $next($request);
    }
}
