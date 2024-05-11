<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if(!request("Authorization")){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = JWTAuth::parseToken()->authenticate();
        if ($user->role_id !== $role) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
