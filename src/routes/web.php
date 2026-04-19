<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilUsahaController;
use App\Http\Controllers\PublicInvoiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Tenant\TenantOrderController;
use App\Http\Controllers\Tenant\TenantPageController;
use Illuminate\Support\Facades\Route;

/*
|==========================================================================
| CENTRAL ROUTES — MyLinx Platform
|==========================================================================
*/

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|==========================================================================
| AUTHENTICATED ROUTES — Dashboard (both super_admin and tenant_admin)
|==========================================================================
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — DashboardController handles role-based data
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

/*
|==========================================================================
| TENANT CMS ROUTES — Requires auth + verified + has a tenant
|==========================================================================
|
| The 'has.tenant' middleware prevents super_admin users (tenant_id = null)
| from accessing these routes, which would cause 500 errors on queries
| that filter by tenant_id.
|
*/

Route::middleware(['auth', 'verified', 'has.tenant'])->group(function () {

    // ── Produk CRUD ─────────────────────────────────────────
    Route::resource('produk', ProdukController::class)
        ->except(['show']);

    // ── Profil Usaha (Edit & Update only) ───────────────────
    Route::get('/profil-usaha', [ProfilUsahaController::class, 'edit'])
        ->name('profil-usaha.edit');
    Route::patch('/profil-usaha', [ProfilUsahaController::class, 'update'])
        ->name('profil-usaha.update');
    Route::delete('/profil-usaha/qris', [ProfilUsahaController::class, 'removeQris'])
        ->name('profil-usaha.remove-qris');

    // ── Portofolio CRUD ─────────────────────────────────────
    Route::resource('portfolio', PortofolioController::class)
        ->except(['show', 'create']);

    // ── Order Management ─────────────────────────────────────
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/export', [OrderController::class, 'export'])->name('order.export');   // ← BEFORE {order}
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/order/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::patch('/order/{order}/mark-paid', [OrderController::class, 'markPaid'])->name('order.mark-paid');
    Route::patch('/order/{order}/ship', [OrderController::class, 'ship'])->name('order.ship');
    Route::patch('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
    Route::patch('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    // ── Settings ────────────────────────
    Route::get('/settings/website', [SettingController::class, 'editWebsite'])
        ->name('settings.website');
    Route::patch('/settings/website', [SettingController::class, 'updateWebsite'])
        ->name('settings.website.update');
    Route::get('/settings/website/check-slug', [SettingController::class, 'checkSlug'])
        ->name('settings.website.check-slug');
});

/*
|==========================================================================
| BREEZE USER ACCOUNT ROUTES — Separate from business profile
|==========================================================================
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|==========================================================================
| PUBLIC INVOICE — Accessible via unguessable token
|==========================================================================
|
| Used in WA-shared links: mylinx.com/invoice/aB3xK9mQvN2pL7tR4sW8yZ1cE5fH6gJ0
| No auth required — the 32-char token IS the auth.
| Must be registered BEFORE the tenant catch-all group.
|
*/

Route::get('/invoice/{token}', [PublicInvoiceController::class, 'show'])
    ->name('public.invoice')
    ->where('token', '[A-Za-z0-9]{32}');

// Breeze auth routes (login, register, password reset, email verification)
require __DIR__.'/auth.php';

/*
|==========================================================================
| TENANT ROUTES — Public UMKM Storefronts
|==========================================================================
|
| IMPORTANT: This group MUST be registered last to avoid catching
| other routes like /login, /register, /dashboard, etc.
|
*/

Route::middleware(['tenant'])
    ->prefix('{tenant}')
    ->group(function () {

        // Tenant storefront homepage
        Route::get('/', [TenantPageController::class, 'show'])
            ->name('tenant.show');

        // Product detail page
        Route::get('/produk/{produk}', [TenantPageController::class, 'produkDetail'])
            ->name('tenant.produk.detail');

        // Checkout flow (public — no auth required)
        Route::get('/checkout/{produk}', [TenantOrderController::class, 'create'])
            ->name('tenant.checkout');

        Route::post('/checkout/{produk}', [TenantOrderController::class, 'store'])
            ->name('tenant.checkout.store');

        // Order success / confirmation page
        Route::get('/order/{order}/success', [TenantOrderController::class, 'success'])
            ->name('tenant.order.success');
    });
