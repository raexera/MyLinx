<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Tenant;
use App\Services\PageViewService;
use Illuminate\View\View;

class TenantPageController extends Controller
{
    /**
     * Resolve the template slug to use for rendering.
     * Falls back to 'minimalist' if the tenant has no template set.
     */
    private function resolveTemplateSlug(Tenant $tenant): string
    {
        // Load template relationship if not already loaded
        $tenant->loadMissing('template');

        return $tenant->template?->slug_key ?? 'minimalist';
    }

    /**
     * Display the tenant's public storefront homepage.
     *
     * Renders via the tenant's selected template:
     *   tenant.templates.{slug_key}.show
     *
     * Eager-loads:
     * - profilUsaha: business profile (logo, description, contact)
     * - portofolios: all portfolio entries (for showcase section)
     * - produks: only ACTIVE products that are IN STOCK
     */
    public function show(Tenant $tenant, PageViewService $pageViews): View
    {
        $pageViews->record($tenant);

        $profil = $tenant->profilUsaha;
        $produks = $tenant->produks()->where('status', true)->get();
        $portofolios = $tenant->portofolios()->latest()->get();
        $custom = $tenant->customization_with_defaults;

        $templateSlug = $this->resolveTemplateSlug($tenant);
        $viewName = "tenant.templates.{$templateSlug}.show";

        if (! view()->exists($viewName)) {
            $viewName = 'tenant.templates.minimalist.show';
        }

        return view($viewName, compact('tenant', 'profil', 'produks', 'portofolios', 'custom'));
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

        $templateSlug = $this->resolveTemplateSlug($tenant);
        $viewName = "tenant.templates.{$templateSlug}.produk-detail";

        if (! view()->exists($viewName)) {
            $viewName = 'tenant.templates.minimalist.produk-detail';
        }

        return view($viewName, [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'produk' => $produk,
        ]);
    }
}
