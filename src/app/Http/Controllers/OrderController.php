<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class OrderController extends Controller
{
    public function index(): View
    {
        $tenantId = auth()->user()->tenant_id;

        $stats = [
            'total' => \App\Models\Order::where('tenant_id', $tenantId)->count(),
            'pending' => \App\Models\Order::where('tenant_id', $tenantId)->where('status', 'pending')->count(),
            'completed' => \App\Models\Order::where('tenant_id', $tenantId)->where('status', 'completed')->count(),
        ];

        $thisWeekCount = \App\Models\Order::where('tenant_id', $tenantId)
            ->where('created_at', '>=', now()->startOfWeek())
            ->count();

        $lastWeekCount = \App\Models\Order::where('tenant_id', $tenantId)
            ->whereBetween('created_at', [
                now()->subWeek()->startOfWeek(),
                now()->subWeek()->endOfWeek(),
            ])
            ->count();

        $weekDelta = $lastWeekCount > 0
            ? round((($thisWeekCount - $lastWeekCount) / $lastWeekCount) * 100)
            : ($thisWeekCount > 0 ? 100 : 0);

        $orders = \App\Models\Order::where('tenant_id', $tenantId)
            ->search(request('search'))
            ->status(request('status'))
            ->with(['invoice', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('order.index', compact('orders', 'stats', 'thisWeekCount', 'weekDelta'));
    }

    public function show(Order $order): View
    {
        $this->authorizeTenant($order);

        $order->load(['orderItems.produk', 'invoice']);

        return view('order.show', compact('order'));
    }

    public function update(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        $newStatus = $request->validated()['status'];
        $oldStatus = $order->status;
        $order->update(['status' => $newStatus]);

        if ($order->invoice) {
            match ($newStatus) {
                'completed' => $order->invoice->update(['status_pembayaran' => 'paid']),
                'cancelled' => $order->invoice->update(['status_pembayaran' => 'cancelled']),
                'processing' => $order->invoice->update(['status_pembayaran' => 'unpaid']),
                default => null,
            };
        }

        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $order->load('orderItems.produk');

            foreach ($order->orderItems as $item) {
                $item->produk?->increment('stok', $item->jumlah);
                if ($item->produk && ! $item->produk->status) {
                    $item->produk->update(['status' => true]);
                }
            }
        }

        return redirect()
            ->route('order.show', $order)
            ->with('success', 'Status order berhasil diperbarui menjadi "'.$newStatus.'".');
    }

    public function markPaid(Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan dengan status pending yang bisa ditandai lunas.');
        }

        DB::transaction(function () use ($order) {
            $order->update(['status' => 'paid']);
            $order->invoice?->update(['status_pembayaran' => 'paid']);
        });

        return back()->with('success', 'Pesanan ditandai Lunas. Sekarang hubungi pembeli via WhatsApp untuk konfirmasi pengiriman.');
    }

    public function ship(\Illuminate\Http\Request $request, Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        $request->validate([
            'ekspedisi' => ['required', 'string', 'max:50'],
            'nomor_resi' => ['required', 'string', 'max:100'],
        ]);

        if (! in_array($order->status, ['paid', 'processing'], true)) {
            return back()->with('error', 'Pesanan belum dibayar atau sudah selesai.');
        }

        $order->update([
            'status' => 'shipped',
            'ekspedisi' => $request->ekspedisi,
            'nomor_resi' => $request->nomor_resi,
            'shipped_at' => now(),
        ]);

        return back()->with('success', "Pesanan ditandai dikirim via {$request->ekspedisi}. Bagikan resi ke pembeli via WhatsApp.");
    }

    public function complete(Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        if ($order->status !== 'shipped') {
            return back()->with('error', 'Hanya pesanan yang sudah dikirim yang bisa diselesaikan.');
        }

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Pesanan selesai. Terima kasih!');
    }

    public function cancel(Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        if (! in_array($order->status, ['pending', 'paid', 'processing'], true)) {
            return back()->with('error', 'Pesanan ini tidak bisa dibatalkan.');
        }

        DB::transaction(function () use ($order) {
            foreach ($order->orderItems as $item) {
                if ($item->produk) {
                    $item->produk->increment('stok', $item->jumlah);
                    if (! $item->produk->status) {
                        $item->produk->update(['status' => true]);
                    }
                }
            }

            $order->update(['status' => 'cancelled']);
            $order->invoice?->update(['status_pembayaran' => 'cancelled']);
        });

        return back()->with('success', 'Pesanan dibatalkan dan stok dikembalikan.');
    }

    public function export(): StreamedResponse
    {
        $tenantId = auth()->user()->tenant_id;

        $orders = \App\Models\Order::where('tenant_id', $tenantId)
            ->search(request('search'))
            ->status(request('status'))
            ->with(['invoice', 'orderItems.produk'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'orders-'.now()->format('Y-m-d-His').'.csv';

        $callback = function () use ($orders) {
            $out = fopen('php://output', 'w');

            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'Kode Order',
                'Tanggal',
                'Nomor Invoice',
                'Nama Pembeli',
                'Email',
                'WhatsApp',
                'Total (Rp)',
                'Status Order',
                'Status Pembayaran',
                'Ekspedisi',
                'No. Resi',
                'Items',
            ]);

            foreach ($orders as $order) {
                $items = $order->orderItems->map(function ($item) {
                    $name = $item->produk?->nama_produk ?? 'Produk dihapus';
                    $line = "{$name} x{$item->jumlah}";
                    if ($item->varian) {
                        $line .= " ({$item->varian})";
                    }

                    return $line;
                })->implode(' | ');

                fputcsv($out, [
                    $order->kode_order,
                    $order->created_at->format('Y-m-d H:i'),
                    $order->invoice?->nomor_invoice ?? '-',
                    $order->nama_pembeli,
                    $order->email_pembeli,
                    $order->no_hp_pembeli ?? '-',
                    $order->total_harga,
                    $order->status,
                    $order->invoice?->status_pembayaran ?? '-',
                    $order->ekspedisi ?? '-',
                    $order->nomor_resi ?? '-',
                    $items,
                ]);
            }

            fputcsv($out, []);
            fputcsv($out, ['--- RINGKASAN ---']);
            fputcsv($out, ['Total pesanan', $orders->count()]);
            fputcsv($out, [
                'Total pesanan lunas (Rp)',
                $orders->filter(fn ($o) => $o->invoice?->status_pembayaran === 'paid')->sum('total_harga'),
            ]);
            fputcsv($out, [
                'Total pesanan belum bayar (Rp)',
                $orders->filter(fn ($o) => $o->invoice?->status_pembayaran === 'unpaid')->sum('total_harga'),
            ]);
            fputcsv($out, ['Periode export', now()->format('Y-m-d H:i')]);

            fclose($out);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }

    protected function authorizeTenant(Order $order): void
    {
        abort_if($order->tenant_id !== auth()->user()->tenant_id, 403);
    }
}
