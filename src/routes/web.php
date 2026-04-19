<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilUsahaController;
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

    // ── Portofolio CRUD ─────────────────────────────────────
    Route::resource('portfolio', PortofolioController::class)
        ->except(['show', 'create']);

    // ── Order Management ─────────────────────────────────────
    Route::get('/order', [OrderController::class, 'index'])
        ->name('order.index');
    Route::get('/order/{order}', [OrderController::class, 'show'])
        ->name('order.show');
    Route::patch('/order/{order}', [OrderController::class, 'update'])
        ->name('order.update');

    // ── Payment / Invoice Tracking ───────────────────────────
    Route::get('/payment', [PaymentController::class, 'index'])
        ->name('payment.index');
    Route::get('/payment/export', [PaymentController::class, 'export'])
        ->name('payment.export');

    // ── Settings (Website & Template) ────────────────────────
    Route::get('/settings/website', [SettingController::class, 'editWebsite'])
        ->name('settings.website');
    Route::patch('/settings/website', [SettingController::class, 'updateWebsite'])
        ->name('settings.website.update');

    Route::get('/settings/template', [SettingController::class, 'editTemplate'])
        ->name('settings.template');
    Route::patch('/settings/template', [SettingController::class, 'updateTemplate'])
        ->name('settings.template.update');

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
