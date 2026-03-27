<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProfilUsahaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
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
| AUTHENTICATED ROUTES — Tenant Dashboard CMS
|==========================================================================
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ── Produk CRUD ─────────────────────────────────────────
    Route::resource('produk', ProdukController::class)
        ->except(['show']);  // No public show page from dashboard

    // ── Profil Usaha (Edit & Update only) ───────────────────
    Route::get('/profil-usaha', [ProfilUsahaController::class, 'edit'])
        ->name('profil-usaha.edit');
    Route::patch('/profil-usaha', [ProfilUsahaController::class, 'update'])
        ->name('profil-usaha.update');

    // ── Settings (Website & Template) ────────────────────────
    Route::get('/settings/website', [SettingController::class, 'editWebsite'])
        ->name('settings.website');
    Route::patch('/settings/website', [SettingController::class, 'updateWebsite'])
        ->name('settings.website.update');

    Route::get('/settings/template', [SettingController::class, 'editTemplate'])
        ->name('settings.template');
    Route::patch('/settings/template', [SettingController::class, 'updateTemplate'])
        ->name('settings.template.update');

    Route::get('/settings/template', function () {
        return view('settings.template');
    })->name('settings.template');

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
});

// Breeze user account profile (separate from business profile)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze auth routes
require __DIR__ . '/auth.php';

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

        Route::get('/', [TenantPageController::class, 'show'])
            ->name('tenant.show');

        Route::get('/produk/{produk}', [TenantPageController::class, 'produkDetail'])
            ->name('tenant.produk.detail');

        Route::get('/checkout/{produk}', [TenantOrderController::class, 'create'])
            ->name('tenant.checkout');

        Route::post('/checkout/{produk}', [TenantOrderController::class, 'store'])
            ->name('tenant.checkout.store');

        Route::get('/order/{order}/success', [TenantOrderController::class, 'success'])
            ->name('tenant.order.success');
    });
