<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);

        // try {
        //     // Check if a token exists in the Authorization header
        //     $token = $request->bearerToken();

        //     if (!$token) {
        //         return response()->json([
        //             'status' => false,
        //             'message' => 'Missing token'
        //         ], 401);
        //     }

        //     // Validate the token using Sanctum
        //     if (!auth()->guard('sanctum')->check()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid or expired token'
                ], 401);
        //     }

        //     return $next($request);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized: ' . $th->getMessage(),
        //     ], 500);
        // }
    }
}
