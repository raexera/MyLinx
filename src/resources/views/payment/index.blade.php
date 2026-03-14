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

        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            
            <!-- Card 1 -->
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Total Revenue</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">Rp 45.250.000</div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-[#1fad55]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    <span>+12% <span class="text-gray-400 font-medium">from last month</span></span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Pending Payments</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">Rp 3.100.000</div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-[#d97706]">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>4 Invoices unpaid</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-[2rem] p-7 sm:p-8 border border-[#E8EBED] shadow-[0_2px_10px_rgb(0,0,0,0.015)]">
                <h3 class="text-[13px] font-medium text-gray-400 mb-2">Refunded</h3>
                <div class="text-[2.2rem] font-medium text-[#1A1C19] tracking-tight leading-none mb-3">Rp 750.000</div>
                <div class="flex items-center gap-1.5 text-[11px] font-bold text-gray-400">
                    <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                    <span>-2% rate</span>
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
                        
                        <!-- Item 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-flex flex-col text-center shadow-sm">
                                    <span class="text-gray-400">#INV-</span>8821
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">#ORD-<br>1024</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19]">Rp 1.500.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                    Paid
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">24 Jan,<br>2026</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Item 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-flex flex-col text-center shadow-sm">
                                    <span class="text-gray-400">#INV-</span>8822
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">#ORD-<br>1025</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19]">Rp 750.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#fffbeb] text-[#d97706] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#d97706]"></span>
                                    Unpaid
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">25 Jan,<br>2026</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Item 3 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-flex flex-col text-center shadow-sm">
                                    <span class="text-gray-400">#INV-</span>8823
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">#ORD-<br>1026</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19]">Rp 2.100.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#fef2f2] text-[#ef4444] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#ef4444]"></span>
                                    Refunded
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">26 Jan,<br>2026</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Item 4 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-flex flex-col text-center shadow-sm">
                                    <span class="text-gray-400">#INV-</span>8820
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">#ORD-<br>1023</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19] flex flex-col justify-center">
                                     <span class="text-[11px] text-[#1A1C19] mb-[-4px]">Rp</span>
                                     5.450.000
                                </div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                    Paid
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">23 Jan,<br>2026</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Item 5 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-[22px]">
                                <span class="bg-[#F4F6F9] text-[#1A1C19] text-[11px] font-bold px-3 py-1.5 rounded-full inline-flex flex-col text-center shadow-sm">
                                    <span class="text-gray-400">#INV-</span>8819
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">#ORD-<br>1022</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="font-medium text-[14.5px] text-[#1A1C19]">Rp 900.000</div>
                            </td>
                            <td class="px-4 py-[22px]">
                                <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                    <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                    Paid
                                </span>
                            </td>
                            <td class="px-4 py-[22px]">
                                <div class="text-[12.5px] text-gray-500 font-medium">22 Jan,<br>2026</div>
                            </td>
                            <td class="px-8 py-[22px] text-right">
                                <div class="flex items-center justify-end gap-3 text-gray-400">
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </button>
                                    <button class="hover:text-[#1A1C19] transition-colors p-1">
                                         <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="px-6 sm:px-8 py-[22px] flex flex-col md:flex-row items-center justify-between gap-4 mt-auto border-t border-[#E8EBED]">
                <div class="text-[13px] text-gray-500 font-medium">
                    Showing 1-5 of 24 invoices
                </div>
                
                <div class="flex items-center gap-1.5">
                    <button class="w-[34px] h-[34px] flex items-center justify-center rounded-full border border border-[#E8EBED] text-gray-400 hover:text-[#1A1C19] hover:bg-gray-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="w-[34px] h-[34px] flex items-center justify-center rounded-full border border-[#E8EBED] text-gray-400 hover:text-[#1A1C19] hover:bg-gray-100 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            
        </div>
        
        <!-- Bottom Disclaimer -->
        <div class="mt-6 text-center text-[10.5px] font-medium text-gray-400">
             © 2026 MyLinx. All rights reserved. Privacy Policy
        </div>

    </div>
</x-app-layout>
