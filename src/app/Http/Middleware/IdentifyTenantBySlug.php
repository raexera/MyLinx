<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenantBySlug
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = $request->route('tenant');

        if (! $tenant instanceof Tenant) {
            abort(404);
        }

        if (! $tenant->status) {
            abort(404, 'Toko ini sedang tidak aktif.');
        }

        app()->instance(Tenant::class, $tenant);

        return $next($request);
    }
}
