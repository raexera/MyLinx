<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-4">
            
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-[#2E5136] uppercase tracking-[0.15em] mb-3">FINANCIAL OVERVIEW</span>
                <h1 class="text-[2.5rem] sm:text-5xl lg:text-[3.5rem] font-serif text-[#1A1C19] tracking-tight leading-[1.05]">
                    Daftar Pembayaran<br>
                    <span class="text-gray-300 italic font-light font-serif text-[4rem] sm:text-[4.5rem]">&amp;</span> Invoice
                </h1>
            </div>
            
            <div class="flex items-center gap-3 shrink-0 mb-2 sm:mb-4">
                 <button class="bg-white border border-[#E8EBED] hover:bg-gray-50 text-[#1A1C19] flex items-center justify-center gap-2.5 px-6 py-[12px] rounded-full text-[13.5px] font-bold transition-all shadow-[0_2px_10px_rgb(0,0,0,0.02)] h-[46px]">
                     <svg class="w-4 h-4 text-gray-500 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                     Export Report
                 </button>
                 <button class="bg-[#2E5136] hover:bg-[#1f3824] text-white flex items-center justify-center rounded-full w-[46px] h-[46px] transition-all shadow-[0_4px_12px_rgb(46,81,54,0.2)]">
                     <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                 </button>
            </div>
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full lg:pr-4 xl:pr-8 pb-12 flex flex-col h-full mt-2 lg:mt-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Total Revenue</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">
                    Rp {{ number_format($invoices->where('status_pembayaran','paid')->sum(fn($i) => $i->order->total_harga ?? 0), 0, ',', '.') }}
                </div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-[#1fad55]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>{{ $invoices->where('status_pembayaran','paid')->count() }} paid invoices</span>
                </div>
            </div>
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Pending Payments</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">
                    {{ $invoices->where('status_pembayaran','unpaid')->count() }}
                </div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-[#d97706]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Invoices unpaid</span>
                </div>
            </div>
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Total Invoices</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">{{ $invoices->total() }}</div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400">
                    <span>All time</span>
                </div>
            </div>
        </div>

        <!-- Toolbar (Search & Filters) -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5 mb-6">
            
            <!-- Search -->
            <div class="relative w-full lg:max-w-[420px]">
                 <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                     <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                     </svg>
                 </div>
                 <input type="text" class="block w-full pl-12 pr-5 h-12 border border-[#E8EBED] rounded-full text-[13.5px] font-medium text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] transition-colors placeholder:text-gray-400 shadow-[0_2px_10px_rgb(0,0,0,0.01)] outline-none" placeholder="Search by Invoice ID or Order ID..." />
            </div>

            <!-- Right side: Filters -->
            <div class="flex items-center justify-between w-full lg:w-auto gap-4">
                 <!-- Filter Pills -->
                 <div class="flex items-center gap-2 overflow-x-auto hide-scroll shrink-0">
                     <button class="bg-[#1A1C19] text-white hover:bg-black px-6 py-[11px] rounded-full text-[13px] font-bold transition-colors shadow-sm whitespace-nowrap">All Status</button>
                     <button class="bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:border-gray-300 px-6 py-[11px] rounded-full text-[13px] font-bold transition-colors shadow-sm whitespace-nowrap">Paid</button>
                     <button class="bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:border-gray-300 px-6 py-[11px] rounded-full text-[13px] font-bold transition-colors shadow-sm whitespace-nowrap">Unpaid</button>
                     <button class="bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:border-gray-300 px-6 py-[11px] rounded-full text-[13px] font-bold transition-colors shadow-sm whitespace-nowrap">Refunded</button>
                 </div>
                 
                 <div class="hidden lg:block w-px h-6 bg-gray-300 mx-2"></div>
                 
                 <!-- Filter Icon Toggle -->
                 <button class="p-2 text-gray-400 hover:text-[#1A1C19] transition-colors shrink-0">
                     <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                 </button>
            </div>
            
        </div>

        <!-- Main Card Wrapper for Table -->
        <div class="bg-white border border-[#E8EBED] rounded-t-[1.5rem] lg:rounded-[1.5rem] shadow-[0_2px_12px_rgb(0,0,0,0.02)] flex flex-col flex-1 overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead>
                        <tr class="border-b border-[#E8EBED] bg-white">
                            <th class="py-6 px-8 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap">INVOICE ID</th>
                            <th class="py-6 px-4 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap">ORDER ID</th>
                            <th class="py-6 px-4 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap">AMOUNT</th>
                            <th class="py-6 px-4 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap">STATUS</th>
                            <th class="py-6 px-4 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap">DATE</th>
                            <th class="py-6 px-8 font-bold text-[10.5px] tracking-[0.1em] text-[#aab2bf] uppercase whitespace-nowrap text-right">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8EBED]/60">
                        @forelse($invoices as $invoice)
                        @php
                            $payMap = [
                                'paid'      => ['bg-[#ecfdf3] text-[#059669]', '#059669'],
                                'unpaid'    => ['bg-[#fffbeb] text-[#d97706]', '#d97706'],
                                'cancelled' => ['bg-red-50 text-red-500', '#ef4444'],
                            ];
                            $pc = $payMap[$invoice->status_pembayaran] ?? ['bg-gray-100 text-gray-500', '#9ca3af'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-block shadow-sm">
                                    {{ $invoice->nomor_invoice }}
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <a href="{{ route('order.show', $invoice->order) }}" class="text-[12.5px] text-[#2E5136] font-medium hover:underline">
                                    {{ $invoice->order->kode_order }}
                                </a>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19]">Rp {{ number_format($invoice->order->total_harga, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="{{ $pc[0] }} text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full" style="background:{{ $pc[1] }}"></span>
                                    {{ ucfirst($invoice->status_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">{{ $invoice->created_at->format('d M, Y') }}</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <a href="{{ route('order.show', $invoice->order) }}" class="inline-flex items-center gap-1 text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center text-gray-400 text-sm">Belum ada invoice.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 sm:px-8 py-[22px] flex flex-col md:flex-row items-center justify-between gap-4 mt-auto border-t border-[#E8EBED]">
                <div class="text-[13px] text-gray-500 font-medium">
                    Showing {{ $invoices->firstItem() ?? 0 }}-{{ $invoices->lastItem() ?? 0 }} of {{ $invoices->total() }} invoices
                </div>
                <div>{{ $invoices->links() }}</div>
            </div>
            
        </div>
        
        <!-- Bottom Disclaimer -->
        <div class="mt-6 text-center text-[10.5px] font-medium text-gray-400">
             © 2026 MyLinx. All rights reserved. Privacy Policy
        </div>

    </div>
</x-app-layout>
