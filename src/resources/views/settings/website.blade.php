<x-app-layout>
    <x-slot name="whiteBg">true</x-slot>
    <x-slot name="hideProfile">true</x-slot>
    <x-slot name="header">
        <div class="flex flex-col pt-4 sm:pt-6 w-full lg:pr-4 xl:pr-8">
            <h1 class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5">Website Settings</h1>
            <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C]">Manage your store's identity and appearance</p>
            <div class="w-full h-px bg-[#E8EBED] mt-8"></div>
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full pt-5 sm:pt-6 lg:pr-4 xl:pr-8">
        
        <!-- Section 1: Shop Subdomain -->
        <div class="mb-14">
            <h2 class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight">Shop Subdomain</h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">Choose a unique address for your online store.</p>
            
            <!-- Shop Subdomain Input row -->
            <div class="flex flex-col sm:flex-row gap-4 sm:gap-3">
                <div class="flex items-center flex-1 border border-[#E8EBED] rounded-[1rem] bg-white h-[54px] px-5 shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                    <svg class="w-[18px] h-[18px] text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    <input type="text" class="flex-1 bg-transparent border-none outline-none text-[14.5px] font-medium text-[#1A1C19] p-0 focus:ring-0 placeholder:text-gray-300 w-full" value="artisan-santana-store" placeholder="your-store-name">
                    <span class="text-[14.5px] font-medium text-gray-400 pl-2 opacity-80">.mylinx.id</span>
                </div>
                <!-- Light grayish-blue pill button -->
                <button class="bg-[#F4F6F9] hover:bg-[#e6eaf0] text-[#1A1C19] text-[13.5px] font-bold px-7 h-[54px] rounded-full transition-colors whitespace-nowrap shadow-sm">Check Availability</button>
            </div>
        </div>

        <!-- Section 2: Store Mode -->
        <div class="mb-14">
            <h2 class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight">Store Mode</h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">How do you want to present your work?</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                
                <!-- Portfolio Mode -->
                <div class="border border-[#E8EBED] rounded-[1.2rem] bg-white p-6 cursor-pointer hover:border-gray-300 transition-colors group shadow-sm">
                    <div class="w-[38px] h-[38px] bg-[#F4F6F9] group-hover:bg-[#E8EBED] text-[#6A7B8C] rounded-full flex items-center justify-center mb-5 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-[14px] font-bold text-[#1A1C19] mb-1.5">Portfolio Mode</h3>
                    <p class="text-[12px] text-[#6A7B8C] font-medium leading-relaxed pr-2">Showcase your work without direct purchasing options.</p>
                </div>
                
                <!-- Marketplace Mode -->
                <div class="border border-[#E8EBED] rounded-[1.2rem] bg-white p-6 cursor-pointer hover:border-gray-300 transition-colors group shadow-sm">
                    <div class="w-[38px] h-[38px] bg-[#F4F6F9] group-hover:bg-[#E8EBED] text-[#6A7B8C] rounded-full flex items-center justify-center mb-5 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-[14px] font-bold text-[#1A1C19] mb-1.5">Marketplace Mode</h3>
                    <p class="text-[12px] text-[#6A7B8C] font-medium leading-relaxed pr-2">Focus purely on product listings and sales.</p>
                </div>

                <!-- Hybrid Mode (Active) -->
                <div class="border-2 border-[#2E5136] rounded-[1.2rem] bg-[#fdfdfd] p-6 cursor-pointer relative shadow-sm">
                    <!-- Checkmark bubble top right -->
                    <div class="absolute top-4 right-4 w-[20px] h-[20px] bg-[#2E5136] rounded-full flex items-center justify-center text-white shadow-sm">
                        <svg class="w-[12px] h-[12px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    
                    <div class="w-[38px] h-[38px] bg-white text-[#1A1C19] rounded-full flex items-center justify-center mb-5 border border-[#E8EBED]">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l8 4-8 4-8-4 8-4zM20 11l-8 4-8-4m16 4l-8 4-8-4"></path></svg>
                    </div>
                    <h3 class="text-[14px] font-bold text-[#1A1C19] mb-1.5">Hybrid Mode</h3>
                    <p class="text-[12px] text-[#6A7B8C] font-medium leading-relaxed pr-2">Combine portfolio showcase with product sales.</p>
                </div>

            </div>
        </div>

        <!-- Section 3: Active Template -->
        <div class="mb-6">
            <h2 class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight">Active Template</h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">The current look and feel of your website.</p>
            
            <div class="border border-[#E8EBED] rounded-3xl bg-white p-6 sm:p-7 flex flex-col md:flex-row gap-8 items-start md:items-center shadow-sm">
                
                <!-- Mockup side -->
                <div class="w-full md:w-[260px] aspect-[4/3] bg-[#fcf2ed] rounded-[1rem] flex-shrink-0 flex justify-center items-center overflow-hidden border border-[#faeadd]">
                    <!-- Basic laptop mockup shape -->
                    <div class="w-[78%] h-[60%] flex flex-col items-center">
                         <div class="w-full h-full bg-white rounded-t-lg shadow-sm border border-b-0 border-[#E8EBED] overflow-hidden flex flex-col items-center px-4 py-3">
                             <div class="w-10 h-1 bg-gray-200 rounded-full mb-3"></div>
                             <div class="text-[4px] font-serif font-bold text-gray-800 tracking-wide mb-1">MODERN MINIMALIST</div>
                             <div class="w-12 h-[1px] bg-gray-200 mb-1"></div>
                             <div class="flex flex-col gap-[1.5px] mt-1 items-center w-full">
                                  <div class="w-16 h-[2px] bg-gray-100 rounded-full"></div>
                                  <div class="w-12 h-[2px] bg-gray-100 rounded-full"></div>
                             </div>
                         </div>
                         <div class="w-[110%] h-[4px] bg-[#222] rounded-b-sm shadow-xl flex justify-center">
                             <div class="w-6 h-[2px] bg-[#444] rounded-b-[1px]"></div>
                         </div>
                    </div>
                </div>

                <!-- Info side -->
                <div class="flex-1 flex flex-col items-start xl:pr-6">
                    <div class="flex items-center gap-3 mb-2.5">
                         <h3 class="text-2xl font-serif text-[#1A1C19]">Modern Minimalist</h3>
                         <span class="bg-[#e9f2ee] text-[#2E5136] text-[9.5px] font-bold px-2.5 py-[3px] uppercase tracking-widest rounded-md mt-1">ACTIVE</span>
                    </div>
                    <p class="text-[13.5px] text-[#6A7B8C] font-medium leading-relaxed mb-7 max-w-sm">A clean, whitespace-heavy design perfect for creative professionals. Focuses on imagery and typography to let your work stand out.</p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-5 w-full sm:w-auto">
                         <button class="w-full sm:w-auto flex items-center justify-center gap-2 border border-[#E8EBED] rounded-full px-6 py-[10px] text-[13px] font-bold text-[#1A1C19] hover:bg-gray-50 transition-colors shadow-sm whitespace-nowrap">
                              <svg class="w-[18px] h-[18px] text-gray-500 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                              Preview Template
                         </button>
                         <a href="{{ route('settings.template') }}" class="text-[13px] font-bold text-[#6A7B8C] hover:text-[#1A1C19] transition-colors whitespace-nowrap">Ganti Template (Change)</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Float Save Button -->
        <div class="flex justify-end pt-8 pb-14 mt-4 relative">
             <button class="bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-7 py-[12px] font-bold text-[14px] shadow-[0_8px_16px_rgb(46,81,54,0.3)] flex items-center gap-2.5 transition-all transform hover:-translate-y-0.5 z-10">
                 Save Changes
                 <svg class="w-[14px] h-[14px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg>
             </button>
        </div>

    </div>
</x-app-layout>
