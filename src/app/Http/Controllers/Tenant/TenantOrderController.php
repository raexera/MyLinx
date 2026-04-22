<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTenantOrderRequest;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TenantOrderController extends Controller
{
    public function create(Tenant $tenant, Produk $produk): View
    {
        if ($produk->tenant_id !== $tenant->id) {
            abort(404);
        }

        if (! $produk->status || $produk->stok <= 0) {
            abort(404, 'Produk tidak tersedia untuk dibeli.');
        }

        $tenant->load('profilUsaha');
        $custom = $tenant->customization_with_defaults;

        return view('tenant.checkout', [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'produk' => $produk,
            'custom' => $custom,
        ]);
    }

    public function store(StoreTenantOrderRequest $request, Tenant $tenant, Produk $produk): RedirectResponse
    {
        abort_if($produk->tenant_id !== $tenant->id || ! $produk->status, 404);

        $selectedVariantsStr = null;

        if ($produk->hasVariants()) {
            $selected = $request->validated('varian');
            if (empty($selected) || ! is_array($selected)) {
                return back()->withInput()->withErrors(['varian' => 'Silakan pilih semua varian produk.']);
            }

            $variantStrings = [];
            foreach ($produk->variants as $index => $group) {
                $options = array_filter(array_map('trim', explode(',', $group['options'])));
                $userChoice = $selected[$index] ?? null;

                if (! $userChoice || ! in_array($userChoice, $options, true)) {
                    return back()->withInput()->withErrors(['varian' => "Pilihan {$group['label']} tidak valid."]);
                }
                $variantStrings[] = $group['label'].': '.$userChoice;
            }
            $selectedVariantsStr = implode(', ', $variantStrings); // Hasil: "Warna: Hitam, Ukuran: XL"
        }

        try {
            $order = DB::transaction(function () use ($request, $tenant, $produk, $selectedVariantsStr) {
                $locked = Produk::where('id', $produk->id)->lockForUpdate()->first();

                if (! $locked || $locked->stok < $request->validated('jumlah')) {
                    throw new \RuntimeException('Stok tidak mencukupi. Silakan kurangi jumlah pesanan.');
                }

                $subtotal = $locked->harga * $request->validated('jumlah');

                $order = Order::create([
                    'tenant_id' => $tenant->id,
                    'kode_order' => $this->generateKodeOrder(),
                    'nama_pembeli' => $request->validated('nama_pembeli'),
                    'email_pembeli' => $request->validated('email_pembeli'),
                    'no_hp_pembeli' => $request->validated('no_hp_pembeli'),
                    'alamat_pengiriman' => $request->validated('alamat_pengiriman'),
                    'catatan_pembeli' => $request->validated('catatan_pembeli'),
                    'total_harga' => $subtotal,
                    'status' => 'pending',
                ]);

                $order->orderItems()->create([
                    'produk_id' => $locked->id,
                    'jumlah' => $request->validated('jumlah'),
                    'varian' => $selectedVariantsStr, // Simpan string hasil kombinasi
                    'harga' => $locked->harga,
                    'subtotal' => $subtotal,
                ]);

                $order->invoice()->create([
                    'nomor_invoice' => $this->generateNomorInvoice(),
                    'qr_code_url' => null,
                    'status_pembayaran' => 'unpaid',
                ]);

                $locked->decrement('stok', $request->validated('jumlah'));

                if ($locked->stok <= 0) {
                    $locked->update(['status' => false]);
                }

                return $order;
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->route('tenant.order.success', [$tenant, $order]);
    }

    public function success(Tenant $tenant, Order $order): View
    {
        if ($order->tenant_id !== $tenant->id) {
            abort(404);
        }

        $order->load(['orderItems.produk', 'invoice']);
        $tenant->load('profilUsaha');
        $custom = $tenant->customization_with_defaults;

        return view('tenant.order-success', [
            'tenant' => $tenant,
            'profil' => $tenant->profilUsaha,
            'order' => $order,
            'invoice' => $order->invoice,
            'custom' => $custom,
        ]);
    }

    private function generateKodeOrder(): string
    {
        do {
            $kode = 'ORD-'.date('Ymd').'-'.strtoupper(Str::random(4));
        } while (Order::where('kode_order', $kode)->exists());

        return $kode;
    }

    private function generateNomorInvoice(): string
    {
        do {
            $nomor = 'INV-'.date('Ymd').'-'.strtoupper(Str::random(4));
        } while (Invoice::where('nomor_invoice', $nomor)->exists());

        return $nomor;
    }
}
