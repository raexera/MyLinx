<x-app-layout>
    <x-slot name="whiteBg">
        true
    </x-slot>
    <x-slot name="header">
        <div class="flex flex-col pt-4 sm:pt-6 w-full lg:pr-4 xl:pr-8">
            <h1
                class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5"
            >
                Website Settings
            </h1>
            <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C]">Manage your store's identity and appearance</p>
            <div class="w-full h-px bg-[#E8EBED] mt-8"></div>
        </div>
    </x-slot>
    @php
        $c = $tenant->customization_with_defaults;
    @endphp
    @if (session('success'))
        <div
            class="mt-6 mb-2 rounded-2xl bg-[#ECFDF5] border border-[#A7F3D0] px-5 py-4 text-[13.5px] font-semibold text-[#065F46] flex items-center gap-3"
        >
            <svg class="w-5 h-5 text-[#059669] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    <form
        action="{{ route('settings.website.update') }}"
        method="POST"
        class="w-full pt-5 sm:pt-6 lg:pr-4 xl:pr-8"
    >
        @csrf
        @method ('PATCH')
        <div class="mb-14">
            <h2
                class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight"
            >
                Store Name
            </h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">The name that appears on your storefront header.</p>
            <div
                class="flex items-center border rounded-[1rem] bg-white h-[54px] px-5 shadow-sm focus-within:border-[#2E5136] focus-within:ring-1 focus-within:ring-[#2E5136] transition-colors max-w-xl
                        {{ $errors->has('nama_tenant') ? 'border-red-400' : 'border-[#E8EBED]' }}"
            >
                <svg class="w-[18px] h-[18px] text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                <input
                    type="text"
                    name="nama_tenant"
                    value="{{ old('nama_tenant', $tenant->nama_tenant) }}"
                    placeholder="e.g. Toko Baju Jaya"
                    required
                    class="flex-1 bg-transparent border-none outline-none text-[14.5px] font-medium text-[#1A1C19] p-0 focus:ring-0 placeholder:text-gray-300 w-full"
                />
            </div>
            @error ('nama_tenant')
                <p class="text-xs text-red-500 mt-2 px-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-14">
            <h2
                class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight"
            >
                Shop Subdomain
            </h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">Choose a unique address for your online store.</p>
            <div
                x-data="slugChecker('{{ $tenant->slug }}', '{{ route('settings.website.check-slug') }}')"
                class="flex flex-col sm:flex-row gap-4 sm:gap-3"
            >
                <div
                    class="flex items-center flex-1 border rounded-[1rem] bg-white h-[54px] px-5 shadow-sm transition-colors"
                    :class="{
                        'border-[#E8EBED]': status === 'idle',
                        'border-[#2E5136] ring-1 ring-[#2E5136]':
                            status === 'checking',
                        'border-green-500 ring-1 ring-green-500':
                            status === 'available',
                        'border-red-400 ring-1 ring-red-400':
                            status === 'taken' || status === 'invalid',
                    }"
                >
                    <svg class="w-[18px] h-[18px] text-gray-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $tenant->slug) }}"
                        x-model="slug"
                        @input.debounce.500ms="check()"
                        class="flex-1 bg-transparent border-none outline-none text-[14.5px] font-medium text-[#1A1C19] p-0 focus:ring-0 placeholder:text-gray-300 w-full"
                        placeholder="your-store-name"
                        required
                    />
                    <span
                        class="text-[14.5px] font-medium text-gray-400 pl-2 opacity-80"
                        >.mylinx.tech</span
                    >
                    <div class="pl-3" x-cloak>
                        <template x-if="status === 'checking'">
                            <svg class="w-4 h-4 text-gray-400 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" class="opacity-25" />
                                <path fill="currentColor" class="opacity-75" d="M4 12a8 8 0 018-8V0C5.4 0 0 5.4 0 12h4z" />
                            </svg>
                        </template>
                        <template x-if="status === 'available'">
                            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                        </template>
                        <template
                            x-if="status === 'taken' || status === 'invalid'"
                        >
                            <svg class="w-5 h-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                        </template>
                    </div>
                </div>
                <button
                    type="button"
                    @click="check()"
                    :disabled="status === 'checking'"
                    class="bg-[#F4F6F9] hover:bg-[#e6eaf0] text-[#1A1C19] text-[13.5px] font-bold px-7 h-[54px] rounded-full transition-colors whitespace-nowrap shadow-sm disabled:opacity-50"
                >
                    <span x-show="status !== 'checking'"
                        >Check Availability</span
                    >
                    <span x-show="status === 'checking'">Checking…</span>
                </button>
            </div>
            <div class="mt-3 px-2 min-h-[20px]" x-cloak>
                <p
                    x-show="status === 'available'"
                    class="text-[12.5px] font-semibold text-green-600 flex items-center gap-1.5"
                >
                    <span>✓</span> <span x-text="message"></span>
                </p>
                <p
                    x-show="status === 'taken' || status === 'invalid'"
                    class="text-[12.5px] font-semibold text-red-500 flex items-center gap-1.5"
                >
                    <span>✕</span> <span x-text="message"></span>
                </p>
            </div>
            @error ('slug')
                <p class="text-xs text-red-500 mt-2 px-2">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-14">
            <h2
                class="text-[1.75rem] font-serif text-[#1A1C19] mb-1.5 leading-tight"
            >
                Customization
            </h2>
            <p class="text-[13.5px] text-[#6A7B8C] font-medium mb-5">Personalize the look and feel of your storefront.</p>
            <div
                class="border border-[#E8EBED] rounded-3xl bg-white p-6 sm:p-7 shadow-sm space-y-8"
                x-data="{
                    accent: '{{ old('accent_color', $c['accent_color']) }}',
                    background: '{{ old('background_color', $c['background_color']) }}',
                    get isDark() {
                        let bg = this.background.replace('#', '');
                        if (bg.length === 3) bg = bg.split('').map(x => x+x).join('');
                        let r = parseInt(bg.substr(0,2), 16);
                        let g = parseInt(bg.substr(2,2), 16);
                        let b = parseInt(bg.substr(4,2), 16);
                        return ((r*299)+(g*587)+(b*114))/1000 < 128;
                    }
                }"
            >
                <div>
                    <label
                        class="block text-[13px] font-bold text-[#1A1C19] mb-2"
                        >Warna Tema Utama</label
                    >
                    <p class="text-[12px] text-[#6A7B8C] font-medium mb-4">Pilih warna untuk tombol, tautan, dan elemen penting.</p>
                    <div class="flex items-center gap-4 flex-wrap">
                        <div class="relative shrink-0">
                            <input
                                type="color"
                                name="accent_color"
                                x-model="accent"
                                class="w-12 h-12 rounded-xl border border-[#E8EBED] cursor-pointer shadow-sm p-0 m-0 overflow-hidden"
                            />
                            <div
                                class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-[9px] font-bold text-gray-400 uppercase tracking-wide"
                            >
                                Custom
                            </div>
                        </div>

                        <div class="w-px h-10 bg-[#E8EBED] mx-2"></div>

                        <div class="flex items-center gap-2.5 flex-wrap">
                            <template
                                x-for="
                                    preset in
                                    [
                                        '#2E5136',
                                        '#1E3A8A',
                                        '#2563EB',
                                        '#0284C7',
                                        '#0F766E',
                                        '#16A34A',
                                        '#65A30D',
                                        '#D97706',
                                        '#EA580C',
                                        '#DC2626',
                                        '#BE185D',
                                        '#9333EA',
                                        '#1F2937',
                                        '#000000',
                                    ]
                                "
                                :key="preset"
                            >
                                <button
                                    type="button"
                                    @click="accent = preset"
                                    :style="`background:${preset}`"
                                    class="w-9 h-9 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-transform"
                                    :class="accent === preset
                                        ? 'ring-2 ring-offset-2 ring-[#1A1C19]'
                                        : ''"
                                ></button>
                            </template>
                        </div>
                    </div>
                    @error ('accent_color')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4">
                    <label
                        class="block text-[13px] font-bold text-[#1A1C19] mb-2"
                        >Warna Latar Belakang (Background)</label
                    >
                    <p class="text-[12px] text-[#6A7B8C] font-medium mb-4">Warna dominan untuk halaman toko Anda.</p>
                    <div class="flex items-center gap-4 flex-wrap">
                        <div class="relative shrink-0">
                            <input
                                type="color"
                                name="background_color"
                                x-model="background"
                                class="w-12 h-12 rounded-xl border border-[#E8EBED] cursor-pointer shadow-sm p-0 m-0 overflow-hidden"
                            />
                            <div
                                class="absolute -bottom-4 left-1/2 -translate-x-1/2 text-[9px] font-bold text-gray-400 uppercase tracking-wide"
                            >
                                Custom
                            </div>
                        </div>

                        <div class="w-px h-10 bg-[#E8EBED] mx-2"></div>

                        <div class="flex items-center gap-2.5 flex-wrap">
                            <template
                                x-for="
                                    preset in
                                    [
                                        '#FFFFFF',
                                        '#FBFBF9',
                                        '#F3F4F6',
                                        '#FEF2F2',
                                        '#FFF7ED',
                                        '#FEFCE8',
                                        '#F0FDF4',
                                        '#F0F9FF',
                                        '#EEF2FF',
                                        '#FAF5FF',
                                        '#111827',
                                        '#0F172A',
                                        '#171717',
                                        '#000000',
                                    ]
                                "
                                :key="preset"
                            >
                                <button
                                    type="button"
                                    @click="background = preset"
                                    :style="`background:${preset}`"
                                    class="w-9 h-9 rounded-full border-2 border-gray-200 shadow-sm hover:scale-110 transition-transform"
                                    :class="background === preset
                                        ? 'ring-2 ring-offset-2 ring-[#1A1C19]'
                                        : ''"
                                ></button>
                            </template>
                        </div>
                    </div>
                    @error ('background_color')
                        <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div
                    class="rounded-2xl border border-[#E8EBED] p-6 shadow-inner transition-colors duration-300 mt-8"
                    :style="`background:${background}`"
                >
                    <p
                        class="text-[11px] font-bold uppercase tracking-widest mb-4 transition-colors"
                        :class="isDark ? 'text-slate-400' : 'text-gray-400'"
                    >Live Preview</p>
                    <h3
                        class="text-2xl font-serif mb-3 transition-colors"
                        :class="isDark ? 'text-white' : 'text-gray-900'"
                    >
                        Produk Kami
                    </h3>
                    <div class="flex items-center gap-3 flex-wrap">
                        <button
                            type="button"
                            :style="`background:${accent}`"
                            class="text-white text-[13px] font-bold px-5 py-2.5 rounded-full pointer-events-none border border-black/5"
                        >
                            Beli Sekarang
                        </button>
                        <span
                            :style="`background: color-mix(in srgb, ${accent} 20%, transparent); color:${accent}`"
                            class="text-[11px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest border"
                            :style="`border-color: color-mix(in srgb, ${accent} 30%, transparent)`"
                            >Featured</span
                        >
                        <a
                            href="#"
                            :style="`color:${accent}`"
                            class="text-[13px] font-bold underline pointer-events-none"
                            >Lihat Detail →</a
                        >
                    </div>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-3 gap-5 pt-8 mt-8 border-t border-[#F0F2F3]"
                >
                    <div>
                        <label
                            for="hero_style"
                            class="block text-[13px] font-bold text-[#1A1C19] mb-2"
                            >Hero Style</label
                        >
                        <p class="text-[12px] text-[#6A7B8C] font-medium mb-3">How the top of your page looks.</p>
                        <select
                            name="hero_style"
                            id="hero_style"
                            class="w-full h-[48px] border border-[#E8EBED] rounded-full px-5 text-[13.5px] font-medium text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none"
                        >
                            @php $curHero = old('hero_style', $c['hero_style']); @endphp
                            <option
                                value="banner"
                                @selected ($curHero === 'banner')
                                >Banner - large logo + tagline
                            </option>
                            <option
                                value="minimal"
                                @selected ($curHero === 'minimal')
                                >Minimal - compact header
                            </option>
                        </select>
                        @error ('hero_style')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            for="content_order"
                            class="block text-[13px] font-bold text-[#1A1C19] mb-2"
                            >Content Order</label
                        >
                        <p class="text-[12px] text-[#6A7B8C] font-medium mb-3">What shows first on your page.</p>
                        <select
                            name="content_order"
                            id="content_order"
                            class="w-full h-[48px] border border-[#E8EBED] rounded-full px-5 text-[13.5px] font-medium text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none"
                        >
                            @php $curOrder = old('content_order', $c['content_order']); @endphp
                            <option
                                value="products_first"
                                @selected ($curOrder === 'products_first')
                                >Products First - then portfolio
                            </option>
                            <option
                                value="portfolio_first"
                                @selected ($curOrder === 'portfolio_first')
                                >Portfolio First - then products
                            </option>
                            <option
                                value="products_only"
                                @selected ($curOrder === 'products_only')
                                >Products Only
                            </option>
                            <option
                                value="portfolio_only"
                                @selected ($curOrder === 'portfolio_only')
                                >Portfolio Only
                            </option>
                        </select>
                        @error ('content_order')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label
                            for="product_layout"
                            class="block text-[13px] font-bold text-[#1A1C19] mb-2"
                            >Product Layout</label
                        >
                        <p class="text-[12px] text-[#6A7B8C] font-medium mb-3">How products are displayed.</p>
                        <select
                            name="product_layout"
                            id="product_layout"
                            class="w-full h-[48px] border border-[#E8EBED] rounded-full px-5 text-[13.5px] font-medium text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none"
                        >
                            @php $curLayout = old('product_layout', $c['product_layout']); @endphp
                            <option
                                value="grid"
                                @selected ($curLayout === 'grid')
                                >Grid - card-based, visual
                            </option>
                            <option
                                value="list"
                                @selected ($curLayout === 'list')
                                >List - compact, text-forward
                            </option>
                        </select>
                        @error ('product_layout')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end pt-8 pb-14 mt-4 relative">
            <button
                type="submit"
                class="bg-[#2E5136] hover:bg-[#1f3824] text-white rounded-full px-7 py-[12px] font-bold text-[14px] shadow-[0_8px_16px_rgb(46,81,54,0.3)] flex items-center gap-2.5 transition-all transform hover:-translate-y-0.5 z-10"
            >
                Save Changes
                <svg class="w-[14px] h-[14px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </div>
    </form>
    <script>
        function slugChecker(initialSlug, checkUrl) {
            return {
                slug: initialSlug,
                originalSlug: initialSlug,
                status: "idle",
                message: "",
                async check() {
                    if (this.slug === this.originalSlug) {
                        this.status = "idle";
                        this.message = "";
                        return;
                    }
                    if (!this.slug || this.slug.length < 3) {
                        this.status = "invalid";
                        this.message = "Minimal 3 karakter.";
                        return;
                    }
                    this.status = "checking";
                    this.message = "";
                    try {
                        const res = await fetch(
                            `${checkUrl}?slug=${encodeURIComponent(this.slug)}`,
                            {
                                headers: {
                                    Accept: "application/json",
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            },
                        );
                        const data = await res.json();
                        if (data.available) {
                            this.status = "available";
                            this.message = `URL tersedia! "${data.slug}.mylinx.tech" siap dipakai.`;
                        } else {
                            this.status = "taken";
                            this.message = data.reason || "URL sudah dipakai.";
                        }
                    } catch (err) {
                        this.status = "invalid";
                        this.message = "Gagal mengecek. Coba lagi.";
                    }
                },
            };
        }
    </script>
</x-app-layout>
