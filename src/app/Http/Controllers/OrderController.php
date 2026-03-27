<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderStatusRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display the list of orders for the current tenant.
     *
     * Eager-loads invoice and orderItems for display in the table
     * (status badges, total, payment status).
     */
    public function index(): View
    {
        $orders = Order::where('tenant_id', auth()->user()->tenant_id)
            ->with(['invoice', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('order.index', compact('orders'));
    }

    /**
     * Display the detail view for a specific order.
     *
     * TENANCY RULE: Abort 403 if the order doesn't belong to the user's tenant.
     */
    public function show(Order $order): View
    {
        $this->authorizeTenant($order);

        $order->load(['orderItems.produk', 'invoice']);

        return view('order.show', compact('order'));
    }

    /**
     * Update the order status and optionally sync the invoice payment status.
     *
     * Business logic:
     * - When order status is set to 'completed', the invoice is automatically
     *   marked as 'paid'.
     * - When order status is set to 'cancelled', the invoice is marked as
     *   'cancelled' and the product stock is restored.
     *
     * TENANCY RULE: Abort 403 if the order doesn't belong to the user's tenant.
     */
    public function update(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $this->authorizeTenant($order);

        $newStatus = $request->validated()['status'];
        $oldStatus = $order->status;

        // Update the order status
        $order->update(['status' => $newStatus]);

        // Sync invoice payment status based on order status
        if ($order->invoice) {
            match ($newStatus) {
                'completed' => $order->invoice->update(['status_pembayaran' => 'paid']),
                'cancelled' => $order->invoice->update(['status_pembayaran' => 'cancelled']),
                'processing' => $order->invoice->update(['status_pembayaran' => 'unpaid']),
                default => null,
            };
        }

        // Restore stock if order is cancelled (and wasn't already cancelled)
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->produk?->increment('stok', $item->jumlah);

                // Re-activate the product if it was deactivated due to zero stock
                if ($item->produk && ! $item->produk->status) {
                    $item->produk->update(['status' => true]);
                }
            }
        }

        return redirect()
            ->route('order.show', $order)
            ->with('success', 'Status order berhasil diperbarui menjadi "' . $newStatus . '".');
    }

    /**
     * Verify that the given order belongs to the authenticated user's tenant.
     */
    private function authorizeTenant(Order $order): void
    {
        if ($order->tenant_id !== auth()->user()->tenant_id) {
            abort(403, 'Anda tidak memiliki akses ke order ini.');
        }
    }
}
