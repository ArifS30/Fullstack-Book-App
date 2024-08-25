<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\RolesModels;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class isOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userOwner = RolesModels::where('name', 'owner')->first();
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        if ($user && $user->role_id === $userOwner->id) {
            return $next($request);
        } else {
            return response()->json(['message' => 'Only Owner'], 403);
        }
    }
}
