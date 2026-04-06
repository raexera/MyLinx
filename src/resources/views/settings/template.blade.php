<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col xl:flex-row xl:justify-between xl:items-end gap-5 lg:gap-8 mt-2 lg:mt-0 xl:pr-10 w-full mb-4">
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-1.5 pl-1">
                    <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">SETTINGS — WEBSITE</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] mb-0 tracking-tight">Pilih Template</h1>
                <p class="text-[13px] sm:text-[14.5px] font-medium text-[#6A7B8C] leading-relaxed max-w-lg mt-3">
                    Pilih tampilan storefront untuk bisnis kamu. Template yang aktif akan langsung diterapkan ke halaman publik.
                </p>
            </div>

            {{-- Active template badge --}}
            @if($tenant->template)
                <div class="flex items-center gap-3 px-5 py-3 bg-white border border-[#E8EBED] rounded-2xl shadow-sm flex-shrink-0">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2E5136] flex-shrink-0"></span>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Template Aktif</p>
                        <p class="text-[14px] font-bold text-[#1A1C19] leading-tight">{{ $tenant->template->nama_template }}</p>
                    </div>
                </div>
            @endif
        </div>
    </x-slot>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] px-5 py-4 text-[13.5px] font-semibold text-[#065F46] flex items-center gap-3">
            <svg class="w-5 h-5 text-[#059669] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Templates Grid --}}
    @if($templates->isEmpty())
        <div class="rounded-3xl border-2 border-dashed border-[#E8EBED] py-20 text-center">
            <p class="text-gray-400 text-[15px]">Tidak ada template yang tersedia saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7 mb-10 pb-6">
            @foreach($templates as $template)
                @php
                    $isActive = $tenant->template_id === $template->id;
                    $usedByCount = $template->tenants()->count();
                @endphp
                <div class="bg-white rounded-[2rem] p-5 shadow-[0_8px_30px_rgb(0,0,0,0.03)] border {{ $isActive ? 'border-[#2E5136]' : 'border-[#E8EBED]' }} flex flex-col group hover:shadow-lg transition-shadow relative">

                    {{-- Active Badge --}}
                    @if($isActive)
                        <div class="absolute top-4 right-4 z-20 flex items-center gap-1.5 bg-[#2E5136] text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#86efac]"></span>
                            Sedang Dipakai
                        </div>
                    @endif

                    {{-- Preview Image --}}
                    <div class="w-full aspect-[4/3] rounded-[1.5rem] bg-[#f8f6f4] overflow-hidden relative mb-5">
                        <div class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm text-[#1A1C19] text-[9.5px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-sm z-10 w-fit">
                            {{ strtoupper($template->kategori) }}
                        </div>
                        @if($template->preview_url)
                            <img src="{{ $template->preview_url }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                                 alt="{{ $template->nama_template }}"
                                 onerror="this.parentElement.style.background='#F0F0EC';this.remove();">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-4xl text-gray-300 bg-gray-100">🖼️</div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="px-2 flex-grow mb-5">
                        <h3 class="text-[1.25rem] font-serif font-bold text-[#1A1C19] mb-1.5">{{ $template->nama_template }}</h3>
                        <p class="text-[12.5px] font-medium text-gray-400 leading-relaxed">
                            {{ ucfirst($template->kategori) }} template · slug: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[11px] font-mono text-gray-500">{{ $template->slug_key }}</code>
                        </p>
                        {{-- Usage info --}}
                        <p class="text-[11px] font-medium text-gray-400 mt-2">
                            @if($usedByCount > 0)
                                <span class="text-[#2E5136] font-semibold">{{ $usedByCount }} tenant</span> menggunakan template ini
                            @else
                                <span class="text-gray-300">Belum ada yang memakai</span>
                            @endif
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-3 px-2">
                        @if($isActive)
                            <div class="flex-1 py-3 bg-[#F0F7F2] rounded-full text-[13px] font-bold text-[#2E5136] text-center border border-[#C6DEC9] cursor-default">
                                ✓ Aktif
                            </div>
                        @else
                            <form action="{{ route('settings.template.update') }}" method="POST" class="flex-[1.2]">
                                @csrf @method('PATCH')
                                <input type="hidden" name="template_id" value="{{ $template->id }}">
                                <button type="submit"
                                        class="w-full py-3 bg-[#2E5136] rounded-full text-[13.5px] font-bold text-white shadow-sm shadow-[#2E5136]/20 hover:bg-[#1f3824] transition-colors"
                                        onclick="return confirm('Ganti template ke {{ $template->nama_template }}? Storefront kamu akan langsung berubah tampilannya.')">
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
                <svg class="w-4.5 h-4.5 text-[#2E5136]" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:18px;height:18px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[13px] font-semibold text-[#1A1C19] mb-1">Cara kerja template</p>
                <p class="text-[12.5px] font-medium text-[#6A7B8C] leading-relaxed">
                    Setiap template memiliki desain unik untuk storefront publik kamu (<code class="bg-gray-100 px-1 rounded text-[11px]">{{ url('/' . $tenant->slug) }}</code>).
                    Perubahan template langsung aktif — tidak perlu reload atau rebuild. Data produk, profil, dan portofolio tidak berubah.
                </p>
            </div>
        </div>
    @endif
</x-app-layout>
