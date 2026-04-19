<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        }

        return $this->tenantDashboard($user);
    }

    private function tenantDashboard(User $user): View
    {
        $tenantId = $user->tenant_id;

        $totalRevenue = Order::where('tenant_id', $tenantId)
            ->whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'paid'))
            ->sum('total_harga');

        $ordersThisMonth = Order::where('tenant_id', $tenantId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $activeProducts = Produk::where('tenant_id', $tenantId)
            ->where('status', true)
            ->count();

        $totalProducts = Produk::where('tenant_id', $tenantId)->count();

        $recentOrders = Order::where('tenant_id', $tenantId)
            ->with(['invoice', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pendingOrders = Order::where('tenant_id', $tenantId)
            ->where('status', 'pending')
            ->count();

        return view('dashboard', compact(
            'totalRevenue',
            'ordersThisMonth',
            'activeProducts',
            'totalProducts',
            'recentOrders',
            'pendingOrders',
        ));
    }

    private function superAdminDashboard(): View
    {
        $totalTenants = Tenant::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'paid'))
            ->sum('total_harga');

        $recentTenants = Tenant::with('profilUsaha')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalTenants',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'recentTenants',
        ));
    }
}
