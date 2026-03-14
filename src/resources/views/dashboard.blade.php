<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-1.5 pl-1">
                <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">SELLER DASHBOARD</span>
            </div>
            <h1 class="text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Dashboard</h1>
        </div>
    </x-slot>

    <!-- 1. Stats Row -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <!-- Total Sales -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <!-- Icon container -->
                <div class="w-[42px] h-[42px] rounded-full bg-green-50 text-[#2E5136] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <!-- Badge -->
                <div class="bg-green-50 text-[#2E5136] text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5">
                    <svg class="w-3 h-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +12%
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Total Sales</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">IDR 45.0M</div>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <div class="bg-green-50 text-[#2E5136] text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5">
                    <svg class="w-3 h-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +5%
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Orders</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">124</div>
            </div>
        </div>

        <!-- Produk Aktif -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2.5 py-0.5 rounded-full">
                    0%
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Produk Aktif</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">32</div>
            </div>
        </div>

        <!-- Visitor -->
        <div class="bg-white rounded-[1.5rem] p-6 shadow-sm border border-[#E8EBED] flex flex-col justify-between">
            <div class="flex justify-between items-start mb-6">
                <div class="w-[42px] h-[42px] rounded-full bg-gray-50 text-gray-500 flex items-center justify-center border border-gray-100">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="bg-green-50 text-[#2E5136] text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5">
                    <svg class="w-3 h-3 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    +8%
                </div>
            </div>
            <div>
                <div class="text-[12px] font-semibold text-gray-400 mb-1">Visitor</div>
                <div class="text-[1.8rem] font-serif text-[#1A1C19] tracking-wide">1,205</div>
            </div>
        </div>

    </div>

    <!-- 2. Chart Section Mockup -->
    <div class="bg-white rounded-[2rem] p-8 pb-4 shadow-sm border border-[#E8EBED] mb-8 relative">
        <div class="flex justify-between items-start mb-2 px-2">
            <div>
                <h2 class="text-[1.75rem] font-serif text-[#1A1C19] mb-1">Penjualan Overview</h2>
                <p class="text-xs text-gray-400 font-semibold tracking-wide">Monthly sales performance statistics</p>
            </div>
            <div class="flex gap-3">
                 <button class="flex items-center gap-2 px-4 py-2 border border-[#E8EBED] rounded-full text-xs font-semibold text-gray-500 hover:bg-gray-50 transition-colors">
                     This Month
                     <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                 </button>
                 <button class="w-[34px] h-[34px] border border-[#E8EBED] rounded-full flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
                     <svg class="w-[15px] h-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                 </button>
            </div>
        </div>

        <!-- SVG Chart visually resembling Figma -->
        <div class="relative w-full h-[260px] mt-6">
            <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 1000 250">
                <!-- Grid vertical lines simulated -->
                <line x1="200" y1="20" x2="200" y2="230" stroke="#f1f3f5" stroke-width="1" />
                <line x1="400" y1="20" x2="400" y2="230" stroke="#f1f3f5" stroke-width="1" />
                <line x1="600" y1="20" x2="600" y2="230" stroke="#f1f3f5" stroke-width="1" />
                <line x1="800" y1="20" x2="800" y2="230" stroke="#f1f3f5" stroke-width="1" />
                
                <!-- Chart gradient fill -->
                <path d="M0,180 C150,150 250,90 400,110 C500,120 550,50 620,60 C700,70 800,105 850,90 C900,75 950,55 1000,60 L1000,250 L0,250 Z" fill="#2E5136" fill-opacity="0.06" />
                
                <!-- Chart stroke -->
                <path d="M0,180 C150,150 250,90 400,110 C500,120 550,50 620,60 C700,70 800,105 850,90 C900,75 950,55 1000,60" fill="none" stroke="#2E5136" stroke-width="3.5" />
            </svg>
             
            <!-- Tooltip Point -->
            <div class="absolute left-[54.5%] top-[14%] flex flex-col items-center">
                 <!-- Tooltip bubble -->
                 <div class="bg-[#1D1F23] text-white text-[10px] font-bold py-[6px] px-3.5 rounded-md mb-2 shadow-lg z-10 whitespace-nowrap transform -translate-x-1/2 ml-1 relative">
                      IDR 4.2M
                      <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-[#1D1F23] rotate-45"></div>
                 </div>
                 <!-- Ring point -->
                 <div class="w-3.5 h-3.5 bg-white border-[3.5px] border-[#2E5136] rounded-full z-10 shadow-sm relative -top-0.5"></div>
            </div>
             
            <!-- Bottom axis labels -->
            <div class="absolute -bottom-2 inset-x-0 flex justify-between px-6 text-[9px] font-bold text-gray-300 uppercase tracking-widest text-center">
                 <span class="w-10">Mon</span>
                 <span class="w-10">Tue</span>
                 <span class="w-10">Wed</span>
                 <span class="w-10">Thu</span>
                 <span class="w-10">Fri</span>
                 <span class="w-10">Sat</span>
                 <span class="w-10">Sun</span>
            </div>
        </div>
    </div> <!-- /Chart -->

    <!-- 3. Recent Orders Table -->
    <div class="bg-white rounded-[2rem] px-8 py-8 shadow-sm border border-[#E8EBED] flex flex-col mb-8">
        
        <div class="flex justify-between items-center mb-8 px-2">
             <h2 class="text-2xl font-serif text-[#1A1C19]">Recent Orders</h2>
             <a href="#" class="text-[10px] font-bold text-[#2E5136] uppercase tracking-[0.15em] flex items-center gap-1.5 hover:text-[#1f3824] transition-colors">
                  VIEW ALL
                  <svg class="w-[14px] h-[14px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
             </a>
        </div>

        <div class="w-full overflow-x-auto">
             <table class="w-full text-left border-collapse">
                  <thead>
                       <tr class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">
                            <th class="py-5 px-4 whitespace-nowrap w-[20%] font-bold border-b border-[#F0F2F3] pl-2">ORDER ID</th>
                            <th class="py-5 px-4 whitespace-nowrap w-[30%] font-bold border-b border-[#F0F2F3]">CUSTOMER</th>
                            <th class="py-5 px-4 whitespace-nowrap w-[20%] font-bold border-b border-[#F0F2F3]">AMOUNT</th>
                            <th class="py-5 px-4 whitespace-nowrap w-[20%] font-bold border-b border-[#F0F2F3]">STATUS</th>
                            <th class="py-5 px-4 whitespace-nowrap w-[10%] font-bold border-b border-[#F0F2F3] text-right pr-2">ACTION</th>
                       </tr>
                  </thead>
                  <tbody class="text-sm border-b border-[#F0F2F3]">
                       
                       <!-- row 1 -->
                       <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#F0F2F3]">
                            <td class="py-5 px-4 pl-2 font-medium text-gray-600 text-[13px]">#ORD-001</td>
                            <td class="py-5 px-4">
                                 <div class="flex items-center gap-3">
                                      <div class="w-[34px] h-[34px] rounded-full bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center text-[10px] tracking-wider font-bold">AS</div>
                                      <div>
                                           <div class="font-bold text-[#1A1C19] text-[13px] leading-tight">Alice Smith</div>
                                           <div class="text-[11.5px] text-gray-400 font-medium">alice@example.com</div>
                                      </div>
                                 </div>
                            </td>
                            <td class="py-4 px-4 font-serif text-[17px] tracking-wide text-gray-500">IDR <span class="font-bold font-sans text-xs text-[#1A1C19]">1.500.000</span></td>
                            <td class="py-4 px-4">
                                 <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-green-100/50">
                                      <span class="w-[5px] h-[5px] rounded-full bg-[#34C759]"></span> COMPLETED
                                 </span>
                            </td>
                            <td class="py-4 px-4 text-right pr-2">
                                 <button class="text-gray-300 hover:text-gray-500 py-1 font-sans font-bold tracking-widest leading-none">•••</button>
                            </td>
                       </tr>

                       <!-- row 2 -->
                       <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#F0F2F3]">
                            <td class="py-5 px-4 pl-2 font-medium text-gray-600 text-[13px]">#ORD-002</td>
                            <td class="py-5 px-4">
                                 <div class="flex items-center gap-3">
                                      <div class="w-[34px] h-[34px] rounded-full bg-orange-100 flex items-center justify-center overflow-hidden">
                                           <img src="https://ui-avatars.com/api/?name=Bob+Jones&background=F3E5D8&color=B07A57" class="w-full h-full object-cover">
                                      </div>
                                      <div>
                                           <div class="font-bold text-[#1A1C19] text-[13px] leading-tight">Bob Jones</div>
                                           <div class="text-[11.5px] text-gray-400 font-medium">bob.jones@mail.com</div>
                                      </div>
                                 </div>
                            </td>
                            <td class="py-4 px-4 font-serif text-[17px] tracking-wide text-gray-500">IDR <span class="font-bold font-sans text-xs text-[#1A1C19]">750.000</span></td>
                            <td class="py-4 px-4">
                                 <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-orange-50 text-orange-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-orange-100/50">
                                      <span class="w-[5px] h-[5px] rounded-full bg-[#FFB800]"></span> PENDING
                                 </span>
                            </td>
                            <td class="py-4 px-4 text-right pr-2">
                                 <button class="text-gray-300 hover:text-gray-500 py-1 font-sans font-bold tracking-widest leading-none">•••</button>
                            </td>
                       </tr>

                       <!-- row 3 -->
                       <tr class="hover:bg-gray-50/50 transition-colors border-b border-[#F0F2F3]">
                            <td class="py-5 px-4 pl-2 font-medium text-gray-600 text-[13px]">#ORD-003</td>
                            <td class="py-5 px-4">
                                 <div class="flex items-center gap-3">
                                      <div class="w-[34px] h-[34px] rounded-full bg-[#1A1C19] text-white flex items-center justify-center text-[10px] tracking-wider font-bold">CD</div>
                                      <div>
                                           <div class="font-bold text-[#1A1C19] text-[13px] leading-tight">Charlie Day</div>
                                           <div class="text-[11.5px] text-gray-400 font-medium">charlie@day.inc</div>
                                      </div>
                                 </div>
                            </td>
                            <td class="py-4 px-4 font-serif text-[17px] tracking-wide text-gray-500">IDR <span class="font-bold font-sans text-xs text-[#1A1C19]">2.000.000</span></td>
                            <td class="py-4 px-4">
                                 <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-50 text-blue-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-blue-100/50">
                                      <span class="w-[5px] h-[5px] rounded-full bg-[#007AFF]"></span> PROCESSING
                                 </span>
                            </td>
                            <td class="py-4 px-4 text-right pr-2">
                                 <button class="text-gray-300 hover:text-gray-500 py-1 font-sans font-bold tracking-widest leading-none">•••</button>
                            </td>
                       </tr>

                       <!-- row 4 -->
                       <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="py-5 px-4 pl-2 font-medium text-gray-600 text-[13px]">#ORD-004</td>
                            <td class="py-5 px-4">
                                 <div class="flex items-center gap-3">
                                      <div class="w-[34px] h-[34px] rounded-full overflow-hidden bg-gray-200">
                                          <img src="https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&q=80&w=64" alt="user" class="w-full h-full object-cover">
                                      </div>
                                      <div>
                                           <div class="font-bold text-[#1A1C19] text-[13px] leading-tight">Diana Prince</div>
                                           <div class="text-[11.5px] text-gray-400 font-medium">diana@themyscira.gov</div>
                                      </div>
                                 </div>
                            </td>
                            <td class="py-4 px-4 font-serif text-[17px] tracking-wide text-gray-500">IDR <span class="font-bold font-sans text-xs text-[#1A1C19]">500.000</span></td>
                            <td class="py-4 px-4">
                                 <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-50 text-green-600 text-[9px] font-bold uppercase tracking-widest rounded-full border border-green-100/50">
                                      <span class="w-[5px] h-[5px] rounded-full bg-[#34C759]"></span> COMPLETED
                                 </span>
                            </td>
                            <td class="py-4 px-4 text-right pr-2">
                                 <button class="text-gray-300 hover:text-gray-500 py-1 font-sans font-bold tracking-widest leading-none">•••</button>
                            </td>
                       </tr>

                  </tbody>
             </table>
        </div>
        
        <!-- Pagination footer -->
        <div class="flex justify-between items-center mt-7 px-2 border-t border-transparent">
             <span class="text-[11px] text-gray-400 font-semibold tracking-wide">Showing 1 to 4 of 50 entries</span>
             
             <div class="flex items-center gap-1.5">
                  <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] hover:bg-gray-50 text-gray-400 transition-colors bg-white shadow-sm">
                       <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                  </button>
                  <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#2E5136] text-white font-bold text-xs shadow-sm shadow-[#2E5136]/30">1</button>
                  <button class="w-8 h-8 flex items-center justify-center rounded-full border border-transparent hover:border-[#E8EBED] text-gray-500 hover:bg-white font-bold text-xs transition-colors">2</button>
                  <button class="w-8 h-8 flex items-center justify-center rounded-full border border-transparent hover:border-[#E8EBED] text-gray-500 hover:bg-white font-bold text-xs transition-colors">3</button>
                  <span class="px-0.5 text-gray-400 font-bold mb-1">..</span>
                  <button class="w-8 h-8 flex items-center justify-center rounded-full border border-[#E8EBED] hover:bg-gray-50 text-gray-500 transition-colors bg-white shadow-sm">
                       <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                  </button>
             </div>
        </div>

    </div>

</x-app-layout>
