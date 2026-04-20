<x-app-layout>
    <x-slot name="header">
        <div
            class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-2"
        >
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1.5 pl-1">
                    <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                    <span
                        class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]"
                    >
                        @if (Auth::user()->isSuperAdmin())
                            SUPER ADMIN
                        @else
                            SELLER DASHBOARD
                        @endif
                    </span>
                </div>
                <h1
                    class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5"
                >
                    Dashboard
                </h1>
                <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C] leading-snug">
                    @if (Auth::user()->isTenantAdmin())
                        Selamat datang kembali,
                        <span
                            class="font-bold text-[#1A1C19]"
                            >{{ Auth::user()->nama }}</span
                        >. Ini ringkasan toko kamu.
                    @else
                        Platform overview - {{ now()->translatedFormat('l, d F Y') }}
                    @endif
                </p>
            </div>
            @if (Auth::user()->isTenantAdmin() && Auth::user()->tenant)
                <a
                    href="{{ route('tenant.show', Auth::user()->tenant) }}"
                    target="_blank"
                    class="inline-flex items-center gap-2 bg-white border border-[#E8EBED] hover:bg-gray-50 text-[#1A1C19] px-5 py-[11px] rounded-full text-[13px] font-bold transition-all shadow-sm"
                >
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lihat Storefront
                </a>
            @endif
        </div>
    </x-slot>
    @if (session('success'))
        <div
            class="mt-4 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] px-5 py-4 text-[13.5px] font-semibold text-[#065F46] flex items-center gap-3 mb-6"
        >
            <svg class="w-5 h-5 text-[#059669] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div
            class="mt-4 rounded-2xl bg-red-50 border border-red-100 px-5 py-4 text-[13.5px] font-semibold text-red-700 flex items-center gap-3 mb-6"
        >
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            {{ session('error') }}
        </div>
    @endif
    <div class="w-full lg:pr-4 xl:pr-8 pb-12 flex flex-col h-full mt-6">
        @if (Auth::user()->isTenantAdmin())
            <div
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5 mb-8"
            >
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </div>
                        <span
                            class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"
                            >All time</span
                        >
                    </div>
                    <div>
                        <div
                            class="text-[12px] font-semibold text-gray-400 mb-1"
                        >
                            Total Revenue (Paid)
                        </div>
                        <div
                            class="text-[1.6rem] font-serif text-[#1A1C19] tracking-wide"
                        >
                            Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                        </div>
                        @if ($pendingOrders > 0)
                            <a
                                href="{{ route('order.index', ['status' => 'pending']) }}"
                                class="bg-orange-50 text-orange-600 text-[10px] font-bold px-2.5 py-1 rounded-full hover:bg-orange-100 transition-colors"
                            >
                                {{ $pendingOrders }} perlu tindakan
                            </a>
                        @endif
                    </div>
                    <div>
                        <div
                            class="text-[12px] font-semibold text-gray-400 mb-1"
                        >
                            Pesanan Bulan Ini
                        </div>
                        <div
                            class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide"
                        >
                            {{ $ordersThisMonth }}
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        @if ($totalProducts > 0)
                            <span
                                class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2.5 py-1 rounded-full"
                            >
                                {{ $activeProducts }}/{{ $totalProducts }}
                            </span>
                        @endif
                    </div>
                    <div>
                        <div
                            class="text-[12px] font-semibold text-gray-400 mb-1"
                        >
                            Produk Aktif
                        </div>
                        <div
                            class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide"
                        >
                            {{ $activeProducts }}
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div class="flex justify-between items-start mb-6">
                        <div
                            class="w-[42px] h-[42px] rounded-full bg-blue-50 text-blue-500 flex items-center justify-center border border-blue-100"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <span
                            class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"
                            >All time</span
                        >
                    </div>
                    <div>
                        <div
                            class="text-[12px] font-semibold text-gray-400 mb-1"
                        >
                            Page Views
                        </div>
                        <div
                            class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide"
                        >
                            {{ number_format(Auth::user()->tenant->page_views ?? 0) }}
                        </div>
                        <div class="text-[10px] text-gray-400 mt-1">
                            Total pengunjung storefront
                        </div>
                    </div>
                </div>
            </div>
            @if ($recentOrders->isEmpty())
                <div
                    class="bg-white rounded-[2rem] p-10 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] text-center mb-8"
                >
                    <div
                        class="w-16 h-16 rounded-full bg-[#f9fafb] flex items-center justify-center text-3xl mx-auto mb-4"
                    >
                        📦
                    </div>
                    <h3 class="text-xl font-serif text-[#1A1C19] mb-2">
                        Belum Ada Pesanan
                    </h3>
                    <p class="text-sm text-gray-500 max-w-md mx-auto mb-6">Bagikan link storefront kamu ke pelanggan via WhatsApp atau media sosial untuk mulai menerima pesanan.</p>
                    <div
                        class="flex items-center justify-center gap-3 flex-wrap"
                    >
                        <a
                            href="{{ route('produk.index') }}"
                            class="inline-flex items-center gap-2 bg-[#2E5136] hover:bg-[#1f3824] text-white px-5 py-2.5 rounded-full text-[13px] font-bold transition-colors"
                        >
                            Kelola Produk
                        </a>
                        <a
                            href="{{ route('tenant.show', Auth::user()->tenant) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 bg-white border border-[#E8EBED] text-[#1A1C19] px-5 py-2.5 rounded-full text-[13px] font-bold hover:bg-gray-50 transition-colors"
                        >
                            Buka Storefront →
                        </a>
                    </div>
                </div>
            @else
                <div
                    class="bg-white rounded-[2rem] shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col mb-8 overflow-hidden"
                >
                    <div
                        class="flex justify-between items-center px-6 sm:px-8 py-6 border-b border-[#E8EBED]"
                    >
                        <div>
                            <h2 class="text-2xl font-serif text-[#1A1C19]">
                                Pesanan Terbaru
                            </h2>
                            <p class="text-[12px] text-gray-400 mt-1">5 pesanan terakhir dari pelangganmu</p>
                        </div>
                        <a
                            href="{{ route('order.index') }}"
                            class="text-[10px] font-bold text-[#2E5136] uppercase tracking-[0.15em] flex items-center gap-1.5 hover:text-[#1f3824] transition-colors"
                        >
                            LIHAT SEMUA
                            <svg class="w-[14px] h-[14px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                        </a>
                    </div>
                    <div class="hidden md:block w-full overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-white">
                                    <th
                                        class="py-5 px-6 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap min-w-[140px] pl-8"
                                    >
                                        ORDER ID
                                    </th>
                                    <th
                                        class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap min-w-[220px]"
                                    >
                                        CUSTOMER
                                    </th>
                                    <th
                                        class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap w-[150px]"
                                    >
                                        TOTAL
                                    </th>
                                    <th
                                        class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap w-[130px]"
                                    >
                                        STATUS
                                    </th>
                                    <th
                                        class="py-5 px-6 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap text-right w-[100px] pr-8"
                                    >
                                        AKSI
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#E8EBED]/60">
                                @foreach ($recentOrders as $order)
                                    @php
                                    $statusMap = [
                                        'pending'    => ['bg-[#fffbeb] text-[#d97706]', '#d97706'],
                                        'paid'       => ['bg-blue-50 text-blue-600', '#3b82f6'],
                                        'processing' => ['bg-purple-50 text-purple-600', '#9B59B6'],
                                        'shipped'    => ['bg-indigo-50 text-indigo-600', '#6366f1'],
                                        'completed'  => ['bg-[#ecfdf3] text-[#059669]', '#059669'],
                                        'cancelled'  => ['bg-red-50 text-red-600', '#ef4444'],
                                    ];
                                    $sc = $statusMap[$order->status] ?? ['bg-gray-100 text-gray-500', '#9ca3af'];
                                    $payStatus = $order->invoice?->status_pembayaran ?? 'unpaid';
                                @endphp
                                    <tr
                                        class="hover:bg-gray-50/50 transition-colors group cursor-pointer"
                                        onclick="window.location='{{ route('order.show', $order) }}'"
                                    >
                                        <td class="px-6 py-[22px] pl-8">
                                            <div
                                                class="font-medium text-[14px] text-[#1A1C19]"
                                            >
                                                {{ $order->kode_order }}
                                            </div>
                                            <div
                                                class="text-[11.5px] text-gray-400 mt-0.5"
                                            >
                                                {{ $order->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-[22px]">
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div
                                                    class="w-[34px] h-[34px] rounded-full bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center text-[10px] tracking-wider font-bold"
                                                >
                                                    {{ strtoupper(substr($order->nama_pembeli, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div
                                                        class="text-[14px] text-[#1A1C19] font-medium leading-tight truncate"
                                                    >
                                                        {{ $order->nama_pembeli }}
                                                    </div>
                                                    <div
                                                        class="text-[11.5px] text-gray-400 truncate mt-0.5"
                                                    >
                                                        {{ $order->email_pembeli }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-[22px]">
                                            <div
                                                class="font-medium text-[14px] text-[#1A1C19]"
                                            >
                                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                            </div>
                                            @if ($payStatus === 'paid')
                                                <div
                                                    class="text-[11px] font-bold text-green-600 mt-0.5"
                                                >
                                                    Lunas
                                                </div>
                                            @elseif ($payStatus === 'cancelled')
                                                <div
                                                    class="text-[11px] font-bold text-red-500 mt-0.5"
                                                >
                                                    Dibatalkan
                                                </div>
                                            @else
                                                <div
                                                    class="text-[11px] font-bold text-amber-600 mt-0.5"
                                                >
                                                    Belum bayar
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-4 py-[22px]">
                                            <span
                                                class="{{ $sc[0] }} text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max"
                                            >
                                                <span
                                                    class="w-[5px] h-[5px] rounded-full"
                                                    style="background:{{ $sc[1] }}"
                                                ></span>
                                                {{ strtoupper($order->status) }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-6 py-[22px] text-right pr-8"
                                        >
                                            <a
                                                href="{{ route('order.show', $order) }}"
                                                onclick="
                                                    event.stopPropagation()
                                                "
                                                class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto"
                                            >
                                                Detail
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="md:hidden divide-y divide-[#E8EBED]/60">
                        @foreach ($recentOrders as $order)
                            @php
                            $statusMap = [
                                'pending'    => ['bg-[#fffbeb] text-[#d97706]', '#d97706'],
                                'paid'       => ['bg-blue-50 text-blue-600', '#3b82f6'],
                                'processing' => ['bg-purple-50 text-purple-600', '#9B59B6'],
                                'shipped'    => ['bg-indigo-50 text-indigo-600', '#6366f1'],
                                'completed'  => ['bg-[#ecfdf3] text-[#059669]', '#059669'],
                                'cancelled'  => ['bg-red-50 text-red-600', '#ef4444'],
                            ];
                            $sc = $statusMap[$order->status] ?? ['bg-gray-100 text-gray-500', '#9ca3af'];
                        @endphp
                            <a
                                href="{{ route('order.show', $order) }}"
                                class="block p-5 hover:bg-gray-50/50 transition-colors"
                            >
                                <div
                                    class="flex items-start justify-between gap-3 mb-3"
                                >
                                    <div class="min-w-0">
                                        <div
                                            class="font-bold text-[14px] text-[#1A1C19] truncate"
                                        >
                                            {{ $order->nama_pembeli }}
                                        </div>
                                        <div
                                            class="text-[11.5px] text-gray-400 font-mono"
                                        >
                                            {{ $order->kode_order }}
                                        </div>
                                    </div>
                                    <span
                                        class="{{ $sc[0] }} text-[9px] font-bold px-2 py-1 rounded-full flex items-center gap-1.5 shrink-0"
                                    >
                                        <span
                                            class="w-[4px] h-[4px] rounded-full"
                                            style="background:{{ $sc[1] }}"
                                        ></span>
                                        {{ strtoupper($order->status) }}
                                    </span>
                                </div>
                                <div
                                    class="flex items-center justify-between pt-3 border-t border-[#F0F2F3]"
                                >
                                    <span
                                        class="font-bold text-[14px] text-[#1A1C19]"
                                        >Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span
                                    >
                                    <span
                                        class="text-[11.5px] text-gray-400"
                                        >{{ $order->created_at->diffForHumans() }}</span
                                    >
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @elseif (Auth::user()->isSuperAdmin())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-5 mb-8">
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div
                        class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center mb-6"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <div class="text-[12px] font-semibold text-gray-400 mb-1">
                        Total Tenants
                    </div>
                    <div class="text-[1.8rem] font-serif text-[#1A1C19]">
                        {{ $totalTenants }}
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div
                        class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100 mb-6"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div class="text-[12px] font-semibold text-gray-400 mb-1">
                        Total Users
                    </div>
                    <div class="text-[1.8rem] font-serif text-[#1A1C19]">
                        {{ $totalUsers }}
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div
                        class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100 mb-6"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    </div>
                    <div class="text-[12px] font-semibold text-gray-400 mb-1">
                        Total Orders
                    </div>
                    <div class="text-[1.8rem] font-serif text-[#1A1C19]">
                        {{ $totalOrders }}
                    </div>
                </div>
                <div
                    class="bg-white rounded-[1.5rem] p-6 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED] flex flex-col justify-between"
                >
                    <div
                        class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center mb-6"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div class="text-[12px] font-semibold text-gray-400 mb-1">
                        Platform Revenue
                    </div>
                    <div class="text-[1.4rem] font-serif text-[#1A1C19]">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                </div>
            </div>
            <div
                class="bg-white rounded-[2rem] px-6 sm:px-8 py-8 shadow-[0_2px_10px_rgb(0,0,0,0.015)] border border-[#E8EBED]"
            >
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-serif text-[#1A1C19]">
                            Tenant Terbaru
                        </h2>
                        <p class="text-[12px] text-gray-400 mt-1">5 UMKM yang baru bergabung</p>
                    </div>
                </div>
                @if ($recentTenants->isEmpty())
                    <div class="py-12 text-center">
                        <div class="text-3xl mb-3">🏪</div>
                        <p class="text-gray-400 text-sm">Belum ada tenant terdaftar.</p>
                    </div>
                @else
                    <div class="divide-y divide-[#F0F2F3]">
                        @foreach ($recentTenants as $tenant)
                            <div
                                class="flex items-center justify-between py-4 gap-4"
                            >
                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="w-10 h-10 rounded-full bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center text-sm font-bold shrink-0"
                                    >
                                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <div
                                            class="font-bold text-[13px] text-[#1A1C19] truncate"
                                        >
                                            {{ $tenant->nama_tenant }}
                                        </div>
                                        <div
                                            class="text-[12px] text-gray-400 truncate"
                                        >
                                            {{ $tenant->profilUsaha?->alamat ?? 'Belum mengisi profil usaha' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <div class="text-[12px] text-gray-400">
                                        {{ $tenant->created_at->format('d M Y') }}
                                    </div>
                                    <a
                                        href="{{ url('/' . $tenant->slug) }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1 text-[11px] font-bold text-[#2E5136] hover:underline mt-0.5"
                                    >
                                        /{{ $tenant->slug }}
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
