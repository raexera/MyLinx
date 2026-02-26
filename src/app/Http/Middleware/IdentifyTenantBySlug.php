<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenantBySlug
{
    /**
     * Identify the current tenant from the route's {tenant} parameter.
     *
     * This middleware:
     * 1. Resolves the Tenant model via Route Model Binding (by slug).
     * 2. Aborts with 404 if the tenant is inactive (status = false).
     * 3. Binds the resolved tenant into the Service Container so any
     *    class in the request lifecycle can resolve it via app(Tenant::class).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $request->route('tenant');

        // Route Model Binding already handles "slug not found" → 404.
        // This guard is for type safety if the middleware is misapplied.
        if (! $tenant instanceof Tenant) {
            abort(404);
        }

        // Reject inactive tenants
        if (! $tenant->status) {
            abort(404, 'Toko ini sedang tidak aktif.');
        }

        // Bind into the container for global access during this request.
        // Usage anywhere: app(Tenant::class) or resolve(Tenant::class)
        app()->instance(Tenant::class, $tenant);

        return $next($request);
    }
}
