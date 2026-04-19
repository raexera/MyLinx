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

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware(['auth', 'verified', 'has.tenant'])->group(function () {

    Route::resource('produk', ProdukController::class)
        ->except(['show']);

    Route::get('/profil-usaha', [ProfilUsahaController::class, 'edit'])
        ->name('profil-usaha.edit');
    Route::patch('/profil-usaha', [ProfilUsahaController::class, 'update'])
        ->name('profil-usaha.update');
    Route::delete('/profil-usaha/qris', [ProfilUsahaController::class, 'removeQris'])
        ->name('profil-usaha.remove-qris');

    Route::resource('portfolio', PortofolioController::class)
        ->except(['show', 'create']);

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/export', [OrderController::class, 'export'])->name('order.export');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::patch('/order/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::patch('/order/{order}/mark-paid', [OrderController::class, 'markPaid'])->name('order.mark-paid');
    Route::patch('/order/{order}/ship', [OrderController::class, 'ship'])->name('order.ship');
    Route::patch('/order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');
    Route::patch('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    Route::get('/settings/website', [SettingController::class, 'editWebsite'])
        ->name('settings.website');
    Route::patch('/settings/website', [SettingController::class, 'updateWebsite'])
        ->name('settings.website.update');
    Route::get('/settings/website/check-slug', [SettingController::class, 'checkSlug'])
        ->name('settings.website.check-slug');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/invoice/{token}', [PublicInvoiceController::class, 'show'])
    ->name('public.invoice')
    ->where('token', '[A-Za-z0-9]{32}');

require __DIR__.'/auth.php';

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
