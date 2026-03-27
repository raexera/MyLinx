<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasTenant
{
    /**
     * Ensure the authenticated user has a tenant_id.
     *
     * This middleware prevents super_admin users (who have tenant_id = null)
     * from accidentally accessing tenant-scoped CMS routes (produk, order,
     * portfolio, settings, profil-usaha) which would cause 500 errors.
     *
     * Applied to all CMS route groups. Super admins are redirected to the
     * dashboard where they see the platform-wide overview instead.
     */
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
