<?php

use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\ProfilUsahaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
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

    // ── Settings (placeholder views) ────────────────────────
    Route::get('/settings/website', function () {
        return view('settings.website');
    })->name('settings.website');

    Route::get('/settings/template', function () {
        return view('settings.template');
    })->name('settings.template');

    // ── Portofolio CRUD ─────────────────────────────────────
    Route::resource('portfolio', PortofolioController::class)
        ->except(['show', 'create']);

    // ── Order (placeholder views) ───────────────────────────
    Route::get('/order', function () {
        return view('order.index');
    })->name('order.index');

    Route::get('/order/detail', function () {
        return view('order.show');
    })->name('order.show');

    // ── Payment (placeholder view) ──────────────────────────
    Route::get('/payment', function () {
        return view('payment.index');
    })->name('payment.index');
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
    });
