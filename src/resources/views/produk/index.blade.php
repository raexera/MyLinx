<x-app-layout>
    <x-slot name="whiteBg">true</x-slot>
    <x-slot name="hideProfile">true</x-slot>
    
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-2">
            
            <div class="flex flex-col">
                <h1 class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5">Daftar Produk</h1>
                <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C]">Kelola inventaris dan katalog produk Anda dengan gaya majalah yang elegan.</p>
            </div>
            
            <div>
                 <a href="{{ route('produk.create') }}" class="bg-[#2E5136] hover:bg-[#1f3824] text-white flex items-center justify-center gap-2 px-6 py-[12px] rounded-full text-[13.5px] font-bold transition-all shadow-[0_4px_12px_rgb(46,81,54,0.2)] w-full sm:w-auto">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                     Tambah Produk Baru
                 </a>
            </div>
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full lg:pr-4 xl:pr-8 pb-12 flex flex-col h-full mt-6">
        
        <!-- Toolbar (Search & Filters) -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-4">
            
            <!-- Search -->
            <div class="relative w-full lg:max-w-md">
                 <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                     <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                     </svg>
                 </div>
                 <input type="text" class="block w-full pl-11 pr-4 py-3 border border-[#E8EBED] rounded-full text-[13.5px] text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] transition-colors placeholder:text-gray-400 shadow-sm outline-none" placeholder="Cari nama produk, SKU, atau kategori..." />
            </div>

            <!-- Filters -->
            <div class="flex items-center gap-2 overflow-x-auto hide-scroll pb-2 lg:pb-0 shrink-0">
                <button class="bg-[#2E5136] text-white px-5 py-2.5 rounded-full text-[13px] font-bold shadow-sm shrink-0">Semua</button>
                <button class="bg-white border text-gray-500 border-[#E8EBED] hover:border-gray-300 hover:text-[#1A1C19] px-5 py-2.5 rounded-full text-[13px] font-bold transition-colors shrink-0 shadow-sm">Aktif</button>
                <button class="bg-white border text-gray-500 border-[#E8EBED] hover:border-gray-300 hover:text-[#1A1C19] px-5 py-2.5 rounded-full text-[13px] font-bold transition-colors shrink-0 shadow-sm">Habis</button>
                <button class="bg-white border text-gray-500 border-[#E8EBED] hover:border-gray-300 hover:text-[#1A1C19] px-5 py-2.5 rounded-full text-[13px] font-bold transition-colors shrink-0 shadow-sm">Arsip</button>
                
                <div class="w-px h-6 bg-[#E8EBED] mx-2 shrink-0"></div>
                
                <button class="bg-white border border-[#E8EBED] hover:bg-gray-50 text-gray-600 px-4 py-2.5 rounded-full text-[13px] font-bold transition-colors flex items-center gap-2 shrink-0 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter
                </button>
            </div>
            
        </div>

        <!-- Main Card Wrapper for Table -->
        <div class="bg-white border border-[#E8EBED] rounded-3xl shadow-[0_2px_12px_rgb(0,0,0,0.02)] flex flex-col flex-1 overflow-hidden">
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#E8EBED]">
                            <th class="py-5 px-6 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[90px]">Image</th>
                            <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap min-w-[200px]">Nama Produk</th>
                            <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap">Kategori</th>
                            <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[140px]">Harga</th>
                            <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[100px]">Stock</th>
                            <th class="py-5 px-6 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap text-right w-[80px]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8EBED]/60">
                        
                        <!-- Item 1 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-full bg-[#E5B887] relative flex items-center justify-center border border-[#d6a575]/30 overflow-hidden shadow-inner">
                                     <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                     <svg class="w-6 h-6 text-white absolute" fill="currentColor" viewBox="0 0 24 24"><path d="M21.4 13.9l-6.2-3.1c-1.1-.6-2.5-.2-3.1.9l-.6 1.1-1.3-.6.6-1.1c.6-1.1.2-2.5-.9-3.1L3.7 4.9C2.7 4.4 1.4 4.8.9 5.8s.4 2.3 1.4 2.8l6.2 3.1c1.1.6 2.5.2 3.1-.9l.6-1.1 1.3.6-.6 1.1c-.6 1.1-.2 2.5.9 3.1l6.2 3.1c1 .5 2.3.1 2.8-.9.5-1.1.1-2.4-.9-2.9z"/></svg>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">Urban Sneaker Basic</div>
                                <div class="text-[11px] font-bold text-gray-400">SKU: US-001-WHT</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#F4F6F9] text-gray-500 text-[10.5px] font-bold px-3 py-1 rounded-full whitespace-nowrap border border-gray-100">Footwear</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp 1.250.000</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#e4faeb] text-[#1fad55] text-[11px] font-bold px-2 py-0.5 rounded border border-[#bef0d1]">45</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-gray-300 hover:text-[#1A1C19] transition-colors rounded-full hover:bg-gray-100 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <!-- Item 2 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-full bg-[#B2BFC0] relative flex items-center justify-center border border-[#9caab1]/30 overflow-hidden shadow-inner">
                                     <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                     <svg class="w-6 h-6 text-white absolute" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-2c0-2.8-2.2-5-5-5S7 3.2 7 6H5c-1.1 0-2 .9-2 2v13c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.7 0 3 1.3 3 3H9c0-1.7 1.3-3 3-3z"/></svg>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">Classic Cotton Tee</div>
                                <div class="text-[11px] font-bold text-gray-400">SKU: CC-TEE-GRY</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#F4F6F9] text-gray-500 text-[10.5px] font-bold px-3 py-1 rounded-full whitespace-nowrap border border-gray-100">Apparel</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp 250.000</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#fefce8] text-[#eab308] text-[11px] font-bold px-2.5 py-0.5 rounded border border-[#fef08a]">8</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-gray-300 hover:text-[#1A1C19] transition-colors rounded-full hover:bg-gray-100 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <!-- Item 3 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-full bg-[#DCD5C6] relative flex items-center justify-center border border-[#d1c9b8]/30 overflow-hidden shadow-inner">
                                     <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                     <svg class="w-6 h-6 text-white absolute" fill="currentColor" viewBox="0 0 24 24"><path d="M21.4 13.9l-6.2-3.1c-1.1-.6-2.5-.2-3.1.9l-.6 1.1-1.3-.6.6-1.1c.6-1.1.2-2.5-.9-3.1L3.7 4.9C2.7 4.4 1.4 4.8.9 5.8s.4 2.3 1.4 2.8l6.2 3.1c1.1.6 2.5.2 3.1-.9l.6-1.1 1.3.6-.6 1.1c-.6 1.1-.2 2.5.9 3.1l6.2 3.1c1 .5 2.3.1 2.8-.9.5-1.1.1-2.4-.9-2.9z"/></svg>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">Linen Summer Dress</div>
                                <div class="text-[11px] font-bold text-gray-400">SKU: LS-DRS-BGE</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#F4F6F9] text-gray-500 text-[10.5px] font-bold px-3 py-1 rounded-full whitespace-nowrap border border-gray-100">Women</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp 890.000</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#e4faeb] text-[#1fad55] text-[11px] font-bold px-1.5 py-0.5 rounded border border-[#bef0d1]">120</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-gray-300 hover:text-[#1A1C19] transition-colors rounded-full hover:bg-gray-100 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                            </td>
                        </tr>

                         <!-- Item 4 -->
                         <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-full bg-[#9E8B7A] relative flex items-center justify-center border border-[#8f7e6f]/30 overflow-hidden shadow-inner">
                                     <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                     <svg class="w-6 h-6 text-white absolute" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM11 19.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">Artisan Ceramic Vase</div>
                                <div class="text-[11px] font-bold text-gray-400">SKU: AC-VASE-002</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#F4F6F9] text-gray-500 text-[10.5px] font-bold px-3 py-1 rounded-full whitespace-nowrap border border-gray-100">Home Decor</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp 450.000</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#fef2f2] text-[#ef4444] text-[11px] font-bold px-2.5 py-0.5 rounded border border-[#fecaca]">0</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-gray-300 hover:text-[#1A1C19] transition-colors rounded-full hover:bg-gray-100 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                            </td>
                        </tr>

                        <!-- Item 5 -->
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="w-12 h-12 rounded-full bg-[#CD955F] relative flex items-center justify-center border border-[#be8854]/30 overflow-hidden shadow-inner">
                                     <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                     <svg class="w-6 h-6 text-white absolute" fill="currentColor" viewBox="0 0 24 24"><path d="M19 6h-2c0-2.8-2.2-5-5-5S7 3.2 7 6H5c-1.1 0-2 .9-2 2v13c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-7-3c1.7 0 3 1.3 3 3H9c0-1.7 1.3-3 3-3z"/></svg>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">Handwoven Rattan Bag</div>
                                <div class="text-[11px] font-bold text-gray-400">SKU: HW-BAG-BRN</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#F4F6F9] text-gray-500 text-[10.5px] font-bold px-3 py-1 rounded-full whitespace-nowrap border border-gray-100">Accessories</span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp 675.000</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="bg-[#e4faeb] text-[#1fad55] text-[11px] font-bold px-2 py-0.5 rounded border border-[#bef0d1]">15</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-gray-300 hover:text-[#1A1C19] transition-colors rounded-full hover:bg-gray-100 opacity-0 group-hover:opacity-100">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path></svg>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <!-- Footer Pagination -->
            <div class="px-6 py-5 border-t border-[#E8EBED] flex flex-col md:flex-row items-center justify-between gap-4 mt-auto">
                <div class="text-[13px] text-gray-500 font-medium">
                    Showing <span class="font-bold text-[#1A1C19]">1-5</span> of <span class="font-bold text-[#1A1C19]">48</span> products
                </div>
                
                <div class="flex items-center gap-1.5">
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] text-gray-400 hover:text-[#1A1C19] hover:bg-gray-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#2E5136] text-white text-[12.5px] font-bold">1</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] text-gray-500 hover:bg-gray-50 text-[12.5px] font-bold transition-colors">2</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] text-gray-500 hover:bg-gray-50 text-[12.5px] font-bold transition-colors">3</button>
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 text-[12.5px] font-bold">...</button>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] text-gray-400 hover:text-[#1A1C19] hover:bg-gray-50 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>
            </div>
            
        </div>

    </div>
</x-app-layout>
