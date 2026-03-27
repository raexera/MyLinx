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
    /**
     * Display the dashboard with analytics.
     *
     * Routes to different data sets based on the user's role:
     * - tenant_admin: sees their own store metrics
     * - super_admin: sees platform-wide overview
     */
    public function __invoke(): View
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            return $this->superAdminDashboard();
        }

        return $this->tenantDashboard($user);
    }

    /**
     * Tenant Admin Dashboard — store-level metrics.
     */
    private function tenantDashboard(User $user): View
    {
        $tenantId = $user->tenant_id;

        // Total revenue from PAID orders only
        $totalRevenue = Order::where('tenant_id', $tenantId)
            ->whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'paid'))
            ->sum('total_harga');

        // Orders this month
        $ordersThisMonth = Order::where('tenant_id', $tenantId)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Active products count
        $activeProducts = Produk::where('tenant_id', $tenantId)
            ->where('status', true)
            ->count();

        // Total products count (for context)
        $totalProducts = Produk::where('tenant_id', $tenantId)->count();

        // 5 most recent orders with invoice data
        $recentOrders = Order::where('tenant_id', $tenantId)
            ->with(['invoice', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pending orders count (needs attention badge)
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

    /**
     * Super Admin Dashboard — platform-wide overview.
     */
    private function superAdminDashboard(): View
    {
        $totalTenants   = Tenant::count();
        $totalUsers     = User::count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::whereHas('invoice', fn ($q) => $q->where('status_pembayaran', 'paid'))
            ->sum('total_harga');

        // Recent tenants
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
