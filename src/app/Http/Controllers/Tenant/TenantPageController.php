<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant;

class TenantPageController extends Controller
{
    /**
     * Display the tenant's public storefront homepage.
     *
     * The {tenant} parameter is automatically resolved via Route Model Binding
     * using the Tenant model's getRouteKeyName() which returns 'slug'.
     * The IdentifyTenantBySlug middleware has already validated the tenant
     * is active and bound it to the container.
     */
    public function show(Tenant $tenant)
    {
        // Eager-load the business profile and active products
        $tenant->load([
            'profilUsaha',
            'produks' => fn ($query) => $query->where('status', true)
                                               ->orderBy('created_at', 'desc'),
            'portofolios',
        ]);

        return view('tenant.show', [
            'tenant'      => $tenant,
            'profil'      => $tenant->profilUsaha,
            'produks'     => $tenant->produks,
            'portofolios' => $tenant->portofolios,
        ]);
    }
}
