<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class PageViewService
{
    /**
     * Increment tenant page_views exactly once per session per tenant.
     *
     * Guards:
     * - Session-based dedup (same visitor refreshing doesn't inflate).
     * - Ignores authenticated tenant admins viewing their own storefront.
     * - Uses atomic SQL update to avoid race conditions.
     */
    public function record(Tenant $tenant): void
    {
        // Skip if the owner is previewing their own store
        if (auth()->check() && auth()->user()->tenant_id === $tenant->id) {
            return;
        }

        $sessionKey = 'viewed_tenant_'.$tenant->id;

        if (session()->has($sessionKey)) {
            return;
        }

        session()->put($sessionKey, now()->timestamp);

        // Atomic increment — safe under concurrency
        DB::table('tenants')
            ->where('id', $tenant->id)
            ->increment('page_views');
    }
}
