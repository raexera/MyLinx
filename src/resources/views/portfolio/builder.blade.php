<x-app-layout>
    @php
        $showFormMobile = isset($editing) || $errors->any();
    @endphp
    <x-slot name="header">
        <div
            class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-5 lg:gap-8 mt-2 lg:mt-0 xl:pr-10 w-full mb-4"
        >
            <div class="flex flex-col">
                <h1
                    class="text-4xl sm:text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight"
                >
                    Portfolio Builder
                </h1>
                <p class="text-[13px] sm:text-[14px] font-medium text-[#6A7B8C] mt-2">Curate your professional online narrative.</p>
            </div>
            <div class="flex items-center gap-3 w-full sm:max-w-max">
                @if (Auth::user()->tenant)
                    <a
                        href="{{ route('tenant.show', Auth::user()->tenant) }}"
                        target="_blank"
                        class="flex items-center justify-center gap-2 bg-[#EAF2ED] hover:bg-[#d8e6de] text-[#2E5136] px-5 py-[11px] rounded-full text-[13px] font-bold transition-colors w-full sm:w-auto shadow-sm"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Preview Site
                    </a>
                @endif
            </div>
        </div>
    </x-slot>
    <div
        class="flex flex-col lg:flex-row h-[calc(100dvh-180px)] xl:h-[calc(100vh-140px)] gap-6 lg:gap-8 overflow-hidden lg:pr-10 pt-4"
    >
        <div
            id="list-pane"
            class="w-full lg:w-[360px] flex-col h-full flex-shrink-0 {{ $showFormMobile ? 'hidden lg:flex' : 'flex' }}"
        >
            <div class="flex justify-between items-center mb-4 px-1">
                <span
                    class="text-[10px] font-bold text-gray-400 uppercase tracking-widest"
                    >PORTOFOLIO ({{ $portofolios->count() }})</span
                >
                <button
                    type="button"
                    onclick="createNewPortfolio()"
                    class="lg:hidden flex items-center gap-1.5 bg-[#2E5136] hover:bg-[#1f3824] text-white px-4 py-2 rounded-full text-[12px] font-bold transition-colors"
                >
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Baru
                </button>
            </div>
            @if (session('success'))
                <div
                    class="bg-green-50 border border-green-200 text-green-700 text-xs font-medium px-4 py-2.5 rounded-xl mb-4 flex items-center gap-2"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif
            <div
                class="flex-1 overflow-y-auto space-y-3 pb-24 lg:pb-6 hide-scroll px-1"
            >
                @forelse ($portofolios as $item)
                    <div
                        class="flex items-center justify-between p-4 bg-white text-[#1A1C19] border border-[#E8EBED] rounded-2xl shadow-sm hover:border-gray-300 transition-colors"
                    >
                        <div class="flex items-center gap-3 min-w-0">
                            @if ($item->gambar)
                                <div
                                    class="w-12 h-12 rounded-xl overflow-hidden shrink-0 border border-[#E8EBED]"
                                >
                                    <img
                                        src="{{ asset('storage/' . $item->gambar) }}"
                                        alt="{{ $item->judul }}"
                                        class="w-full h-full object-cover"
                                    />
                                </div>
                            @else
                                <div
                                    class="w-12 h-12 rounded-xl shrink-0 bg-gray-100 flex items-center justify-center"
                                >
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div
                                    class="font-bold text-[14px] sm:text-[13px] leading-tight truncate"
                                >
                                    {{ $item->judul }}
                                </div>
                                <div
                                    class="text-[12px] sm:text-[11px] text-gray-400 font-medium truncate mt-0.5"
                                >
                                    {{ Str::limit($item->deskripsi, 30) }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-0.5 shrink-0 ml-2">
                            <button
                                type="button"
                                onclick="editPortfolio(this)"
                                data-id="{{ $item->id }}"
                                data-judul="{{ $item->judul }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-gambar="{{ $item->gambar ? asset('storage/' . $item->gambar) : '' }}"
                                data-update-url="{{ route('portfolio.update', $item) }}"
                                class="text-gray-400 hover:text-[#2E5136] hover:bg-green-50 rounded-full transition-colors p-2.5"
                                title="Edit"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form
                                action="{{ route('portfolio.destroy', $item) }}"
                                method="POST"
                                onsubmit="
                                    return confirm('Hapus portofolio ini?');
                                "
                            >
                                @csrf
                                @method ('DELETE')
                                <button
                                    type="submit"
                                    class="text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-full transition-colors p-2.5"
                                    title="Hapus"
                                >
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10">
                        <div class="text-3xl mb-3">🖼️</div>
                        <p class="text-sm text-gray-400 font-medium">Belum ada portofolio.</p>
                        <p class="text-xs text-gray-400 mt-1 hidden lg:block">Gunakan editor di sebelah kanan untuk menambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
        <div
            id="editor-pane"
            class="flex-1 bg-white rounded-t-[2rem] lg:rounded-[2rem] border border-[#E8EBED] shadow-[0_4px_20px_rgb(0,0,0,0.02)] flex-col h-full relative overflow-hidden {{ $showFormMobile ? 'flex' : 'hidden lg:flex' }}"
        >
            <div
                class="flex-1 overflow-y-auto w-full p-6 lg:p-10 hide-scroll pb-32"
            >
                <div class="lg:hidden mb-6 border-b border-[#E8EBED] pb-4">
                    <button
                        type="button"
                        onclick="showList()"
                        class="flex items-center gap-2 text-gray-500 hover:text-black font-bold text-[13px] uppercase tracking-widest transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar
                    </button>
                </div>
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <div
                            id="form-badge"
                            class="bg-[#EAF2ED] text-[#2E5136] text-[10px] font-bold uppercase tracking-widest px-3 py-1 rounded-full mb-3 w-fit"
                        >
                            {{ isset($editing) ? 'EDITING' : 'NEW ITEM' }}
                        </div>
                        <h2
                            id="form-title"
                            class="text-3xl lg:text-[2rem] font-serif text-[#1A1C19]"
                        >
                            {{ isset($editing) ? $editing->judul : 'Tambah Portofolio' }}
                        </h2>
                    </div>
                </div>
                @if ($errors->any())
                    <div
                        class="bg-red-50 border border-red-200 text-red-700 text-sm font-medium px-5 py-4 rounded-2xl mb-6"
                    >
                        <p class="font-bold mb-1">Terdapat kesalahan:</p>
                        <ul class="list-disc list-inside text-xs space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form
                    id="portfolio-form"
                    action="{{ isset($editing) ? route('portfolio.update', $editing) : route('portfolio.store') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    <div id="method-container">
                        @if (isset($editing))
                            <input type="hidden" name="_method" value="PUT" />
                        @endif
                    </div>
                    <div class="space-y-6 max-w-2xl">
                        <div>
                            <label
                                for="judul"
                                class="block text-[13px] font-bold text-gray-500 mb-2"
                                >Judul Portofolio</label
                            >
                            <input
                                type="text"
                                name="judul"
                                id="judul"
                                value="{{ old('judul', $editing->judul ?? '') }}"
                                placeholder="e.g. Koleksi Lebaran 2025"
                                class="w-full h-[48px] bg-white border border-[#E8EBED] rounded-full px-6 text-[16px] lg:text-[15px] text-[#1A1C19] font-serif shadow-sm focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none transition-colors placeholder:text-gray-300"
                                required
                            />
                        </div>
                        <div>
                            <label
                                for="deskripsi"
                                class="block text-[13px] font-bold text-gray-500 mb-2"
                                >Deskripsi</label
                            >
                            <div
                                class="border border-[#E8EBED] rounded-2xl bg-white overflow-hidden shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors"
                            >
                                <textarea
                                    name="deskripsi"
                                    id="deskripsi"
                                    class="w-full min-h-[120px] bg-white border-none px-5 py-4 text-[16px] lg:text-[14px] text-[#1A1C19] font-medium leading-relaxed resize-none focus:ring-0 outline-none placeholder:text-gray-300"
                                    placeholder="Ceritakan tentang proyek ini, proses pembuatan, dan hasilnya..."
                                    required
                                    >{{ old('deskripsi', $editing->deskripsi ?? '') }}</textarea
                                >
                            </div>
                        </div>
                        <div>
                            <label
                                class="block text-[13px] font-bold text-gray-500 mb-2"
                                >Cover Image</label
                            >
                            <input
                                type="file"
                                name="gambar"
                                id="gambar"
                                class="hidden"
                                accept="image/jpeg,image/png"
                            />
                            <div
                                onclick="
                                    document.getElementById('gambar').click()
                                "
                                class="w-full aspect-[21/9] rounded-[1.5rem] relative overflow-hidden group cursor-pointer border-[1.5px] border-dashed border-[#d1d5db] bg-[#f9fafb] hover:border-[#2E5136]/50 transition-colors"
                            >
                                <div
                                    class="absolute inset-0 {{ isset($editing) && $editing->gambar ? '' : 'hidden' }}"
                                    id="preview-cover"
                                >
                                    <img
                                        id="preview-cover-img"
                                        src="{{ isset($editing) && $editing->gambar ? asset('storage/' . $editing->gambar) : '' }}"
                                        class="w-full h-full object-cover"
                                        alt="Cover preview"
                                    />
                                </div>
                                <div
                                    class="absolute inset-0 flex items-center justify-center"
                                    id="upload-overlay"
                                >
                                    <div
                                        class="bg-white/95 backdrop-blur-md rounded-[1.5rem] p-6 shadow-sm border border-white flex flex-col items-center gap-2 transform group-hover:scale-105 transition-transform duration-300"
                                    >
                                        <div
                                            class="w-10 h-10 rounded-full bg-[#EAF2ED] flex items-center justify-center text-[#2E5136] mb-1"
                                        >
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        </div>
                                        <span
                                            id="upload-text"
                                            class="text-[14px] font-bold text-[#1A1C19] text-center"
                                        >
                                            {{ isset($editing) ? 'Ganti gambar' : 'Upload image' }}
                                        </span>
                                        <span
                                            class="text-[10px] text-gray-400 font-medium text-center hidden sm:block"
                                            >Max 5MB</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 mb-8 lg:mb-0">
                        <button
                            type="submit"
                            id="submit-btn"
                            class="w-full lg:w-auto justify-center bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-8 py-[14px] lg:py-[12px] font-bold text-[14px] lg:text-[13.5px] shadow-[0_8px_20px_rgb(46,81,54,0.3)] flex items-center gap-2 transition-all transform hover:-translate-y-0.5"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span
                                id="submit-btn-text"
                                >{{ isset($editing) ? 'Perbarui Portofolio' : 'Simpan Portofolio' }}</span
                            >
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showEditor() {
            document.getElementById("list-pane").classList.remove("flex");
            document.getElementById("list-pane").classList.add("hidden");
            document.getElementById("editor-pane").classList.remove("hidden");
            document.getElementById("editor-pane").classList.add("flex");
        }

        function showList() {
            document.getElementById("editor-pane").classList.remove("flex");
            document.getElementById("editor-pane").classList.add("hidden");
            document.getElementById("list-pane").classList.remove("hidden");
            document.getElementById("list-pane").classList.add("flex");
        }

        function editPortfolio(btn) {
            const judul = btn.getAttribute("data-judul");
            const deskripsi = btn.getAttribute("data-deskripsi");
            const gambar = btn.getAttribute("data-gambar");
            const updateUrl = btn.getAttribute("data-update-url");
            const form = document.getElementById("portfolio-form");
            form.action = updateUrl;
            document.getElementById("method-container").innerHTML =
                '<input type="hidden" name="_method" value="PUT">';

            document.getElementById("judul").value = judul;
            document.getElementById("deskripsi").value = deskripsi;
            document.getElementById("form-title").innerText = judul;
            document.getElementById("form-badge").innerText = "EDITING";
            document.getElementById("submit-btn-text").innerText =
                "Perbarui Portofolio";
            document.getElementById("upload-text").innerText = "Ganti gambar";

            const previewCover = document.getElementById("preview-cover");
            const previewImg = document.getElementById("preview-cover-img");

            if (gambar) {
                previewImg.src = gambar;
                previewCover.classList.remove("hidden");
            } else {
                previewImg.src = "";
                previewCover.classList.add("hidden");
            }

            showEditor();
        }

        // SPA-like Create Logic
        function createNewPortfolio() {
            const form = document.getElementById("portfolio-form");
            form.action = "{{ route('portfolio.store') }}";
            document.getElementById("method-container").innerHTML = "";

            form.reset();

            document.getElementById("deskripsi").value = "";
            document.getElementById("form-title").innerText = "Tambah Portofolio";
            document.getElementById("form-badge").innerText = "NEW ITEM";
            document.getElementById("submit-btn-text").innerText = "Simpan Portofolio";
            document.getElementById("upload-text").innerText = "Upload image";
            document.getElementById("preview-cover").classList.add("hidden");
            document.getElementById("preview-cover-img").src = "";

            showEditor();
        }

        document.getElementById("gambar").addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file) {
                const previewCover = document.getElementById("preview-cover");
                const previewImg = document.getElementById("preview-cover-img");
                previewImg.src = URL.createObjectURL(file);
                previewCover.classList.remove("hidden");
            }
        });
    </script>
</x-app-layout>
