<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Untuk API, selalu return null (tidak redirect)
        return null;
    }

    /**
     * Handle unauthenticated user
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'status' => false,
            'message' => 'Unauthenticated. Token tidak valid atau expired.',
        ], 401));
    }
}
