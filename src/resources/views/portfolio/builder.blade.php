<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-5 lg:gap-8 mt-2 lg:mt-0 xl:pr-10 w-full mb-4">
            
            <!-- Left Side: Titles -->
            <div class="flex flex-col">
                <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Portfolio Builder</h1>
                <p class="text-[13px] sm:text-[14px] font-medium text-[#6A7B8C] mt-2">Curate your professional online narrative.</p>
            </div>
            
            <!-- Right Side: Action Buttons -->
            <div class="flex items-center gap-3 w-full sm:max-w-max">
                 <button class="flex items-center justify-center gap-2 bg-[#EAF2ED] hover:bg-[#d8e6de] text-[#2E5136] px-5 py-[11px] rounded-full text-[13px] font-bold transition-colors w-full sm:w-auto shadow-sm">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                     </svg>
                     Preview Site
                 </button>
                 <button class="flex items-center justify-center bg-[#2E5136] hover:bg-[#1f3824] text-white px-6 py-[11px] rounded-full text-[13px] font-bold transition-colors w-full sm:w-auto shadow-sm shadow-[#2E5136]/30">
                     Publish Changes
                 </button>
            </div>
        </div>
    </x-slot>

    <!-- Builder Container -->
    <div class="flex flex-col lg:flex-row h-[calc(100vh-180px)] xl:h-[calc(100vh-140px)] gap-6 lg:gap-8 overflow-hidden pr-2 lg:pr-10 pt-4">
        
        <!-- Left Column: Sidebar Structure -->
        <div class="w-full lg:w-[320px] flex flex-col h-full flex-shrink-0">
            
            <div class="flex justify-between items-center mb-4 px-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">STRUKTUR HALAMAN</span>
                <button class="text-gray-400 hover:text-[#1A1C19] transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </button>
            </div>

            <!-- Add Section Button -->
            <button class="w-full flex items-center justify-center gap-2 border-[1.5px] border-dashed border-[#2E5136]/30 bg-white hover:bg-[#EAF2ED]/50 text-[#2E5136] py-3.5 rounded-2xl text-[13.5px] font-bold transition-colors mb-4 group shadow-sm">
                <div class="w-5 h-5 rounded-full border-[1.5px] border-[#2E5136] flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                </div>
                Add Section
            </button>

            <!-- Sections List (Scrollable) -->
            <div class="flex-1 overflow-y-auto space-y-3 pb-6 hide-scroll px-1">
                
                <!-- Item 1: Active -->
                <div class="flex items-center justify-between p-4 bg-[#2E5136] text-white rounded-2xl shadow-md cursor-grab active:cursor-grabbing border border-[#1f3824]/50">
                    <div class="flex items-center gap-3">
                        <div class="flex flex-col gap-[3px] opacity-50">
                            <div class="w-1 h-1 rounded-full bg-white"></div>
                            <div class="w-1 h-1 rounded-full bg-white"></div>
                            <div class="w-1 h-1 rounded-full bg-white"></div>
                        </div>
                        <div>
                            <div class="font-bold text-[13px] leading-tight">Hero Section</div>
                            <div class="text-[11px] text-white/70 font-medium">Main introduction</div>
                        </div>
                    </div>
                    <button class="opacity-80 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>

                <!-- Item 2 -->
                <div class="flex items-center justify-between p-4 bg-white text-[#1A1C19] border border-[#E8EBED] rounded-2xl shadow-sm cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="grid grid-cols-2 gap-[2px] opacity-30">
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                        </div>
                        <div class="ml-1">
                            <div class="font-bold text-[13px] leading-tight text-[#1A1C19]">About Brand</div>
                            <div class="text-[11px] text-gray-400 font-medium">Story & values</div>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>

                <!-- Item 3 -->
                <div class="flex items-center justify-between p-4 bg-white text-[#1A1C19] border border-[#E8EBED] rounded-2xl shadow-sm cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="grid grid-cols-2 gap-[2px] opacity-30">
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                        </div>
                        <div class="ml-1">
                            <div class="font-bold text-[13px] leading-tight text-[#1A1C19]">Product Gallery</div>
                            <div class="text-[11px] text-gray-400 font-medium">Featured items</div>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    </button>
                </div>

                <!-- Item 4 (Hidden) -->
                <div class="flex items-center justify-between p-4 bg-white/50 text-[#1A1C19] border border-[#E8EBED]/50 rounded-2xl shadow-sm cursor-grab active:cursor-grabbing hover:border-gray-300 transition-colors opacity-70">
                    <div class="flex items-center gap-3">
                        <div class="grid grid-cols-2 gap-[2px] opacity-30">
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                            <div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div><div class="w-[3px] h-[3px] rounded-full bg-gray-500"></div>
                        </div>
                        <div class="ml-1">
                            <div class="font-bold text-[13px] leading-tight text-gray-500">Contact Info</div>
                            <div class="text-[11px] text-gray-400 font-medium">Hidden from site</div>
                        </div>
                    </div>
                    <button class="text-gray-300 hover:text-gray-500 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                    </button>
                </div>

            </div>
        </div>

        <!-- Right Column: Editor Panel -->
        <div class="flex-1 bg-white rounded-t-[2rem] lg:rounded-t-none lg:rounded-[2rem] border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex flex-col h-full relative overflow-hidden">
            
            <div class="flex-1 overflow-y-auto w-full p-6 lg:p-10 hide-scroll pb-24">
                
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="bg-[#EAF2ED] text-[#2E5136] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3 w-fit">EDITING</div>
                        <h2 class="text-[2rem] font-serif text-[#1A1C19]">Hero Section</h2>
                    </div>
                    <button class="text-[#aab2bf] hover:text-red-500 transition-colors pt-1">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>

                <!-- Form Fields -->
                <div class="space-y-6 max-w-2xl">
                    
                    <!-- Title -->
                    <div>
                        <label class="block text-[13px] font-bold text-gray-500 mb-2">Title Headline</label>
                        <input type="text" value="Artisan Crafts for Modern Homes" class="w-full h-[48px] bg-white border border-[#E8EBED] rounded-full px-6 text-[15px] text-[#1A1C19] font-serif shadow-sm focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors">
                    </div>

                    <!-- Subtitle -->
                    <div>
                        <label class="block text-[13px] font-bold text-gray-500 mb-2">Subtitle</label>
                        <input type="text" value="Handmade in Bali, shipped globally." class="w-full h-[48px] bg-white border border-[#E8EBED] rounded-full px-6 text-[14px] text-[#1A1C19] font-medium shadow-sm focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-[13px] font-bold text-gray-500 mb-2">Description</label>
                        <div class="border border-[#E8EBED] rounded-2xl bg-white overflow-hidden shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <!-- Toolbar -->
                            <div class="flex items-center gap-4 px-5 py-3 border-b border-[#E8EBED] bg-white">
                                <button class="text-gray-600 hover:text-black font-serif font-bold text-sm">B</button>
                                <button class="text-gray-600 hover:text-black font-serif italic text-sm">I</button>
                                <button class="text-gray-500 hover:text-black">
                                    <svg class="w-[15px] h-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 6h.01M8 12h.01M8 18h.01"></path></svg>
                                </button>
                                <button class="text-gray-500 hover:text-black">
                                    <svg class="w-[15px] h-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                </button>
                            </div>
                            <textarea class="w-full min-h-[100px] bg-white border-none px-5 py-4 text-[13.5px] text-[#6A7B8C] font-medium leading-relaxed resize-none focus:ring-0 outline-none" rows="4">Discover our curated collection of sustainable home goods, crafted by local artisans using traditional techniques passed down through generations.</textarea>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-[13px] font-bold text-gray-500 mb-2">Cover Image</label>
                        <div class="w-full aspect-[21/9] rounded-[1.5rem] relative overflow-hidden group cursor-pointer border-[1.5px] border-dashed border-[#d1d5db] bg-[#f9fafb] hover:border-[#2E5136]/50 transition-colors">
                            <!-- Background Image Mockup -->
                            <div class="absolute inset-0 opacity-60">
                                <img src="https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?auto=format&fit=crop&w=1200&q=80" class="w-full h-full object-cover grayscale-[30%]" alt="Bg placeholder">
                            </div>
                            
                            <!-- Upload Box Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-white/95 backdrop-blur-md rounded-[1.5rem] p-6 shadow-sm border border-white flex flex-col items-center gap-2 transform group-hover:scale-105 transition-transform duration-300">
                                    <div class="w-10 h-10 rounded-full bg-[#EAF2ED] flex items-center justify-center text-[#2E5136] mb-1">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                    </div>
                                    <span class="text-[14px] font-bold text-[#1A1C19]">Click or drag image here</span>
                                    <span class="text-[10px] text-gray-400 font-medium text-center">Recommended: 1920x1080px (Max<br>5MB)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2 Columns: Button Text & Link -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2 mb-10">
                        <div>
                            <label class="block text-[13px] font-bold text-gray-500 mb-2">Button Text</label>
                            <input type="text" value="Shop Collection" class="w-full h-[48px] bg-white border border-[#E8EBED] rounded-full px-5 text-[14px] text-[#1A1C19] font-medium shadow-sm focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-bold text-gray-500 mb-2">Link URL</label>
                            <div class="flex items-center border border-[#E8EBED] rounded-full bg-white h-[48px] px-4 shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                                <svg class="w-4 h-4 text-gray-400 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                <input type="text" class="flex-1 bg-transparent border-none outline-none text-[13.5px] font-medium text-gray-600 p-0 focus:ring-0 w-full font-mono" value="/collections/new-arri">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Fixed Footer Bottom Save Button inside the Card Panel -->
            <div class="absolute bottom-0 inset-x-0 h-[80px] bg-gradient-to-t from-white via-white to-white/0 flex justify-end items-end p-6 pointer-events-none">
                 <button class="pointer-events-auto bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-8 py-[12px] font-bold text-[13.5px] shadow-[0_8px_20px_rgb(46,81,54,0.3)] flex items-center gap-2 transition-all transform hover:-translate-y-0.5 relative z-10 bottom-2 right-2">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                     Save Section
                 </button>
            </div>
            
        </div>

    </div>
</x-app-layout>
