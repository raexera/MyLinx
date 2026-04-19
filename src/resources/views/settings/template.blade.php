<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-5 lg:gap-8 mt-2 lg:mt-0 xl:pr-10 w-full mb-4">
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1.5 pl-1">
                    <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">SETTINGS — TEMPLATE</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Pilih Template</h1>
                <p class="text-[13px] sm:text-[14.5px] font-medium text-[#6A7B8C] leading-relaxed max-w-lg mt-3">
                    Ganti tampilan storefront kapan saja. Data produk, profil, dan portofolio tetap aman.
                </p>
            </div>

            @if($tenant->template)
                <div class="flex items-center gap-3 px-5 py-3 bg-white border border-[#E8EBED] rounded-2xl shadow-sm flex-shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2E5136] flex-shrink-0 animate-pulse"></span>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Template Aktif</p>
                        <p class="text-[14px] font-bold text-[#1A1C19] leading-tight">{{ $tenant->template->nama_template }}</p>
                    </div>
                    <a href="{{ route('tenant.show', $tenant) }}" target="_blank"
                       class="ml-4 px-4 py-2 bg-[#2E5136] hover:bg-[#1f3824] text-white text-[11px] font-bold rounded-full transition-colors whitespace-nowrap flex items-center gap-1.5">
                        Lihat Live
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            @endif
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] px-5 py-4 text-[13.5px] font-semibold text-[#065F46] flex items-center gap-3">
            <svg class="w-5 h-5 text-[#059669] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Templates Grid --}}
    @if($templates->isEmpty())
        <div class="rounded-3xl border-2 border-dashed border-[#E8EBED] py-20 text-center">
            <div class="text-4xl mb-3">🖼️</div>
            <p class="text-gray-400 text-[15px] font-medium">Tidak ada template yang tersedia saat ini.</p>
            <p class="text-gray-400 text-[12px] mt-2">Hubungi admin jika kamu melihat pesan ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7 mb-10 pb-6">
            @foreach($templates as $template)
                @php
                    $isActive    = $tenant->template_id === $template->id;
                    $usedByCount = $template->tenants()->count();
                @endphp
                <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border-2 {{ $isActive ? 'border-[#2E5136]' : 'border-[#E8EBED]' }} flex flex-col group hover:shadow-lg transition-all relative">

                    {{-- Preview Image --}}
                    <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#f8f6f4] overflow-hidden relative mb-5">
                        {{-- Category pill (top-left) --}}
                        <span class="absolute top-4 left-4 z-10 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                            {{ strtoupper($template->kategori) }}
                        </span>

                        {{-- Active badge (top-right, only if active) --}}
                        @if($isActive)
                            <span class="absolute top-4 right-4 z-10 flex items-center gap-1.5 bg-[#2E5136] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#86efac]"></span>
                                Aktif
                            </span>
                        @endif

                        @if($template->preview_url)
                            <img src="{{ $template->preview_url }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                 alt="Preview {{ $template->nama_template }}"
                                 onerror="this.onerror=null;this.src='data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 400 300%22><rect fill=%22%23F0F0EC%22 width=%22400%22 height=%22300%22/><text x=%22200%22 y=%22150%22 text-anchor=%22middle%22 fill=%22%23a0a0a0%22 font-size=%2214%22 font-family=%22sans-serif%22>Preview tidak tersedia</text></svg>';">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center gap-2 text-gray-300 bg-gray-100">
                                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-[11px] font-medium">Preview tidak tersedia</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="px-2 flex-grow mb-5">
                        <h3 class="text-[1.25rem] font-serif font-bold text-[#1A1C19] mb-1.5">{{ $template->nama_template }}</h3>
                        <p class="text-[12.5px] font-medium text-gray-400 leading-relaxed">
                            {{ ucfirst($template->kategori) }} · <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[11px] font-mono text-gray-500">{{ $template->slug_key }}</code>
                        </p>
                        <p class="text-[11px] font-medium text-gray-400 mt-2">
                            @if($usedByCount > 0)
                                <span class="text-[#2E5136] font-semibold">{{ $usedByCount }} {{ Str::plural('tenant', $usedByCount) }}</span> menggunakan ini
                            @else
                                <span class="text-gray-300">Belum ada yang pakai</span>
                            @endif
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 px-2">
                        @if($isActive)
                            <div class="flex-1 py-3 bg-[#F0F7F2] rounded-full text-[13px] font-bold text-[#2E5136] text-center border border-[#C6DEC9] cursor-default flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Sedang Dipakai
                            </div>
                        @else
                            <form action="{{ route('settings.template.update') }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <input type="hidden" name="template_id" value="{{ $template->id }}">
                                <button type="submit"
                                        class="w-full py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors"
                                        onclick="return confirm('Ganti template ke {{ $template->nama_template }}?\n\nStorefront kamu akan langsung berubah tampilannya. Data produk & pesanan tidak berubah.')">
                                    Gunakan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Info box --}}
        <div class="rounded-2xl bg-white border border-[#E8EBED] p-5 flex items-start gap-4 mb-8">
            <div class="w-9 h-9 rounded-full bg-[#EFF6F2] flex items-center justify-center flex-shrink-0">
                <svg class="w-[18px] h-[18px] text-[#2E5136]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="min-w-0">
                <p class="text-[13px] font-semibold text-[#1A1C19] mb-1">Cara kerja template</p>
                <p class="text-[12.5px] font-medium text-[#6A7B8C] leading-relaxed">
                    Template adalah tampilan storefront publik kamu di
                    <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[11px] font-mono break-all">{{ url('/' . $tenant->slug) }}</code>.
                    Perubahan langsung aktif tanpa reload — pengaturan warna & layout (dari menu Website) akan tetap diterapkan di template baru.
                </p>
            </div>
        </div>
    @endif
</x-app-layout>
