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
        // Allow API or JSON requests to pass through without redirect
        if ($request->expectsJson()) {
            return null;
        }

        // Check if the request URI belongs to backend or frontend
        if ($request->is('backend/*')) {
            return route('backend.login');
        } elseif ($request->is('frontend/*')) {
            return route('frontend.login'); // optional if you have frontend routes later
        }

        // Default redirect if none match
        return route('backend.login');
    }
}
