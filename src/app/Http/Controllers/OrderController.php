<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(): View
    {
        $tenantId = auth()->user()->tenant_id;

        $stats = [
            'total'     => \App\Models\Order::where('tenant_id', $tenantId)->count(),
            'pending'   => \App\Models\Order::where('tenant_id', $tenantId)->where('status', 'pending')->count(),
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

    private function authorizeTenant(Order $order): void
    {
        if ($order->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke order ini.');
        }
    }
}
