<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-2">
            
            <div class="flex flex-col">
                <h1 class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5">Daftar Pesanan</h1>
                <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C] leading-snug">
                    Manage and track your customer orders with precision.<br>
                    Recent activity shows a <span class="text-[#2E5136] font-bold">+12% increase</span> this week.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                 <button class="bg-white border border-[#E8EBED] hover:bg-gray-50 text-[#1A1C19] flex items-center justify-center gap-2 px-5 py-[12px] rounded-full text-[13.5px] font-bold transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
                     <svg class="w-4 h-4 text-gray-500 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                     Export
                 </button>
                 <button class="bg-[#2E5136] hover:bg-[#1f3824] text-white flex items-center justify-center gap-2 px-6 py-[12px] rounded-full text-[13.5px] font-bold transition-all shadow-[0_4px_12px_rgb(46,81,54,0.2)]">
                     <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                     New Order
                 </button>
            </div>
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full lg:pr-4 xl:pr-8 pb-12 flex flex-col h-full mt-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">TOTAL ORDERS</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5">{{ $orders->total() }}</span>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">PENDING</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5">{{ $orders->where('status','pending')->count() }}</span>
                        @if($orders->where('status','pending')->count() > 0)
                            <span class="text-[#f59e0b] text-[10.5px] font-bold mb-1">Action needed</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">COMPLETED</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5">{{ $orders->where('status','completed')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Toolbar (Search & Filters) --}}
        <form action="{{ route('order.index') }}" method="GET">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
            {{-- Filter Pills --}}
            <div class="flex items-center bg-[#f9fafb] border border-[#E8EBED] rounded-full p-[5px] shadow-[inset_0_1px_2px_rgb(0,0,0,0.01)] overflow-x-auto hide-scroll shrink-0">
                @foreach(['' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $val => $label)
                    <button type="submit" name="status" value="{{ $val }}"
                        class="{{ request('status') === $val || ($val === '' && !request('status')) ? 'bg-white text-[#1A1C19] shadow-sm' : 'text-gray-400 hover:text-[#1A1C19]' }} px-[18px] py-1.5 rounded-full text-[13px] font-bold transition-colors whitespace-nowrap">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
            {{-- Search --}}
            <div class="relative w-full lg:max-w-[420px]">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                    <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-12 pr-5 h-12 border border-[#E8EBED] rounded-full text-[13px] font-bold text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] transition-colors placeholder:text-gray-300 placeholder:font-medium shadow-sm outline-none" placeholder="Search Order ID or Customer..." />
            </div>
        </div>
        </form>

        <!-- Main Card Wrapper for Table -->
        <div class="bg-white border border-[#E8EBED] rounded-[1.5rem] shadow-[0_2px_12px_rgb(0,0,0,0.02)] flex flex-col flex-1 overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#E8EBED] bg-white">
                            <th class="py-5 px-6 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap min-w-[140px]">ORDER ID</th>
                            <th class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap min-w-[220px]">CUSTOMER NAME</th>
                            <th class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap w-[150px]">DATE</th>
                            <th class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap w-[150px]">TOTAL</th>
                            <th class="py-5 px-4 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap w-[130px]">STATUS</th>
                            <th class="py-5 px-6 font-bold text-[10px] tracking-[0.15em] text-[#aab2bf] uppercase whitespace-nowrap text-right w-[100px]">ACTION</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8EBED]/60">
                        @forelse($orders as $order)
                        @php
                            $statusMap = [
                                'pending'    => ['bg-[#fffbeb] text-[#d97706]', '#d97706'],
                                'confirmed'  => ['bg-blue-50 text-blue-600', '#3b82f6'],
                                'processing' => ['bg-purple-50 text-purple-600', '#9B59B6'],
                                'completed'  => ['bg-[#ecfdf3] text-[#059669]', '#059669'],
                                'cancelled'  => ['bg-red-50 text-red-600', '#ef4444'],
                            ];
                            $sc = $statusMap[$order->status] ?? ['bg-gray-100 text-gray-500', '#9ca3af'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">{{ $order->kode_order }}</div>
                                <div class="text-[11.5px] text-gray-400 mt-0.5">{{ $order->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                    <div class="w-[34px] h-[34px] rounded-full bg-[#EAF2ED] text-[#2E5136] text-[11px] font-bold flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($order->nama_pembeli, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="text-[14px] text-[#1A1C19] font-medium">{{ $order->nama_pembeli }}</div>
                                        <div class="text-[11.5px] text-gray-400">{{ $order->email_pembeli }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">{{ $order->created_at->format('d M Y') }}</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="{{ $sc[0] }} text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full" style="background:{{ $sc[1] }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <a href="{{ route('order.show', $order->id) }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center text-gray-400 text-sm">Belum ada pesanan ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-[22px] flex flex-col md:flex-row items-center justify-between gap-4 mt-auto">
                <div class="text-[13.5px] text-gray-500 font-medium">
                    Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} entries
                </div>
                <div>{{ $orders->withQueryString()->links() }}</div>
            </div>
            
        </div>
        
        <!-- Bottom Disclaimer -->
        <div class="mt-8 mb-4 lg:mb-2 text-center text-[11px] font-medium text-gray-400">
             © 2026 MyLinx. All rights reserved.
        </div>

    </div>
</x-app-layout>
