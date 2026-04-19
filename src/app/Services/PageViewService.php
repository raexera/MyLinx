<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\DB;

class PageViewService
{
    public function record(Tenant $tenant): void
    {

        if (auth()->check() && auth()->user()->tenant_id === $tenant->id) {
            return;
        }

        $sessionKey = 'viewed_tenant_'.$tenant->id;

        if (session()->has($sessionKey)) {
            return;
        }

        session()->put($sessionKey, now()->timestamp);

        DB::table('tenants')
            ->where('id', $tenant->id)
            ->increment('page_views');
    }
}
