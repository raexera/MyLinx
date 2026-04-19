<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Tenant;
use App\Services\PageViewService;
use Illuminate\View\View;

class TenantPageController extends Controller
{
    public function show(Tenant $tenant, PageViewService $pageViews): View
    {
        $pageViews->record($tenant);

        $profil = $tenant->profilUsaha;
        $produks = $tenant->produks()->where('status', true)->get();
        $portofolios = $tenant->portofolios()->latest()->get();
        $custom = $tenant->customization_with_defaults;

        return view('tenant.show', compact('tenant', 'profil', 'produks', 'portofolios', 'custom'));
    }

    public function produkDetail(Tenant $tenant, Produk $produk): View
    {
        if ($produk->tenant_id !== $tenant->id) {
            abort(404);
        }

        if (! $produk->status || $produk->stok <= 0) {
            abort(404, 'Produk tidak tersedia.');
        }

        $tenant->load('profilUsaha');
        $custom = $tenant->customization_with_defaults;

        return view('tenant.produk-detail', [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'produk' => $produk,
            'custom' => $custom,
        ]);
    }
}
