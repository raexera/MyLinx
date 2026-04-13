<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenantOrderRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantOrderController extends Controller
{
    /**
     * Show the checkout form for a specific product.
     *
     * Validates:
     * - Product belongs to this tenant
     * - Product is active (status = true)
     * - Product is in stock (stok > 0)
     */
    public function create(Tenant $tenant, Produk $produk): View
    {
        // Ensure product belongs to this tenant
        if ($produk->tenant_id !== $tenant->id) {
            abort(404);
        }

        // Ensure product is available for purchase
        if (! $produk->status || $produk->stok <= 0) {
            abort(404, 'Produk tidak tersedia untuk dibeli.');
        }

        // Load tenant profile for the checkout page layout
        $tenant->load(['profilUsaha', 'template']);

        $templateSlug = $tenant->template?->slug_key ?? 'minimalist';
        $viewName     = "tenant.templates.{$templateSlug}.checkout";

        if (! view()->exists($viewName)) {
            $viewName = 'tenant.templates.minimalist.checkout';
        }

        return view($viewName, [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'produk' => $produk,
        ]);
    }

    /**
     * Process the checkout and create an order.
     *
     * This method uses a strict database transaction with pessimistic locking
     * to prevent race conditions when multiple buyers checkout simultaneously.
     *
     * Transaction steps:
     * 1. Lock the product row (SELECT ... FOR UPDATE)
     * 2. Validate stock availability
     * 3. Calculate total on the backend (NEVER trust frontend prices)
     * 4. Create Order
     * 5. Create OrderItem
     * 6. Decrement product stock
     * 7. Create Invoice
     */
    public function store(StoreTenantOrderRequest $request, Tenant $tenant, Produk $produk): RedirectResponse
    {
        // Pre-transaction validation: product belongs to tenant
        if ($produk->tenant_id !== $tenant->id) {
            abort(404);
        }

        $validated = $request->validated();

        /** @var Order $order */
        $order = DB::transaction(function () use ($validated, $tenant, $produk) {

            // ── Step 1: Pessimistic lock on the product row ──────────
            // This prevents other concurrent transactions from reading
            // stale stock data until this transaction completes.
            $lockedProduk = Produk::where('id', $produk->id)->lockForUpdate()->first();

            // ── Step 2: Validate stock against the locked row ────────
            // The stock might have changed between page load and submission.
            if (! $lockedProduk || ! $lockedProduk->status || $lockedProduk->stok <= 0) {
                abort(400, 'Produk tidak lagi tersedia.');
            }

            $jumlah = (int) $validated['jumlah'];

            if ($jumlah > $lockedProduk->stok) {
                abort(400, 'Stok tidak mencukupi. Tersisa '.$lockedProduk->stok.' unit.');
            }

            // ── Step 3: Calculate total on the backend ───────────────
            // CRITICAL: We use the database price, NOT any price from the form.
            $hargaSatuan = $lockedProduk->harga;
            $subtotal = $hargaSatuan * $jumlah;
            $totalHarga = $subtotal;

            // ── Step 4: Create the Order ─────────────────────────────
            $order = Order::create([
                'tenant_id' => $tenant->id,
                'kode_order' => $this->generateKodeOrder(),
                'nama_pembeli' => $validated['nama_pembeli'],
                'email_pembeli' => $validated['email_pembeli'],
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            // ── Step 5: Create the OrderItem ─────────────────────────
            OrderItem::create([
                'order_id' => $order->id,
                'produk_id' => $lockedProduk->id,
                'jumlah' => $jumlah,
                'harga' => $hargaSatuan,
                'subtotal' => $subtotal,
            ]);

            // ── Step 6: Decrement product stock ──────────────────────
            $lockedProduk->decrement('stok', $jumlah);

            // Auto-deactivate product if stock reaches zero
            if ($lockedProduk->fresh()->stok <= 0) {
                $lockedProduk->update(['status' => false]);
            }

            // ── Step 7: Create the Invoice ───────────────────────────
            Invoice::create([
                'order_id' => $order->id,
                'nomor_invoice' => $this->generateNomorInvoice(),
                'qr_code_url' => null,
                'status_pembayaran' => 'unpaid',
            ]);

            return $order;
        });

        // ── Redirect to success page ─────────────────────────────────
        return redirect()
            ->route('tenant.order.success', [
                'tenant' => $tenant,
                'order' => $order,
            ])
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Display the order success / confirmation page.
     *
     * Shows order summary, invoice number, and payment instructions.
     */
    public function success(Tenant $tenant, Order $order): View
    {
        // Ensure the order belongs to this tenant
        if ($order->tenant_id !== $tenant->id) {
            abort(404);
        }

        // Eager-load relationships for the confirmation page
        $order->load(['orderItems.produk', 'invoice']);
        $tenant->load(['profilUsaha', 'template']);

        $templateSlug = $tenant->template?->slug_key ?? 'minimalist';
        $viewName     = "tenant.templates.{$templateSlug}.order-success";

        if (! view()->exists($viewName)) {
            $viewName = 'tenant.templates.minimalist.order-success';
        }

        return view($viewName, [
            'tenant'  => $tenant,
            'profil'  => $tenant->profilUsaha,
            'order'   => $order,
            'invoice' => $order->invoice,
        ]);
    }

    /**
     * Generate a unique order code.
     * Format: ORD-YYYYMMDD-XXXX (e.g. ORD-20260325-A7K2)
     */
    private function generateKodeOrder(): string
    {
        do {
            $kode = 'ORD-'.date('Ymd').'-'.strtoupper(Str::random(4));
        } while (Order::where('kode_order', $kode)->exists());

        return $kode;
    }

    /**
     * Generate a unique invoice number.
     * Format: INV-YYYYMMDD-XXXX (e.g. INV-20260325-B3M9)
     */
    private function generateNomorInvoice(): string
    {
        do {
            $nomor = 'INV-'.date('Ymd').'-'.strtoupper(Str::random(4));
        } while (Invoice::where('nomor_invoice', $nomor)->exists());

        return $nomor;
    }
}
