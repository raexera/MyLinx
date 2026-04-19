<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center pt-2 sm:pt-4 w-full">
            <a href="{{ route('produk.index') }}" class="flex items-center gap-2 text-[14px] font-bold text-[#1A1C19] hover:text-[#2E5136] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Edit Produk
            </a>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="w-full max-w-[640px] mx-auto pb-16 pt-6">

        <!-- Header Center -->
        <div class="text-center mb-10">
            <h1 class="text-4xl sm:text-[2.75rem] font-serif text-[#1A1C19] tracking-tight leading-none mb-3">Edit Produk</h1>
            <p class="text-[14px] font-medium text-[#6A7B8C]">Perbarui detail produk Anda.</p>
        </div>

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-5 py-4 rounded-2xl mb-6">
                <p class="font-bold mb-1">Terdapat kesalahan pada form:</p>
                <ul class="list-disc list-inside text-xs space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-[2rem] p-8 sm:p-10 shadow-[0_4px_24px_rgb(0,0,0,0.02)] border border-[#E8EBED]">

            <form action="{{ route('produk.update', $produk) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                @csrf
                @method('PUT')

                <!-- Foto Produk -->
                <div>
                    <label class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-4">Foto Produk</label>

                    <input type="file" name="gambar" id="gambar" class="hidden" accept="image/jpeg,image/png">

                    <div onclick="document.getElementById('gambar').click()" class="w-full h-[180px] rounded-2xl bg-[#f9fafb] border-2 border-dashed border-[#e5e7eb] flex flex-col items-center justify-center cursor-pointer hover:border-[#2E5136]/40 hover:bg-[#F4F6F9] transition-colors mb-5 group">
                         <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-[#2E5136] shadow-sm mb-3 group-hover:scale-105 transition-transform">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                         </div>
                         <h4 class="text-[14px] font-bold text-[#1A1C19] mb-1">Klik untuk ganti foto</h4>
                         <p class="text-[11px] font-medium text-gray-400">Kosongkan jika tidak ingin mengganti foto.</p>
                    </div>

                    {{-- Current image preview --}}
                    <div id="preview-container" class="flex items-center gap-4 {{ $produk->gambar ? '' : 'hidden' }}">
                        <div class="w-16 h-16 rounded-full p-[2px] bg-white border border-[#E8EBED] shadow-sm relative">
                             <div class="w-full h-full rounded-full overflow-hidden">
                                  <img id="preview-image" src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : '' }}" alt="Preview" class="w-full h-full object-cover">
                             </div>
                        </div>
                        <span id="preview-name" class="text-xs text-gray-500 font-medium">{{ $produk->gambar ? 'Foto saat ini' : '' }}</span>
                    </div>

                    @error('gambar')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label for="nama_produk" class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Nama Produk</label>
                    <input type="text" name="nama_produk" id="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" placeholder="e.g. Kemeja Batik Modern Limited Edition" class="w-full h-12 bg-[#f9fafb] border border-transparent rounded-full px-5 text-[14px] text-[#1A1C19] font-medium shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus:border-[#E8EBED] focus:bg-white focus:ring-2 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-400" required>
                    @error('nama_produk')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Row: Harga & Stok -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="harga" class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Harga</label>
                        <div class="flex items-center bg-[#f9fafb] border border-transparent rounded-full h-12 px-5 shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus-within:border-[#E8EBED] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#2E5136] transition-colors">
                            <span class="text-[13px] font-bold text-gray-400 mr-2 uppercase">IDR</span>
                            <input type="number" name="harga" id="harga" value="{{ old('harga', $produk->harga) }}" min="0" step="1000" class="flex-1 bg-transparent border-none outline-none text-[14px] font-bold p-0 focus:ring-0 text-[#1A1C19] w-full" required>
                        </div>
                        @error('harga')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="stok" class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Stok</label>
                        <div class="flex items-center bg-[#f9fafb] border border-transparent rounded-full h-12 px-5 shadow-[inset_0_1px_2px_rgb(0,0,0,0.02)] focus-within:border-[#E8EBED] focus-within:bg-white focus-within:ring-2 focus-within:ring-[#2E5136] transition-colors">
                            <svg class="w-[18px] h-[18px] text-gray-400 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" min="0" class="flex-1 bg-transparent border-none outline-none text-[14px] font-bold p-0 focus:ring-0 text-[#1A1C19] w-full" required>
                        </div>
                        @error('stok')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Varian (opsional) --}}
                    <div x-data="{ showVariants: {{ old('varian_label', $produk->varian_label ?? '') ? 'true' : 'false' }} }">
                        <div class="flex items-center gap-3 mb-3">
                            <label class="block font-serif text-[17px] font-bold text-[#1A1C19]">Varian Produk</label>
                            <button type="button" @click="showVariants = !showVariants"
                                    class="text-[12px] font-bold text-[#2E5136] hover:underline">
                                <span x-show="!showVariants">+ Tambah varian</span>
                                <span x-show="showVariants">− Sembunyikan</span>
                            </button>
                        </div>

                        <div x-show="showVariants" x-cloak class="space-y-4 p-5 bg-[#f9fafb] border border-[#E8EBED] rounded-2xl">
                            <div>
                                <label class="block text-[11px] font-bold text-[#1A1C19] uppercase tracking-widest mb-2">Nama Varian</label>
                                <input type="text" name="varian_label" value="{{ old('varian_label', $produk->varian_label ?? '') }}"
                                    placeholder="mis. Rasa, Ukuran, Warna"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[14px] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none">
                                <p class="mt-1 text-[11px] text-gray-400">Label yang dilihat pembeli.</p>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-[#1A1C19] uppercase tracking-widest mb-2">Opsi Varian</label>
                                <input type="text" name="varian_opsi" value="{{ old('varian_opsi', $produk->varian_opsi ?? '') }}"
                                    placeholder="mis. Coklat, Stroberi, Vanila"
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[14px] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none">
                                <p class="mt-1 text-[11px] text-gray-400">Pisahkan dengan koma. Stok dan harga tetap sama untuk semua opsi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Lengkap -->
                <div class="pb-2">
                    <label for="deskripsi" class="block font-serif text-[17px] font-bold text-[#1A1C19] mb-3">Deskripsi Lengkap</label>
                    <div class="border border-[#E8EBED] rounded-[1.25rem] bg-[#f9fafb] overflow-hidden focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors relative">
                        <div class="flex items-center gap-4 px-5 py-3 border-b border-[#E8EBED] bg-[#fcfcfd]">
                            <button type="button" class="text-gray-700 hover:text-black font-serif font-bold text-[15px]">B</button>
                            <button type="button" class="text-gray-700 hover:text-black font-serif italic text-[15px]">I</button>
                            <button type="button" class="text-gray-700 hover:text-black font-serif underline text-[15px] underline-offset-2">U</button>
                        </div>
                        <textarea name="deskripsi" id="deskripsi" class="w-full min-h-[140px] bg-transparent border-none px-5 py-4 text-[13.5px] text-[#1A1C19] font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-400" placeholder="Ceritakan keunikan produk anda..." maxlength="2000" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>
                    @error('deskripsi')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex flex-col items-center pt-2 gap-4">
                    <button type="submit" class="w-full bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full py-[14px] text-[14px] font-bold shadow-[0_4px_16px_rgb(46,81,54,0.25)] flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5">
                        Perbarui Produk
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                    <a href="{{ route('produk.index') }}" class="text-[12.5px] font-bold text-gray-400 hover:text-[#1A1C19] transition-colors">
                        Batal & Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script>
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const container = document.getElementById('preview-container');
                const img = document.getElementById('preview-image');
                const name = document.getElementById('preview-name');
                img.src = URL.createObjectURL(file);
                name.textContent = file.name;
                container.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
