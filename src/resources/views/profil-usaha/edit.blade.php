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

            @if(Auth::user()->tenant)
            <div class="flex items-center gap-3 shrink-0 mb-2 sm:mb-4">
                 <a href="{{ route('tenant.show', Auth::user()->tenant) }}" target="_blank" class="bg-transparent border border-[#E8EBED] hover:bg-white text-[#1A1C19] flex items-center justify-center px-8 py-[10px] rounded-full text-[13.5px] font-bold transition-all shadow-sm">
                     Preview Store
                 </a>
            </div>
            @endif
        </div>
    </x-slot>

    <!-- Content wrapper -->
    <div class="w-full lg:pr-4 xl:pr-8 pb-16 flex flex-col mt-8 relative z-10">

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

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

        <div class="absolute -top-40 right-0 w-[500px] h-[500px] bg-white rounded-full opacity-40 blur-[80px] pointer-events-none -z-10"></div>

        <form action="{{ route('profil-usaha.update') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf
            @method('PATCH')

            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Visual Identity -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-12">
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2 text-shadow-sm">Visual Identity</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Your logo is the face of your brand. Upload a high-quality image to build trust.
                    </p>
                </div>
                <div class="flex-1">
                    {{-- Hidden file input for logo --}}
                    <input type="file" name="logo" id="logo" class="hidden" accept="image/jpeg,image/png">

                    <div onclick="document.getElementById('logo').click()" class="bg-white rounded-[2rem] p-6 sm:p-8 flex flex-col sm:flex-row items-center gap-6 border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.015)] group cursor-pointer hover:border-[#2E5136]/30 transition-colors">
                        <!-- Upload Circle / Current Logo -->
                        <div class="w-[120px] h-[120px] rounded-full border-2 border-dashed border-[#d1d5db] group-hover:border-[#2E5136]/50 flex items-center justify-center shrink-0 bg-[#f9fafb] group-hover:bg-[#f2f4f3] transition-colors relative overflow-hidden">
                            @if($profil->logo)
                                <img id="logo-preview" src="{{ asset('storage/' . $profil->logo) }}" alt="Logo" class="w-full h-full object-cover">
                            @else
                                <svg id="logo-placeholder" class="w-7 h-7 text-[#2E5136]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <img id="logo-preview" src="" alt="Logo preview" class="w-full h-full object-cover hidden absolute inset-0">
                            @endif
                        </div>

                        <div class="text-center sm:text-left">
                            <h3 class="text-[15px] font-bold text-[#1A1C19] mb-1">{{ $profil->logo ? 'Ganti Logo' : 'Upload Business Logo' }}</h3>
                            <p class="text-[12.5px] font-medium text-gray-400 mb-3 leading-relaxed">
                                Drag and drop your logo here, or click to browse.<br>
                                Recommended size: 500x500px (JPG, PNG)
                            </p>
                            <span class="inline-block bg-[#f9fafb] border border-[#E8EBED] text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Max 2MB
                            </span>
                        </div>
                    </div>

                    @error('logo')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Core Info -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-12">
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2">Core Info</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Tell your story. A compelling description helps customers connect with your brand.
                    </p>
                </div>
                <div class="flex-1 space-y-8">

                    <!-- Nama Usaha -->
                    <div>
                        <label for="nama_usaha" class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">NAMA USAHA</label>
                        <input type="text" name="nama_usaha" id="nama_usaha" value="{{ old('nama_usaha', $profil->nama_usaha) }}" placeholder="e.g. Kopi Senja Nusantara" class="w-full h-14 bg-white border border-[#E8EBED] rounded-[1rem] px-5 text-[14.5px] text-[#1A1C19] font-medium shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-300" required>
                        @error('nama_usaha')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">ALAMAT USAHA</label>
                        <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $profil->alamat) }}" placeholder="e.g. Jl. Sudirman No. 45, Jakarta Selatan" class="w-full h-14 bg-white border border-[#E8EBED] rounded-[1rem] px-5 text-[14.5px] text-[#1A1C19] font-medium shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-300" required>
                        @error('alamat')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Brand -->
                    <div>
                        <label for="deskripsi" class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">DESKRIPSI BRAND</label>
                        <div class="border border-[#E8EBED] rounded-[1.5rem] bg-white overflow-hidden focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors shadow-[0_2px_10px_rgb(0,0,0,0.01)]">
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
                            <textarea name="deskripsi" id="deskripsi" class="w-full min-h-[160px] bg-transparent border-none px-6 py-5 text-[14.5px] text-[#1A1C19] font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-300" placeholder="Write about your journey, your values, and what makes your products special..." required>{{ old('deskripsi', $profil->deskripsi) }}</textarea>
                        </div>
                        @error('deskripsi')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="h-4"></div>
            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Contact & Social -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-8">
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2">Contact &amp; Social</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Make it easy for customers to reach you and follow your latest updates.
                    </p>
                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">

                    <!-- WhatsApp Kontak -->
                    <div>
                        <label for="no_hp" class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">WHATSAPP KONTAK</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)] focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors">
                            <svg class="w-5 h-5 text-gray-400 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp', $profil->no_hp) }}" placeholder="+62 812 3456 7890" class="flex-1 bg-transparent border-none outline-none text-[14px] text-[#1A1C19] font-medium p-0 focus:ring-0 placeholder:text-gray-300 w-full placeholder:font-normal" required>
                        </div>
                        @error('no_hp')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Bisnis (read-only, from auth user) -->
                    <div>
                        <label class="block text-[10.5px] font-bold text-[#1A1C19] uppercase tracking-[0.15em] mb-2.5">EMAIL BISNIS</label>
                        <div class="flex items-center bg-white border border-[#E8EBED] rounded-full h-14 px-5 shadow-[0_2px_10px_rgb(0,0,0,0.01)]">
                            <svg class="w-5 h-5 text-gray-400 mr-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <input type="text" value="{{ Auth::user()->email }}" class="flex-1 bg-transparent border-none outline-none text-[14px] text-gray-400 font-medium p-0 focus:ring-0 w-full" disabled>
                        </div>
                    </div>

                </div>
            </div>
            <div class="w-full h-px bg-[#E8EBED] mb-12"></div>

            <!-- Pembayaran QRIS -->
            <div class="flex flex-col md:flex-row gap-8 md:gap-16 mb-12">
                <div class="md:w-[260px] shrink-0">
                    <h2 class="text-[1.35rem] font-serif text-[#1A1C19] mb-2">Pembayaran QRIS</h2>
                    <p class="text-[12.5px] font-medium text-[#2E5136] opacity-70 leading-relaxed max-w-[220px]">
                        Upload QRIS usahamu agar pelanggan bisa membayar langsung dengan scan.
                        Sistem akan validasi otomatis bahwa gambar adalah QRIS resmi.
                    </p>
                </div>

                <div class="flex-1">
                    <input type="file" name="qris_image" id="qris_image" class="hidden" accept="image/jpeg,image/png">

                    <div class="bg-white rounded-[2rem] p-6 sm:p-8 border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.015)]">
                        @if($profil->qris_image)
                            {{-- Has QRIS — show preview + details --}}
                            <div class="flex flex-col sm:flex-row gap-6 items-start">
                                <div class="w-[160px] h-[160px] rounded-2xl overflow-hidden border border-[#E8EBED] shrink-0 bg-white p-2">
                                    <img src="{{ asset('storage/' . $profil->qris_image) }}"
                                        alt="QRIS {{ $profil->qris_merchant_name }}"
                                        class="w-full h-full object-contain">
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#ECFDF5] text-[#059669] text-[10px] font-bold uppercase tracking-widest rounded-full border border-[#A7F3D0]">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            Terverifikasi
                                        </span>
                                    </div>

                                    <div class="space-y-2 mb-5">
                                        <div>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Atas Nama</p>
                                            <p class="text-[14px] font-bold text-[#1A1C19]">{{ $profil->qris_merchant_name ?? 'Tidak diketahui' }}</p>
                                        </div>
                                        @if($profil->qris_nmid)
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">NMID</p>
                                                <p class="text-[12px] font-mono text-gray-600">{{ $profil->qris_nmid }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap items-center gap-3">
                                        <button type="button"
                                                onclick="document.getElementById('qris_image').click()"
                                                class="inline-flex items-center gap-1.5 bg-white border border-[#E8EBED] hover:bg-gray-50 text-[#1A1C19] px-4 py-2 rounded-full text-[12px] font-bold transition-colors">
                                            Ganti QRIS
                                        </button>
                                        <button type="button"
                                                onclick="document.getElementById('qris-remove-form').submit()"
                                                class="text-[12px] font-bold text-red-500 hover:text-red-700 transition-colors">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Preview after new upload (hidden until file picked) --}}
                            <div id="qris-new-preview" class="mt-4 hidden p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                <p class="text-[12px] font-bold text-amber-800 mb-2">File baru dipilih:</p>
                                <img id="qris-new-img" class="w-[100px] h-[100px] object-contain rounded-lg bg-white border border-amber-100 p-1">
                                <p class="text-[11px] text-amber-700 mt-2">Klik <strong>Simpan Profil</strong> di atas untuk memvalidasi & mengganti QRIS.</p>
                            </div>
                        @else
                            {{-- No QRIS yet — upload prompt --}}
                            <div onclick="document.getElementById('qris_image').click()"
                                class="cursor-pointer group">
                                <div class="border-2 border-dashed border-[#d1d5db] group-hover:border-[#2E5136]/50 rounded-2xl p-8 text-center bg-[#f9fafb] group-hover:bg-[#f2f4f3] transition-colors">
                                    <div class="w-14 h-14 mx-auto mb-4 rounded-full bg-white border border-[#E8EBED] flex items-center justify-center">
                                        <svg class="w-6 h-6 text-[#2E5136]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-[14px] font-bold text-[#1A1C19] mb-1">Upload Gambar QRIS</p>
                                    <p class="text-[12px] text-gray-500 mb-3">JPG atau PNG, maksimal 2MB</p>
                                    <span class="inline-block bg-white border border-[#E8EBED] text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                        Akan divalidasi otomatis
                                    </span>
                                </div>

                                {{-- Preview after upload (hidden until file picked) --}}
                                <div id="qris-new-preview" class="mt-4 hidden p-4 bg-amber-50 border border-amber-200 rounded-xl">
                                    <p class="text-[12px] font-bold text-amber-800 mb-2">File dipilih:</p>
                                    <img id="qris-new-img" class="w-[100px] h-[100px] object-contain rounded-lg bg-white border border-amber-100 p-1">
                                    <p class="text-[11px] text-amber-700 mt-2">Klik <strong>Simpan Profil</strong> di atas untuk upload & validasi.</p>
                                </div>
                            </div>
                        @endif

                        {{-- Info box --}}
                        <div class="mt-5 p-4 bg-[#EFF6F2] rounded-xl flex items-start gap-3">
                            <svg class="w-5 h-5 text-[#2E5136] shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div class="text-[12px] text-[#2E5136]/80 leading-relaxed">
                                <strong>Bagaimana cara kerjanya?</strong><br>
                                Saat pelanggan checkout, gambar QRIS kamu dikirim ke email mereka bersama invoice. Mereka scan &amp; bayar via e-wallet (GoPay, DANA, OVO, ShopeePay, dll). Setelah terima konfirmasi, kamu ubah status order ke "Lunas" secara manual.
                            </div>
                        </div>
                    </div>

                    @error('qris_image')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-6 border-t border-[#E8EBED] pt-8 mb-4 flex-col sm:flex-row">
                 <a href="{{ route('dashboard') }}" class="text-[13.5px] font-medium text-[#8b9196] hover:text-[#1A1C19] transition-colors order-2 sm:order-1">
                     Batal
                 </a>
                 <button type="submit" class="w-full sm:w-auto bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-8 py-3.5 text-[14px] font-bold shadow-[0_4px_16px_rgb(46,81,54,0.25)] flex items-center justify-center gap-2.5 transition-all transform hover:-translate-y-0.5 order-1 sm:order-2">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                     Simpan Profil
                 </button>
            </div>
        </form>
        {{-- Separate form for removing QRIS (can't be nested inside the main form) --}}
        <form id="qris-remove-form" action="{{ route('profil-usaha.remove-qris') }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>

    <script>
        // Logo preview (existing)
        document.getElementById('logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('logo-preview');
                const placeholder = document.getElementById('logo-placeholder');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');
            }
        });

        // QRIS preview — confirms user has selected a file before they hit submit
        document.getElementById('qris_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const preview = document.getElementById('qris-new-preview');
                const img     = document.getElementById('qris-new-img');
                img.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            }
        });
    </script>
</x-app-layout>
