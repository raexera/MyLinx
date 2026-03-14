<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center pt-2 sm:pt-4 w-full">
            <a href="{{ route('produk.index') }}" class="flex items-center gap-2 text-[14px] font-bold text-[#1A1C19] hover:text-[#2E5136] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Tambah Produk Baru
            </a>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="w-full max-w-[640px] mx-auto pb-16 pt-6">
        
        <!-- Header Center -->
        <div class="text-center mb-10">
            <h1 class="text-4xl sm:text-[2.75rem] font-serif text-[#1A1C19] tracking-tight leading-none mb-3">Tambah Produk</h1>
            <p class="text-[14px] font-medium text-[#6A7B8C]">Kurasi koleksi terbaik untuk pelanggan<br>Anda.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-[0_4px_24px_rgb(0,0,0,0.02)] border border-[#E8EBED]">
            
            <form action="#" method="POST" class="space-y-10">
                
                <!-- Foto Produk -->
                <div>
                    <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-4">Foto Produk</label>
                    
                    <!-- Dropzone -->
                    <div class="w-full h-[180px] rounded-2xl bg-[#f9fafb] border-2 border-dashed border-[#e5e7eb] flex flex-col items-center justify-center cursor-pointer hover:border-[#2E5136]/40 hover:bg-[#F4F6F9] transition-colors mb-5 group">
                         <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#2E5136] shadow-sm mb-3 group-hover:scale-105 transition-transform">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                         </div>
                         <h4 class="text-[14px] font-bold text-[#1A1C19] mb-1">Tarik foto ke sini atau klik untuk unggah</h4>
                         <p class="text-[11px] font-medium text-gray-400">Format: JPEG, PNG. Max size: 5MB.</p>
                    </div>

                    <!-- Thumbnails row -->
                    <div class="flex items-center gap-4">
                        <!-- Active Image -->
                        <div class="w-16 h-16 rounded-full p-[2px] bg-white border border-[#E8EBED] shadow-sm relative cursor-pointer group">
                             <div class="w-full h-full rounded-full overflow-hidden relative">
                                  <img src="https://images.unsplash.com/photo-1594026112284-02bb6f3352fe?auto=format&fit=crop&w=150&q=80" alt="Product thumbnail" class="w-full h-full object-cover">
                                  <!-- Hover overlay to imagine deleting or editing -->
                                  <div class="absolute inset-0 bg-black/20 hidden group-hover:flex items-center justify-center transition-all">
                                      <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                  </div>
                             </div>
                        </div>
                        
                        <!-- Add Another -->
                        <button type="button" class="w-16 h-16 rounded-full border border-dashed border-gray-300 flex items-center justify-center text-gray-400 hover:text-[#2E5136] hover:border-[#2E5136]/50 hover:bg-[#f9fafb] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Nama Produk</label>
                    <input type="text" placeholder="e.g. Kemeja Batik Modern Limited Edition" class="w-full h-12 bg-[#f9fafb] border border-transparent rounded-full px-5 text-[14px] text-[#1A1C19] font-medium shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus:border-[#E8EBED] focus:bg-white focus:ring-2 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-400">
                </div>

                <!-- Row: Harga & Stok -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <!-- Harga -->
                    <div>
                        <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Harga</label>
                        <div class="flex items-center bg-[#f9fafb] border border-transparent rounded-full h-12 px-5 shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus-within:border-[#E8EBED] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#2E5136] transition-colors">
                            <span class="text-[13px] font-bold text-gray-400 mr-2 uppercase">IDR</span>
                            <input type="text" value="0" class="flex-1 bg-transparent border-none outline-none text-[14px] font-bold text-gray-400 p-0 focus:ring-0 focus:text-[#1A1C19] w-full">
                        </div>
                    </div>
                    <!-- Stok -->
                    <div>
                        <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Stok</label>
                        <div class="flex items-center bg-[#f9fafb] border border-transparent rounded-full h-12 px-5 shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus-within:border-[#E8EBED] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#2E5136] transition-colors">
                            <svg class="w-[18px] h-[18px] text-gray-400 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <input type="text" value="0" class="flex-1 bg-transparent border-none outline-none text-[14px] font-bold text-gray-400 p-0 focus:ring-0 focus:text-[#1A1C19] w-full">
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="pb-2">
                    <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Deskripsi Lengkap</label>
                    <div class="border border-[#E8EBED] rounded-[1.25rem] bg-[#f9fafb] overflow-hidden focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors relative">
                        <!-- Toolbar -->
                        <div class="flex items-center gap-4 px-5 py-3 border-b border-[#E8EBED] bg-[#fcfcfd]">
                            <button type="button" class="text-gray-700 hover:text-black font-serif font-bold text-[15px]">B</button>
                            <button type="button" class="text-gray-700 hover:text-black font-serif italic text-[15px]">I</button>
                            <button type="button" class="text-gray-700 hover:text-black font-serif underline text-[15px] underline-offset-2">U</button>
                            
                            <div class="w-px h-4 bg-[#E8EBED] mx-1"></div>
                            
                            <button type="button" class="text-gray-500 hover:text-black">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 6h.01M8 12h.01M8 18h.01"></path></svg>
                            </button>
                            <button type="button" class="text-gray-500 hover:text-black">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            
                            <div class="w-px h-4 bg-[#E8EBED] mx-1"></div>
                            
                            <button type="button" class="text-gray-500 hover:text-black">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                            </button>
                        </div>
                        <!-- Textarea -->
                        <textarea class="w-full min-h-[140px] bg-transparent border-none px-5 py-4 text-[13.5px] text-gray-500 font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-400" placeholder="Ceritakan keunikan produk anda, bahan yang digunakan, dan cara perawatannya..."></textarea>
                    </div>
                    
                    <div class="flex justify-end mt-2 px-1">
                        <span class="text-[10px] text-gray-400 font-medium text-right leading-tight tracking-wide">0/2000<br>karakter</span>
                    </div>
                </div>

                <!-- Submit Action (Inside Card) -->
                <div class="flex flex-col items-center pt-2 gap-4">
                    <button type="submit" class="w-full bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full py-[14px] text-[14px] font-bold shadow-[0_4px_16px_rgb(46,81,54,0.25)] flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5">
                        Simpan Produk
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <a href="{{ route('produk.index') }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors">
                        Batal & Kembali
                    </a>
                </div>

            </form>
            
        </div>

        <!-- Footer Text Outside Card -->
        <div class="flex justify-center items-center gap-1.5 mt-8 text-[11px] font-bold text-gray-400">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            Data anda aman dan terenkripsi.
        </div>

    </div>
</x-app-layout>
