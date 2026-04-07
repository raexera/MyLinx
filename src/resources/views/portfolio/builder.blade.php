<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    <x-slot name="header">
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">WEBSITE — PORTFOLIO</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] tracking-tight mb-2">Portfolio Builder</h1>
            <p class="text-[13px] sm:text-[14px] font-medium text-[#6A7B8C]">Curate your professional online narrative.</p>
        </div>
    </x-slot>

    <!-- Builder Container -->
    <div class="flex flex-col lg:flex-row h-[calc(100vh-180px)] xl:h-[calc(100vh-140px)] gap-6 lg:gap-8 overflow-hidden pr-2 pt-4">

        {{-- ================================================================
             LEFT COLUMN: Portfolio Items List
             ================================================================ --}}
        <div class="w-full lg:w-[320px] flex flex-col h-full flex-shrink-0">

            <div class="flex justify-between items-center mb-4 px-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">PORTOFOLIO ({{ $portofolios->count() }})</span>
            </div>

            {{-- Flash success --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-xs font-medium px-4 py-2.5 rounded-xl mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Sections List (Scrollable) -->
            <div class="flex-1 overflow-y-auto space-y-3 pb-6 hide-scroll px-1">

                @forelse($portofolios as $item)
                    <div class="flex items-center justify-between p-4 {{ (isset($editing) && $editing->id === $item->id) ? 'bg-[#2E5136] text-white rounded-2xl shadow-md border border-[#1f3824]/50' : 'bg-white text-[#1A1C19] border border-[#E8EBED] rounded-2xl shadow-sm hover:border-gray-300' }} transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            {{-- Thumbnail --}}
                            @if($item->gambar)
                                <div class="w-10 h-10 rounded-xl overflow-hidden shrink-0 border {{ (isset($editing) && $editing->id === $item->id) ? 'border-white/20' : 'border-[#E8EBED]' }}">
                                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-xl shrink-0 {{ (isset($editing) && $editing->id === $item->id) ? 'bg-white/10' : 'bg-gray-100' }} flex items-center justify-center">
                                    <svg class="w-4 h-4 {{ (isset($editing) && $editing->id === $item->id) ? 'text-white/60' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div class="font-bold text-[13px] leading-tight truncate">{{ $item->judul }}</div>
                                <div class="text-[11px] {{ (isset($editing) && $editing->id === $item->id) ? 'text-white/70' : 'text-gray-400' }} font-medium truncate">{{ Str::limit($item->deskripsi, 30) }}</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-1 shrink-0 ml-2">
                            {{-- Edit button --}}
                            <a href="{{ route('portfolio.edit', $item) }}" class="{{ (isset($editing) && $editing->id === $item->id) ? 'text-white/80 hover:text-white' : 'text-gray-400 hover:text-[#2E5136]' }} transition-colors p-1" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </a>
                            {{-- Delete form --}}
                            <form action="{{ route('portfolio.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus portofolio ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{ (isset($editing) && $editing->id === $item->id) ? 'text-white/60 hover:text-red-300' : 'text-gray-300 hover:text-red-500' }} transition-colors p-1" title="Hapus">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="text-3xl mb-3">🖼️</div>
                        <p class="text-sm text-gray-400 font-medium">Belum ada portofolio.</p>
                        <p class="text-xs text-gray-400 mt-1">Gunakan editor di sebelah kanan untuk menambahkan.</p>
                    </div>
                @endforelse

            </div>
        </div>

        {{-- ================================================================
             RIGHT COLUMN: Editor Panel
             ================================================================ --}}
        <div class="flex-1 bg-white rounded-t-[2rem] lg:rounded-t-none lg:rounded-[2rem] border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex flex-col h-full relative overflow-hidden">

            <div class="flex-1 overflow-y-auto w-full p-6 lg:p-10 hide-scroll pb-24">

                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div class="bg-[#EAF2ED] text-[#2E5136] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3 w-fit">
                            {{ isset($editing) ? 'EDITING' : 'NEW ITEM' }}
                        </div>
                        <h2 class="text-[2rem] font-serif text-[#1A1C19]">
                            {{ isset($editing) ? $editing->judul : 'Tambah Portofolio' }}
                        </h2>
                    </div>
                    @if(isset($editing))
                        <a href="{{ route('portfolio.index') }}" class="text-[#aab2bf] hover:text-[#1A1C19] transition-colors pt-1 text-xs font-bold">
                            ✕ Batal Edit
                        </a>
                    @endif
                </div>

                {{-- Validation errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-5 py-4 rounded-2xl mb-6">
                        <p class="font-bold mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Dynamic form: switches between store and update --}}
                <form
                    action="{{ isset($editing) ? route('portfolio.update', $editing) : route('portfolio.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @if(isset($editing))
                        @method('PUT')
                    @endif

                    <!-- Form Fields -->
                    <div class="space-y-6 max-w-2xl">

                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-[13px] font-bold text-gray-500 mb-2">Judul Portofolio</label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $editing->judul ?? '') }}" placeholder="e.g. Koleksi Lebaran 2025" class="w-full h-[48px] bg-white border border-[#E8EBED] rounded-full px-6 text-[15px] text-[#1A1C19] font-serif shadow-sm focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-300" required>
                            @error('judul')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-[13px] font-bold text-gray-500 mb-2">Deskripsi</label>
                            <div class="border border-[#E8EBED] rounded-2xl bg-white overflow-hidden shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                                <!-- Toolbar (decorative for MVP) -->
                                <div class="flex items-center gap-4 px-5 py-3 border-b border-[#E8EBED] bg-white">
                                    <button type="button" class="text-gray-600 hover:text-black font-serif font-bold text-sm">B</button>
                                    <button type="button" class="text-gray-600 hover:text-black font-serif italic text-sm">I</button>
                                    <button type="button" class="text-gray-500 hover:text-black">
                                        <svg class="w-[15px] h-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16M8 6h.01M8 12h.01M8 18h.01"></path></svg>
                                    </button>
                                    <button type="button" class="text-gray-500 hover:text-black">
                                        <svg class="w-[15px] h-[15px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    </button>
                                </div>
                                <textarea name="deskripsi" id="deskripsi" class="w-full min-h-[100px] bg-white border-none px-5 py-4 text-[13.5px] text-[#1A1C19] font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-300" placeholder="Ceritakan tentang proyek ini, proses pembuatan, dan hasilnya..." required>{{ old('deskripsi', $editing->deskripsi ?? '') }}</textarea>
                            </div>
                            @error('deskripsi')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <label class="block text-[13px] font-bold text-gray-500 mb-2">Cover Image</label>

                            <input type="file" name="gambar" id="gambar" class="hidden" accept="image/jpeg,image/png">

                            <div onclick="document.getElementById('gambar').click()" class="w-full aspect-[21/9] rounded-[1.5rem] relative overflow-hidden group cursor-pointer border-[1.5px] border-dashed border-[#d1d5db] bg-[#f9fafb] hover:border-[#2E5136]/50 transition-colors">

                                {{-- Current image (edit mode) --}}
                                @if(isset($editing) && $editing->gambar)
                                    <div class="absolute inset-0" id="current-cover">
                                        <img src="{{ asset('storage/' . $editing->gambar) }}" class="w-full h-full object-cover" alt="Current cover">
                                    </div>
                                @endif

                                {{-- Preview for newly selected file --}}
                                <div class="absolute inset-0 hidden" id="preview-cover">
                                    <img id="preview-cover-img" src="" class="w-full h-full object-cover" alt="New cover preview">
                                </div>

                                <!-- Upload Box Overlay -->
                                <div class="absolute inset-0 flex items-center justify-center" id="upload-overlay">
                                    <div class="bg-white/95 backdrop-blur-md rounded-[1.5rem] p-6 shadow-sm border border-white flex flex-col items-center gap-2 transform group-hover:scale-105 transition-transform duration-300">
                                        <div class="w-10 h-10 rounded-full bg-[#EAF2ED] flex items-center justify-center text-[#2E5136] mb-1">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span class="text-[14px] font-bold text-[#1A1C19]">
                                            {{ isset($editing) ? 'Klik untuk ganti gambar' : 'Click or drag image here' }}
                                        </span>
                                        <span class="text-[10px] text-gray-400 font-medium text-center">Recommended: 1920x1080px (Max 5MB)</span>
                                    </div>
                                </div>
                            </div>

                            @error('gambar')
                                <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Submit button (fixed at bottom) --}}
                    <div class="mt-10">
                        <button type="submit" class="bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-8 py-[12px] font-bold text-[13.5px] shadow-[0_8px_20px_rgb(46,81,54,0.3)] flex items-center gap-2 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            {{ isset($editing) ? 'Perbarui Portofolio' : 'Simpan Portofolio' }}
                        </button>
                    </div>
                </form>

            </div>

        </div>

    </div>

    {{-- Image preview script --}}
    <script>
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const previewCover = document.getElementById('preview-cover');
                const previewImg = document.getElementById('preview-cover-img');
                const currentCover = document.getElementById('current-cover');

                previewImg.src = URL.createObjectURL(file);
                previewCover.classList.remove('hidden');

                // Hide current image if in edit mode
                if (currentCover) currentCover.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
