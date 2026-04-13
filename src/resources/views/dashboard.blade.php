<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-1.5 pl-1">
                <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">
                    @if(Auth::user()->isSuperAdmin()) SUPER ADMIN @else SELLER DASHBOARD @endif
                </span>
            </div>
            <h1 class="text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Dashboard</h1>
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-green-50 border border-green-100 px-5 py-3 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->isTenantAdmin())

    {{-- ── TENANT ADMIN DASHBOARD ─────────────────────────────── --}}

    {{-- 1. Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        {{-- Total Revenue --}}
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Revenue</div>
                <div class="text-[1.6rem] font-serif text-[#1A1C19] tracking-wide">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </div>
            </div>
        </div>

        {{-- Orders This Month --}}
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                @if($pendingOrders > 0)
                    <span class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingOrders }} pending</span>
                @endif
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Orders This Month</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">{{ $ordersThisMonth }}</div>
            </div>
        </div>

        {{-- Active Products --}}
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2.5 py-0.5 rounded-full">dari {{ $totalProducts }}</span>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Produk Aktif</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">{{ $activeProducts }}</div>
            </div>
        </div>

        {{-- Pending Orders --}}
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-orange-50 text-orange-500 flex items-center justify-center border border-orange-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Pending Orders</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">{{ $pendingOrders }}</div>
            </div>
        </div>

    </div>

    {{-- 2. Recent Orders Table --}}
    <div class="bg-white rounded-[2rem] px-8 py-8 shadow-sm border border-[#E8EBED] flex flex-col mb-8">

        <div class="flex justify-between items-center mb-8 px-2">
            <h2 class="text-2xl font-serif text-[#1A1C19]">Recent Orders</h2>
            <a href="{{ route('order.index') }}" class="text-[10px] font-bold text-[#2E5136] uppercase tracking-[0.15em] flex items-center gap-1.5 hover:text-[#1f3824] transition-colors">
                VIEW ALL
                <svg class="w-[14px] h-[14px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3] pl-2">ORDER ID</th>
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3]">CUSTOMER</th>
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3]">AMOUNT</th>
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3]">PAYMENT</th>
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3]">STATUS</th>
                        <th class="py-5 px-4 whitespace-nowrap font-bold border-b border-[#F0F2F3] text-right pr-2">ACTION</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#F0F2F3]">
                        <td class="py-5 px-4 pl-2 font-medium text-gray-600 text-[13px]">{{ $order->kode_order }}</td>
                        <td class="py-5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-[34px] h-[34px] rounded-full bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center text-[10px] tracking-wider font-bold">
                                    {{ strtoupper(substr($order->nama_pembeli, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="font-bold text-[#1A1C19] text-[13px] leading-tight">{{ $order->nama_pembeli }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4 font-semibold text-[13px] text-[#1A1C19]">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4">
                            @if($order->invoice?->status_pembayaran === 'paid')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-green-100/50">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#34C759]"></span> PAID
                                </span>
                            @elseif($order->invoice?->status_pembayaran === 'cancelled')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-50 text-red-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-red-100/50">
                                    <span class="w-[5px] h-[5px] rounded-full bg-red-500"></span> CANCELLED
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-orange-100/50">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#FFB800]"></span> UNPAID
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-4">
                            @php
                                $statusMap = [
                                    'pending'    => ['bg-orange-50 text-orange-600 border-orange-100/50', '#FFB800'],
                                    'confirmed'  => ['bg-blue-50 text-blue-600 border-blue-100/50', '#007AFF'],
                                    'processing' => ['bg-purple-50 text-purple-600 border-purple-100/50', '#9B59B6'],
                                    'completed'  => ['bg-green-50 text-green-600 border-green-100/50', '#34C759'],
                                    'cancelled'  => ['bg-red-50 text-red-600 border-red-100/50', '#FF3B30'],
                                ];
                                $sc = $statusMap[$order->status] ?? ['bg-gray-50 text-gray-500 border-gray-100', '#9ca3af'];
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 {{ $sc[0] }} text-[9px] font-bold uppercase tracking-widest rounded-full border">
                                <span class="w-[5px] h-[5px] rounded-full" style="background:{{ $sc[1] }}"></span>
                                {{ $order->status }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-right pr-2">
                            <a href="{{ route('order.show', $order) }}" class="text-gray-400 hover:text-[#2E5136] font-bold text-[12px] transition-colors">Detail →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400 text-sm">Belum ada pesanan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @elseif(Auth::user()->isSuperAdmin())

    {{-- ── SUPER ADMIN DASHBOARD ─────────────────────────────── --}}

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center mb-6">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Tenants</div>
            <div class="text-[1.8rem] font-serif text-[#1A1C19]">{{ $totalTenants }}</div>
        </div>
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100 mb-6">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Users</div>
            <div class="text-[1.8rem] font-serif text-[#1A1C19]">{{ $totalUsers }}</div>
        </div>
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100 mb-6">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Orders</div>
            <div class="text-[1.8rem] font-serif text-[#1A1C19]">{{ $totalOrders }}</div>
        </div>
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center mb-6">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Revenue</div>
            <div class="text-[1.6rem] font-serif text-[#1A1C19]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
    </div>

    {{-- Recent Tenants --}}
    <div class="bg-white rounded-[2rem] px-8 py-8 shadow-sm border border-[#E8EBED]">
        <h2 class="text-2xl font-serif text-[#1A1C19] mb-8">Recent Tenants</h2>
        <div class="divide-y divide-[#F0F2F3]">
            @forelse($recentTenants as $tenant)
            <div class="flex items-center justify-between py-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center text-sm font-bold">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-[13px] text-[#1A1C19]">{{ $tenant->nama_tenant }}</div>
                        <div class="text-[12px] text-gray-400">{{ $tenant->profilUsaha?->nama_usaha ?? 'Belum mengisi profil' }}</div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-[12px] text-gray-400">{{ $tenant->created_at->format('d M Y') }}</div>
                    <a href="{{ url('/' . $tenant->slug) }}" target="_blank" class="text-[11px] font-bold text-[#2E5136] hover:underline">{{ $tenant->slug }}</a>
                </div>
            </div>
            @empty
            <p class="py-8 text-center text-gray-400 text-sm">Belum ada tenant terdaftar.</p>
            @endforelse
        </div>
    </div>

    @endif

</x-app-layout>
