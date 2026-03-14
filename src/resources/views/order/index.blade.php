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

        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">TOTAL ORDERS</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5">154</span>
                        <span class="bg-[#e4faeb] text-[#1fad55] text-[10.5px] font-bold px-2 py-[2px] rounded-full mb-1">+12%</span>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <!-- Small clock inside calendar logic -->
                    <div class="absolute bottom-6 right-6 bg-white rounded-full">
                         <svg class="w-[72px] h-[72px] text-[#f9fafb]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">PENDING</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5">12</span>
                        <span class="text-[#f59e0b] text-[10.5px] font-bold mb-1">Action needed</span>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-[1.5rem] p-6 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)] relative overflow-hidden group">
                <div class="absolute -right-6 -top-6 text-[#f9fafb] group-hover:scale-110 transition-transform">
                    <svg class="w-40 h-40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="relative z-10 flex flex-col h-full">
                    <h3 class="text-[11.5px] font-bold text-gray-400 tracking-widest uppercase mb-4">REVENUE</h3>
                    <div class="flex items-end gap-3 mt-auto">
                        <span class="text-[2.5rem] font-serif text-[#1A1C19] leading-none mb-0.5 tracking-tight">Rp 45.2jt</span>
                        <span class="bg-[#e4faeb] text-[#1fad55] text-[10.5px] font-bold px-2 py-[2px] rounded-full mb-1">+8%</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Toolbar (Search & Filters) -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
            
            <!-- Filter Pills Group -->
            <div class="flex items-center bg-[#f9fafb] border border-[#E8EBED] rounded-full p-[5px] shadow-[inset_0_1px_2px_rgb(0,0,0,0.01)] overflow-x-auto hide-scroll shrink-0">
                <!-- Active button -->
                <button class="bg-white text-[#1A1C19] px-[22px] py-1.5 rounded-full text-[13px] font-bold shadow-sm whitespace-nowrap">All</button>
                <button class="text-gray-400 hover:text-[#1A1C19] px-[20px] py-1.5 rounded-full text-[13px] font-bold transition-colors whitespace-nowrap">Pending</button>
                <button class="text-gray-400 hover:text-[#1A1C19] px-[20px] py-1.5 rounded-full text-[13px] font-bold transition-colors whitespace-nowrap">Paid</button>
                <button class="text-gray-400 hover:text-[#1A1C19] px-[20px] py-1.5 rounded-full text-[13px] font-bold transition-colors whitespace-nowrap">Expired</button>
            </div>

            <!-- Search -->
            <div class="relative w-full lg:max-w-[420px]">
                 <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                     <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                     </svg>
                 </div>
                 <input type="text" class="block w-full pl-12 pr-5 h-12 border border-[#E8EBED] rounded-full text-[13px] font-bold text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] transition-colors placeholder:text-gray-300 placeholder:font-medium shadow-sm outline-none" placeholder="Search Order ID or Customer..." />
            </div>
            
        </div>

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
                        
                        <!-- Item 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">#MLX-8821</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                     <div class="w-[34px] h-[34px] rounded-full bg-[#eef3ff] text-[#3b82f6] text-[11px] font-bold flex items-center justify-center shrink-0 border border-[#dbe6fe]">BS</div>
                                     <div class="text-[14px] text-[#1A1C19] font-medium">Budi Santoso</div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">Jan 24, 2026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp 450.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                    Paid
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <a href="{{ route('order.show') }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>

                        <!-- Item 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">#MLX-8822</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                     <div class="w-[34px] h-[34px] rounded-full bg-[#fdf2f8] text-[#ec4899] text-[11px] font-bold flex items-center justify-center shrink-0 border border-[#fce7f3]">SA</div>
                                     <div class="text-[14px] text-[#1A1C19] font-medium">Siti Aminah</div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">Jan 24, 2026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp 1.200.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#fffbeb] text-[#d97706] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#d97706]"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <a href="{{ route('order.show') }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>

                        <!-- Item 3 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">#MLX-8820</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                     <div class="w-[34px] h-[34px] rounded-full overflow-hidden shrink-0 border border-[#E8EBED]">
                                         <img src="https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                     </div>
                                     <div class="text-[14px] text-[#1A1C19] font-medium">Joko Widodo</div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">Jan 20, 2026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp 150.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#f3f4f6] text-[#6b7280] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#6b7280]"></span>
                                    Expired
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <a href="{{ route('order.show') }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>

                        <!-- Item 4 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">#MLX-8819</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                     <div class="w-[34px] h-[34px] rounded-full bg-[#eef2ff] text-[#4f46e5] text-[11px] font-bold flex items-center justify-center shrink-0 border border-[#e0e7ff]">AD</div>
                                     <div class="text-[14px] text-[#1A1C19] font-medium">Andi Dermawan</div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">Jan 22, 2026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp 2.450.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                    Paid
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <button class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <!-- Item 5 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">#MLX-8818</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="flex items-center gap-3">
                                     <div class="w-[34px] h-[34px] rounded-full overflow-hidden shrink-0 border border-[#E8EBED]">
                                         <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80" class="w-full h-full object-cover">
                                     </div>
                                     <div class="text-[14px] text-[#1A1C19] font-medium">Rina Wati</div>
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[13.5px] text-gray-500 font-medium">Jan 21, 2026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14px] text-[#1A1C19]">Rp 89.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#fffbeb] text-[#d97706] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#d97706]"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-[22px] text-right">
                                <button class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors flex items-center justify-end gap-1 ml-auto">
                                    Detail
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="px-6 py-[22px] flex flex-col md:flex-row items-center justify-between gap-4 mt-auto">
                <div class="text-[13.5px] text-gray-500 font-medium">
                    Showing 1 to 5 of 154 entries
                </div>
                
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-transparent text-gray-400 hover:text-[#1A1C19] hover:bg-gray-100 transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#2E5136] text-white text-[12.5px] font-bold shadow-sm">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-transparent text-gray-500 hover:bg-gray-100 text-[12.5px] font-bold transition-colors">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-transparent text-gray-500 hover:bg-gray-100 text-[12.5px] font-bold transition-colors">3</button>
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 text-[12.5px] font-bold">...</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border border-transparent text-gray-400 hover:text-[#1A1C19] hover:bg-gray-100 transition-colors">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            
        </div>
        
        <!-- Bottom Disclaimer -->
        <div class="mt-8 mb-4 lg:mb-2 text-center text-[11px] font-medium text-gray-400">
             © 2026 MyLinx. All rights reserved.
        </div>

    </div>
</x-app-layout>
