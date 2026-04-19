<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || auth()->user()->tenant_id === null) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Tenant access required.'], 403);
            }

            return redirect()
                ->route('dashboard')
                ->with('error', 'Fitur ini hanya tersedia untuk akun tenant.');
        }

        return $next($request);
    }
}
