<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\View\View;

class TenantPageController extends Controller
{
    /**
     * Display the tenant's public storefront homepage.
     *
     * Eager-loads:
     * - profilUsaha: business profile (logo, description, contact)
     * - portofolios: all portfolio entries (for showcase section)
     * - produks: only ACTIVE products that are IN STOCK
     */
    public function show(Tenant $tenant): View
    {
        $tenant->load([
            'profilUsaha',
            'portofolios' => fn ($q) => $q->orderBy('created_at', 'desc'),
            'produks' => fn ($q) => $q->where('status', true)
                                      ->where('stok', '>', 0)
                                      ->orderBy('created_at', 'desc'),
        ]);

        return view('tenant.show', [
            'tenant'      => $tenant,
            'profil'      => $tenant->profilUsaha,
            'produks'     => $tenant->produks,
            'portofolios' => $tenant->portofolios,
        ]);
    }

    /**
     * Display the product detail page for a specific tenant product.
     *
     * Validates that the product actually belongs to this tenant
     * and is active + in stock before showing it.
     */
    public function produkDetail(Tenant $tenant, Produk $produk): View
    {
        // Ensure the product belongs to this tenant
        if ($produk->tenant_id !== $tenant->id) {
            abort(404);
        }

        // Ensure the product is active and in stock
        if (! $produk->status || $produk->stok <= 0) {
            abort(404, 'Produk tidak tersedia.');
        }

        // Load tenant profile for the header/layout
        $tenant->load('profilUsaha');

        return view('tenant.produk-detail', [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'produk' => $produk,
        ]);
    }
}
