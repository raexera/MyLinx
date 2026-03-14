<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-2 relative z-10">
            <div class="flex flex-col max-w-xl">
                <h1 class="text-[2.75rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5">Profil Usaha</h1>
                <p class="text-[14.5px] font-medium text-[#2E5136] opacity-80 leading-relaxed">
                    Manage your business identity, brand story, and how<br>customers see you.
                </p>
            </div>
            
            <div class="flex items-center gap-3 shrink-0 mb-2 sm:mb-4">
                 <button class="bg-transparent border border-[#E8EBED] hover:bg-white text-[#1A1C19] flex items-center justify-center px-8 py-[10px] rounded-full text-[13.5px] font-bold transition-all shadow-sm">
                     Preview Store
                 </button>
            </div>
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full lg:pr-4 xl:pr-8 pb-16 flex flex-col mt-8 relative z-10">

        <!-- Top Right Background Decoration (Optional, simulating the subtle curve in Figma) -->
        <div class="absolute -top-40 right-0 w-[500px] h-[500px] bg-white rounded-full opacity-40 blur-[80px] pointer-events-none -z-10"></div>

        <form action="#" method="POST" class="w-full">
            
            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Visual Identity -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-12">
                <!-- Left Title -->
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2 text-shadow-sm">Visual Identity</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Your logo is the face of your brand. Upload a high-quality image to build trust.
                    </p>
                </div>
                <!-- Right Content -->
                <div class="flex-1">
                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6 border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.015)] group cursor-pointer hover:border-[#2E5136]/30 transition-colors">
                        <!-- Upload Circle target -->
                        <div class="w-[120px] h-[120px] rounded-full border-2 border-dashed border-[#d1d5db] group-hover:border-[#2E5136]/50 flex items-center justify-center shrink-0 bg-[#f9fafb] group-hover:bg-[#f2f4f3] transition-colors relative overflow-hidden">
                             <svg class="w-7 h-7 text-[#2E5136]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        </div>
                        
                        <!-- Text Info -->
                        <div class="text-center sm:text-left">
                            <h3 class="text-[15px] font-bold text-[#1A1C19] mb-1">Upload Business Logo</h3>
                            <p class="text-[12.5px] font-medium text-gray-400 mb-3 leading-relaxed">
                                Drag and drop your logo here, or click to browse.<br>
                                Recommended size: 500x500px (JPG, PNG)
                            </p>
                            <span class="inline-block bg-[#f9fafb] border border-[#E8EBED] text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Max 2MB
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Core Info -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-12">
                <!-- Left Title -->
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2">Core Info</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Tell your story. A compelling description helps customers connect with your brand.
                    </p>
                </div>
                <!-- Right Content -->
                <div class="flex-1 space-y-8">
                    
                    <!-- Nama Usaha -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">NAMA USAHA</label>
                        <input type="text" placeholder="e.g. Kopi Senja Nusantara" class="w-full h-14 bg-white border border-[#E8EBED] rounded-[1rem] px-5 text-[14.5px] text-[#1A1C19] font-medium shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-300">
                    </div>

                    <!-- Deskripsi Brand -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">DESKRIPSI BRAND</label>
                        <div class="border border-[#E8EBED] rounded-[1.5rem] bg-white overflow-hidden focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors shadow-[0_2px_10px_rgb(0,0,0,0.01)]">
                            <!-- Toolbar -->
                            <div class="flex items-center gap-4 px-6 py-3.5 border-b border-[#E8EBED]">
                                <button type="button" class="text-[#2E5136] font-serif font-bold text-[15px]">B</button>
                                <button type="button" class="text-[#2E5136] font-serif italic text-[15px]">I</button>
                                <button type="button" class="text-[#2E5136] hover:text-black">
                                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 6h.01M8 12h.01M8 18h.01"></path></svg>
                                </button>
                                
                                <div class="w-px h-4 bg-[#E8EBED] mx-2"></div>
                                
                                <button type="button" class="text-gray-400 hover:text-black">
                                    <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </button>
                            </div>
                            <!-- Textarea -->
                            <textarea class="w-full min-h-[160px] bg-transparent border-none px-6 py-5 text-[14.5px] text-gray-500 font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-300" placeholder="Write about your journey, your values, and what makes your products special..."></textarea>
                        </div>
                    </div>
                    
                </div>
            </div>

            <!-- Submit action absolute or separate section -->
            <div class="flex items-center justify-end gap-6 border-t border-[#E8EBED] pt-8 mb-4 flex-col sm:flex-row">
                 <button type="button" class="text-[13.5px] font-medium text-[#8b9196] hover:text-[#1A1C19] transition-colors order-2 sm:order-1">
                     Batal
                 </button>
                 <button type="submit" class="w-full sm:w-auto bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-8 py-3.5 text-[14px] font-bold shadow-[0_4px_16px_rgb(46,81,54,0.25)] flex items-center justify-center gap-2.5 transition-all transform hover:-translate-y-0.5 order-1 sm:order-2">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                     Simpan Profil
                 </button>
            </div>

            <!-- Spacer -->
            <div class="h-4"></div>

            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Contact & Social -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-8">
                <!-- Left Title -->
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2">Contact &amp; Social</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Make it easy for customers to reach you and follow your latest updates.
                    </p>
                </div>
                <!-- Right Content -->
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">
                    
                    <!-- WhatsApp Kontak -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">WHATSAPP KONTAK</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <svg class="w-5 h-5 text-gray-400 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <input type="text" placeholder="+62 812 3456 7890" class="flex-1 bg-transparent border-none outline-none text-[14px] text-[#1A1C19] font-medium p-0 focus:ring-0 placeholder:text-gray-300 w-full placeholder:font-normal">
                        </div>
                    </div>

                    <!-- Email Bisnis -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">EMAIL BISNIS</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <svg class="w-5 h-5 text-gray-400 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <input type="text" placeholder="hello@brand.com" class="flex-1 bg-transparent border-none outline-none text-[14px] text-[#1A1C19] font-medium p-0 focus:ring-0 placeholder:text-gray-300 w-full placeholder:font-normal">
                        </div>
                    </div>

                    <!-- Instagram Handle -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">INSTAGRAM HANDLE</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <!-- IG Gradient icon -->
                            <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-[#fbc2eb] to-[#a18cd1] text-white flex items-center justify-center mr-3 shrink-0">
                                <span class="text-[9px] font-bold">IG</span>
                            </div>
                            <input type="text" placeholder="@username" class="flex-1 bg-transparent border-none outline-none text-[14px] text-[#1A1C19] font-medium p-0 focus:ring-0 placeholder:text-gray-300 w-full placeholder:font-normal">
                        </div>
                    </div>

                    <!-- TikTok Handle -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">TIKTOK HANDLE</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <!-- TikTok Dark icon -->
                            <div class="w-5 h-5 rounded-full bg-black text-white flex items-center justify-center mr-3 shrink-0">
                                <span class="text-[9px] font-bold">TT</span>
                            </div>
                            <input type="text" placeholder="@username" class="flex-1 bg-transparent border-none outline-none text-[14px] text-[#1A1C19] font-medium p-0 focus:ring-0 placeholder:text-gray-300 w-full placeholder:font-normal">
                        </div>
                    </div>

                </div>
            </div>

        </form>

    </div>
</x-app-layout>
