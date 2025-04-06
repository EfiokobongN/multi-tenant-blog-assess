<?php

namespace App\Http\Middleware;

use App\utility\Util;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Util::Auth();

        if($user && !$user->is_approved){
            return response()->json(['success' => false, 'message'=> 'Account Not Approved'], 403);
        }
        return $next($request);
    }
}
