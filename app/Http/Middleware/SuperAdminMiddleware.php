<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check()) {
            return redirect()->route('admin.login')->with('status', 'Please sign in to access this area.');
        }

        if (! auth()->user()->isSuperAdmin()) {
            abort(403, 'Access denied. Superadmin privileges required.');
        }

        return $next($request);
    }
}
