<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-5 lg:gap-8 mt-2 lg:mt-0 xl:pr-10 w-full mb-4">
            
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1.5 pl-1">
                    <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">MYLINX WEBSITE SETTINGS</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Pilih Template</h1>
                <p class="text-[13px] sm:text-[14.5px] font-medium text-[#6A7B8C] leading-relaxed max-w-lg mt-3">Curated designs for your unique business identity. Choose a starting point.</p>
            </div>
            
            <!-- Search bar -->
            <div class="relative w-full sm:max-w-md xl:w-[280px]">
                 <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                     <svg class="h-[18px] w-[18px] text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                     </svg>
                 </div>
                 <input type="text" class="block w-full pl-11 pr-4 py-3 border border-[#E8EBED] rounded-full text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-gray-400 shadow-[0_2px_10px_rgb(0,0,0,0.02)]" placeholder="Search templates..." />
            </div>
        </div>
    </x-slot>

    <!-- Category Filters -->
    <div class="flex items-center gap-2.5 sm:gap-[14px] mb-[28px] sm:mb-[34px] overflow-x-auto pb-4 snap-x hide-scroll">
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-[#2E5136] text-white rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap shadow-sm snap-start">All Templates</button>
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:bg-gray-50 rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap transition-colors snap-start">Retail</button>
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:bg-gray-50 rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap transition-colors snap-start">F&B</button>
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:bg-gray-50 rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap transition-colors snap-start">Portfolio</button>
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:bg-gray-50 rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap transition-colors snap-start">Service</button>
        <button class="px-5 sm:px-[26px] py-2.5 sm:py-[11px] bg-white border border-[#E8EBED] text-gray-500 hover:text-[#1A1C19] hover:bg-gray-50 rounded-full text-xs sm:text-[13px] font-semibold whitespace-nowrap transition-colors snap-start">Tech</button>
        <div class="min-w-1 md:hidden"></div>
    </div>

    <!-- Templates Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7 mb-10 pb-6">
        
        <!-- Template 1: Retail -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#f8f6f4] overflow-hidden relative mb-5">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-10 w-fit">RETAIL</div>
                <img src="https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Modern Minimalist">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Modern Minimalist</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Clean lines for high-end retail brands.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>

        <!-- Template 2: F&B -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#fdfaf5] overflow-hidden relative mb-5">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-10 w-fit">F&B</div>
                <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Artisan Bakery">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Artisan Bakery</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Warm aesthetics for food businesses.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>

        <!-- Template 3: Portfolio -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#eeeae6] overflow-hidden relative mb-5 flex items-center justify-center">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-20 w-fit">PORTFOLIO</div>
                <img src="https://images.unsplash.com/photo-1620062776856-42fc6cb6feee?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 z-10" alt="Nusantara Crafts">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Nusantara Crafts</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Showcase local heritage with style.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>

        <!-- Template 4: F&B 2 -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#f8f6f4] overflow-hidden relative mb-5 flex items-center justify-center">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-20 w-fit">F&B</div>
                <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 z-10" alt="Kopi Senja">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Kopi Senja</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Perfect for cafes and bistros.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>

        <!-- Template 5: Tech -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#eaeced] overflow-hidden relative mb-5 flex items-center justify-center">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-20 w-fit">TECH</div>
                 <img src="https://images.unsplash.com/photo-1510146758428-e5e4b17b8b6a?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 z-10" alt="Tech Startup">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Tech Startup</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Bold and modern for digital products.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>

        <!-- Template 6: Portfolio 2 -->
        <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border border-[#E8EBED] flex flex-col group hover:shadow-lg transition-shadow">
            <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#f8f5ea] overflow-hidden relative mb-5 flex items-center justify-center">
                <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-20 w-fit">PORTFOLIO</div>
                 <img src="https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 z-10" alt="Creative Studio">
            </div>
            <div class="px-2 flex-grow mb-6">
                <h3 class="text-[1.35rem] font-serif font-bold text-[#1A1C19] mb-1.5">Creative Studio</h3>
                <p class="text-[13px] font-medium text-gray-500 leading-relaxed max-w-[95%]">Dynamic layout for visual artists.</p>
            </div>
            <div class="flex gap-3 px-2">
                <button class="flex-1 py-3 border border-[#E8EBED] rounded-full text-[13.5px] font-bold text-[#1A1C19] bg-white hover:bg-gray-50 transition-colors">Preview</button>
                <button class="flex-[1.2] py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors">Gunakan</button>
            </div>
        </div>
        
    </div>
</x-app-layout>
