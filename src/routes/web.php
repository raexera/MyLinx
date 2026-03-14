<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Tenant\TenantPageController;
use Illuminate\Support\Facades\Route;

/*
|==========================================================================
| CENTRAL ROUTES — MyLinx Platform
|==========================================================================
|
| These routes handle the main MyLinx platform: landing page, auth,
| and the authenticated dashboard. They are NOT tenant-scoped.
|
*/

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Authenticated area (Breeze provides login/register/password routes via routes/auth.php)
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — redirects tenant_admin to their tenant, super_admin sees platform overview
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/settings/website', function () {
        return view('settings.website');
    })->name('settings.website');

    Route::get('/settings/template', function () {
        return view('settings.template');
    })->name('settings.template');

    Route::get('/portfolio/builder', function () {
        return view('portfolio.builder');
    })->name('portfolio.builder');

    Route::get('/produk', function () {
        return view('produk.index');
    })->name('produk.index');

    Route::get('/produk/create', function () {
        return view('produk.create');
    })->name('produk.create');

    Route::get('/order', function () {
        return view('order.index');
    })->name('order.index');

    Route::get('/order/detail', function () {
        return view('order.show');
    })->name('order.show');

    Route::get('/payment', function () {
        return view('payment.index');
    })->name('payment.index');
});

// Breeze profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze auth routes (login, register, password reset, email verification)
require __DIR__ . '/auth.php';

/*
|==========================================================================
| TENANT ROUTES — Public UMKM Storefronts
|==========================================================================
|
| These routes handle the dynamically generated tenant pages.
| Accessed via path-based slugs: mylinx.com/{tenant_slug}
|
| Route Model Binding resolves {tenant} using Tenant::getRouteKeyName()
| which returns 'slug' (defined in the Tenant model).
|
| The 'tenant' middleware (IdentifyTenantBySlug) handles:
| - 404 if slug doesn't exist (Route Model Binding)
| - 404 if tenant status is inactive
| - Binding the Tenant instance into the Service Container
|
| IMPORTANT: This group MUST be registered last to avoid catching
| other routes like /login, /register, /dashboard, etc.
|
*/

Route::middleware(['tenant'])
    ->prefix('{tenant}')
    ->group(function () {

        // Tenant storefront homepage (profil usaha + products)
        Route::get('/', [TenantPageController::class, 'show'])
            ->name('tenant.show');

        // Future tenant sub-pages can be added here:
        // Route::get('/produk/{produk}', [TenantPageController::class, 'produkDetail'])
        //     ->name('tenant.produk.detail');
        //
        // Route::get('/portofolio', [TenantPageController::class, 'portofolio'])
        //     ->name('tenant.portofolio');
        //
        // Route::post('/order', [TenantOrderController::class, 'store'])
        //     ->name('tenant.order.store');
    });
