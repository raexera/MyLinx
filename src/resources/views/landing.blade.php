<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="scroll-smooth"
>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MyLinx - Platform Digitalisasi untuk UMKM Indonesia</title>
    <meta
        name="description"
        content="Solusi Low-Code gratis untuk UMKM Indonesia yang ingin go-digital. Bikin website katalog produk, terima pesanan via WhatsApp, QRIS, & Transfer Manual, tanpa biaya hosting & maintenance yang mahal."
    />
    <link
        rel="apple-touch-icon"
        sizes="180x180"
        href="{{ asset('apple-touch-icon.png') }}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="32x32"
        href="{{ asset('favicon-32x32.png') }}"
    />
    <link
        rel="icon"
        type="image/png"
        sizes="16x16"
        href="{{ asset('favicon-16x16.png') }}"
    />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=instrument-serif:400,400i|inter:400,500,600,700"
        rel="stylesheet"
    />
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-serif {
            font-family: "Instrument Serif", serif;
        }
        .font-sans {
            font-family: "Inter", sans-serif;
        }
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body
    class="font-sans antialiased text-[#1A1C19] bg-[#FBFBF9] selection:bg-[#2E5136] selection:text-white"
>
    <nav
        class="fixed top-0 left-0 right-0 z-50 bg-[#FBFBF9]/90 backdrop-blur-md border-b border-transparent transition-all duration-300"
        id="navbar"
    >
        <div class="max-w-[1240px] mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-[80px]">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a
                        href="{{ route('landing') }}"
                        class="flex items-center gap-2 group"
                    >
                        <span
                            class="font-bold text-2xl tracking-tighter text-[#2E5136]"
                            >MyLinx</span
                        >
                    </a>
                </div>
                <div class="hidden md:flex items-center space-x-10">
                    <a
                        href="#fitur"
                        class="text-[14px] font-medium text-gray-500 hover:text-[#1A1C19] transition-colors"
                        >Fitur</a
                    >
                    <a
                        href="#tentang"
                        class="text-[14px] font-medium text-gray-500 hover:text-[#1A1C19] transition-colors"
                        >Tentang Kami</a
                    >
                </div>
                <div class="flex items-center gap-6">
                    @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="text-[14px] font-medium text-[#1A1C19] hover:text-gray-500 transition-colors"
                            >Dashboard</a
                        >
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="hidden sm:block text-[14px] font-medium text-[#1A1C19] hover:text-gray-500 transition-colors uppercase tracking-widest"
                            >Login</a
                        >
                        <a
                            href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-sm text-[12px] font-bold text-white bg-[#1A1C19] hover:bg-black transition-all duration-200 uppercase tracking-widest"
                            >Mulai Gratis</a
                        >
                    @endauth
                </div>
            </div>
        </div>
    </nav>
    <section
        class="pt-[140px] pb-24 lg:pt-[180px] lg:pb-32 px-6 lg:px-8 relative overflow-hidden"
    >
        <div
            class="max-w-[1240px] mx-auto grid lg:grid-cols-2 gap-16 lg:gap-8 items-center relative z-10"
        >
            <div class="max-w-xl">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-[#DCE2D8] text-[#2E5136] text-xs font-semibold uppercase tracking-widest mb-6"
                >
                    <div class="w-2 h-2 rounded-full bg-[#2E5136]"></div>
                    Untuk UMKM Indonesia
                </div>
                <h1
                    class="text-6xl md:text-7xl lg:text-[5.5rem] font-serif leading-[1.05] text-[#1A1C19] tracking-tight mb-6"
                >
                    Go Digital<br />
                    <span class="italic text-[#6A7B8C]">Tanpa</span><br />
                    Biaya IT.
                </h1>
                <p class="text-[#6A7B8C] text-[15px] font-medium leading-relaxed mb-8 max-w-md">Bikin website katalog produk, terima pesanan lewat WhatsApp, QRIS, & Transfer Manual, semuanya dari nol rupiah. Tanpa coding, tanpa hosting mahal, tanpa ribet maintenance.</p>
                <ul
                    class="space-y-3 text-[#1A1C19] text-[15px] font-medium mb-10"
                >
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Bikin katalog produk dalam hitungan menit
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Pesanan masuk langsung ke WhatsApp kamu
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Terima pembayaran via QRIS & Transfer Manual
                    </li>
                </ul>
                <div class="relative max-w-md">
                    <form
                        action="{{ route('register') }}"
                        method="GET"
                        class="flex items-center bg-white border border-[#DCE2D8] rounded-full p-2 pl-6 shadow-sm focus-within:ring-2 focus-within:ring-[#2E5136] transition-all"
                    >
                        <span class="text-gray-400 text-lg">mylinx.tech/</span>
                        <input
                            type="text"
                            name="domain"
                            placeholder="namatokomu"
                            class="w-full bg-transparent border-none focus:ring-0 text-lg text-[#1A1C19] placeholder-gray-300 p-0 ml-1"
                        />
                        <button
                            type="submit"
                            class="bg-[#2E5136] hover:bg-[#1f3824] text-white p-3 rounded-full transition-colors flex-shrink-0"
                        >
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-3 ml-4">*Daftar gratis, langsung jadi.</p>
                </div>
            </div>

            <div
                class="relative w-full aspect-square md:aspect-auto md:h-[600px] flex items-center justify-center"
            >
                <div
                    class="absolute w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-[#EBE7DF] rounded-full -right-10 top-1/2 -translate-y-1/2"
                ></div>

                <div
                    class="relative w-[280px] h-[580px] bg-[#1A1C19] p-[10px] rounded-[3rem] shadow-2xl shadow-gray-900/10 transform-gpu rotate-2"
                >
                    <div
                        class="absolute top-[8px] inset-x-0 flex justify-center z-30 pointer-events-none"
                    >
                        <div
                            class="w-24 h-6 bg-[#1A1C19] rounded-b-[1rem]"
                        ></div>
                    </div>
                    <div
                        class="w-full h-full bg-[#FBFBF9] rounded-[2.4rem] overflow-hidden relative"
                        style="
                            --accent: #2e5136;
                            --bg: #fbfbf9;
                            --text-main: #0f172a;
                            --text-muted: #64748b;
                            --card-bg: #ffffff;
                            --border-color: rgba(15, 23, 42, 0.08);
                            --accent-soft: rgba(46, 81, 54, 0.08);
                            background-image: radial-gradient(
                                var(--border-color) 1px,
                                transparent 1px
                            );
                            background-size: 24px 24px;
                        "
                    >
                        <div
                            class="w-full h-full overflow-y-auto hide-scroll relative pb-10"
                        >
                            <div
                                class="relative w-full h-[120px] bg-[var(--accent)] overflow-hidden"
                            >
                                <div
                                    class="absolute inset-0 opacity-20 mix-blend-overlay"
                                    style="
                                        background-image: radial-gradient(
                                            var(--border-color) 1px,
                                            transparent 1px
                                        );
                                        background-size: 24px 24px;
                                    "
                                ></div>
                                <div
                                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black/30"
                                ></div>
                                <div
                                    class="absolute -bottom-16 -right-16 w-32 h-32 bg-white/10 blur-[40px] rounded-full"
                                ></div>
                                <div
                                    class="absolute -top-12 -left-12 w-24 h-24 bg-black/10 blur-lg rounded-full"
                                ></div>
                            </div>
                            <div class="relative px-5 z-10">
                                <div class="flex flex-col gap-4 -mt-10">
                                    <div class="shrink-0">
                                        <div
                                            class="h-[76px] w-[76px] rounded-[1.2rem] shadow-[0_4px_15px_rgba(0,0,0,0.12)] shadow-[var(--accent)]/20 ring-[4px] ring-[var(--bg)] bg-[var(--accent)] flex items-center justify-center text-3xl font-bold text-white"
                                        >
                                            T
                                        </div>
                                    </div>

                                    <div class="pb-1">
                                        <h1
                                            class="text-[22px] font-serif text-[var(--text-main)] mb-1.5 tracking-tight leading-tight"
                                        >
                                            Toko Kamu ✧
                                        </h1>
                                        <div
                                            class="flex items-center gap-1.5 text-[11px] font-medium text-[var(--text-muted)]"
                                        >
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            <span>Bandung, Indonesia</span>
                                        </div>
                                    </div>
                                    <div class="w-full">
                                        <div
                                            class="flex justify-center items-center gap-2 rounded-xl bg-[var(--accent)] text-white px-4 py-2.5 text-[11.5px] font-bold shadow-[0_4px_10px_color-mix(in_srgb,var(--accent)_30%,transparent)]"
                                        >
                                            <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                                            Tanya via WhatsApp
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="mt-6 p-4 rounded-xl bg-[var(--card-bg)] border border-[var(--border-color)] shadow-sm"
                                >
                                    <h3
                                        class="text-[9px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-2 flex items-center gap-1.5"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Tentang Toko
                                    </h3>
                                    <div
                                        class="text-[11.5px] text-[var(--text-main)] leading-relaxed font-medium"
                                    >
                                        Katalog produk dan cerita bisnismu dalam
                                        satu halaman yang rapi dan profesional.
                                    </div>
                                </div>
                            </div>
                            <div class="px-5 py-8">
                                <h2
                                    class="text-lg font-serif text-[var(--text-main)] mb-4"
                                >
                                    Produk Kami
                                </h2>
                                <div class="grid grid-cols-2 gap-3">
                                    <div
                                        class="bg-[var(--card-bg)] rounded-[1rem] overflow-hidden border border-[var(--border-color)] shadow-sm"
                                    >
                                        <div
                                            class="aspect-square bg-[var(--input-bg)] flex items-center justify-center text-2xl opacity-50"
                                        >
                                            📦
                                        </div>
                                        <div class="p-3">
                                            <h3
                                                class="font-medium text-[11px] text-[var(--text-main)] line-clamp-2"
                                            >
                                                Produk Unggulan
                                            </h3>
                                            <p class="mt-1 text-[var(--accent)] font-bold text-[12.5px]">Rp 45.000</p>
                                        </div>
                                    </div>
                                    <div
                                        class="bg-[var(--card-bg)] rounded-[1rem] overflow-hidden border border-[var(--border-color)] shadow-sm"
                                    >
                                        <div
                                            class="aspect-square bg-[var(--input-bg)] flex items-center justify-center text-2xl opacity-50"
                                        >
                                            📦
                                        </div>
                                        <div class="p-3">
                                            <h3
                                                class="font-medium text-[11px] text-[var(--text-main)] line-clamp-2"
                                            >
                                                Koleksi Terbaru
                                            </h3>
                                            <p class="mt-1 text-[var(--accent)] font-bold text-[12.5px]">Rp 85.000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 lg:py-32 px-6 bg-white border-y border-[#E8EBED]">
        <div class="max-w-[1240px] mx-auto">
            <div class="text-center mb-16">
                <div
                    class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4"
                >
                    Kenyataan di Lapangan
                </div>
                <h2
                    class="text-4xl md:text-[3.25rem] font-serif leading-[1.1] text-[#1A1C19] mb-4 max-w-3xl mx-auto"
                >
                    UMKM ingin <span class="italic">go-digital</span>,<br />tapi
                    pilihannya sama-sama sulit.
                </h2>
                <p class="text-gray-500 max-w-xl mx-auto leading-relaxed">Menurut penelitian 2025, <span class="font-bold text-[#1A1C19]">65% pelaku UMKM sadar butuh teknologi digital</span>, tapi hanya <span class="font-bold text-[#1A1C19]">23%</span> yang bisa benar-benar memanfaatkannya.</p>
            </div>
            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <div
                    class="bg-[#FBFBF9] rounded-3xl p-8 border border-[#E8EBED]"
                >
                    <div
                        class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 mb-5"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-serif text-[#1A1C19] mb-2">
                        Jualan di Marketplace
                    </h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">Mudah, tapi tiap transaksi dipotong komisi rata-rata <span class="font-bold text-[#1A1C19]">6,5%</span>. Data pelanggan juga bukan milikmu. Seperti "menumpang lapak".</p>
                </div>
                <div
                    class="bg-[#FBFBF9] rounded-3xl p-8 border border-[#E8EBED]"
                >
                    <div
                        class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 mb-5"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-serif text-[#1A1C19] mb-2">
                        Bikin Website Sendiri
                    </h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">Pakai WordPress harus urus hosting, plugin, keamanan, dan update rutin. Untuk yang gaptek, belajar kurvanya terlalu terjal.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-24 lg:py-32 px-6 bg-[#FBFBF9]">
        <div class="max-w-[1240px] mx-auto">
            <div class="text-center mb-16 lg:mb-20">
                <div
                    class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4"
                >
                    Solusi Jalan Tengah
                </div>
                <h2
                    class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-4"
                >
                    MyLinx: Website Pro,<br /><span
                        class="italic text-[#6A7B8C]"
                        >Tanpa Ribet</span
                    >
                </h2>
                <p class="text-gray-500 max-w-lg mx-auto">Antara Linktree yang terlalu sederhana dan WordPress yang terlalu rumit. MyLinx dirancang khusus untuk UMKM Indonesia.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Katalog Produk Visual
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Bukan cuma daftar tombol. Tampilkan foto produk, deskripsi, harga, dan stok dengan layout yang profesional.</p>
                </div>
                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Pesanan Langsung ke WhatsApp
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Pelanggan klik "Beli", kamu terima detail pesanan di WhatsApp. Sesuai kebiasaan belanja orang Indonesia.</p>
                </div>

                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Pembayaran QRIS & Transfer
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Upload QRIS atau cantumkan nomor rekening usahamu. Pelanggan bebas pilih cara bayar tanpa biaya potongan sedikitpun.</p>
                </div>

                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Kustomisasi Tema Fleksibel
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Atur warna, tata letak, dan urutan konten sesuka hati. Sistem cerdas kami memastikan desain otomatis menyesuaikan warna gelap maupun terang.</p>
                </div>
                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Dashboard Rekap Pesanan
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Semua pesanan, status pembayaran, dan invoice terkumpul rapi. Tidak perlu catat manual di buku.</p>
                </div>
                <div
                    class="bg-white rounded-3xl p-7 border border-[#E8EBED] shadow-sm"
                >
                    <div
                        class="w-11 h-11 rounded-xl bg-[#EAF2ED] text-[#2E5136] flex items-center justify-center mb-5"
                    >
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    </div>
                    <h4 class="text-lg font-serif text-[#1A1C19] mb-2">
                        Bebas Biaya Tersembunyi
                    </h4>
                    <p class="text-sm text-gray-500 leading-relaxed">Tidak ada komisi per transaksi, tidak ada biaya hosting bulanan. Kamu kontrol penuh data dan pelangganmu.</p>
                </div>
            </div>
        </div>
    </section>
    <section
        id="tentang"
        class="py-24 lg:py-32 px-6 bg-white border-y border-[#E8EBED]"
    >
        <div
            class="max-w-[1240px] mx-auto grid lg:grid-cols-5 gap-16 items-start"
        >
            <div class="lg:col-span-3">
                <div
                    class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4"
                >
                    Tentang MyLinx
                </div>
                <h2
                    class="text-4xl md:text-[3rem] font-serif leading-[1.15] text-[#1A1C19] mb-8"
                >
                    Kami percaya setiap UMKM berhak punya
                    <span class="italic text-[#6A7B8C]">rumah digital</span>
                    sendiri.
                </h2>
                <div
                    class="space-y-5 text-[15px] text-gray-600 leading-relaxed"
                >
                    <p>UMKM menyumbang <span class="font-bold text-[#1A1C19]">61% PDB Indonesia</span> dan menyerap <span class="font-bold text-[#1A1C19]">97% tenaga kerja nasional</span>. Mereka adalah tulang punggung ekonomi kita. Tapi di era ekonomi digital yang tumbuh pesat, justru pelaku UMKM yang paling kesulitan ikut merasakan manfaatnya.</p>
                    <p>Masalahnya bukan karena mereka tidak mau berubah. Masalahnya adalah pilihan yang tersedia hari ini tidak cocok untuk mereka - <span class="font-bold text-[#1A1C19]">marketplace memotong komisi yang besar</span>, sementara <span class="font-bold text-[#1A1C19]">CMS seperti WordPress terlalu rumit secara teknis</span>. Alat dari luar negeri pun jarang paham kebiasaan pasar lokal, seperti jualan via WhatsApp atau bayar pakai QRIS & transfer bank.</p>
                    <p>
                        <span class="font-bold text-[#1A1C19]"
                            >MyLinx hadir untuk mengisi celah itu.</span
                        >
                        Dirancang sebagai platform
                        <span class="italic">low-code</span> yang sangat
                        sederhana, tapi tetap profesional. Lebih dari sekadar
                        <em>link-in-bio</em>, tapi tidak serumit
                        <em>content management system</em>. Dibangun dengan
                        kebiasaan UMKM Indonesia sebagai pusat desainnya.
                    </p>
                    <p class="text-[#1A1C19] font-medium">Misi kami sederhana: memastikan biaya IT dan kerumitan teknologi tidak lagi jadi penghalang bagi pedagang kecil untuk bersaing di ekonomi digital.</p>
                </div>
            </div>
            <div class="lg:col-span-2 space-y-4">
                <div
                    class="bg-[#FBFBF9] rounded-3xl p-8 border border-[#E8EBED]"
                >
                    <div
                        class="text-[10px] font-bold text-[#2E5136] uppercase tracking-widest mb-3"
                    >
                        Prinsip Kami
                    </div>
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white border border-[#E8EBED] flex items-center justify-center text-[#2E5136] font-serif text-sm flex-shrink-0"
                            >
                                1
                            </div>
                            <div>
                                <h4
                                    class="font-bold text-[14px] text-[#1A1C19] mb-1"
                                >
                                    Sederhana Dulu
                                </h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed">Jika pedagang yang gaptek tidak bisa pakai, fitur apapun tidak ada gunanya.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white border border-[#E8EBED] flex items-center justify-center text-[#2E5136] font-serif text-sm flex-shrink-0"
                            >
                                2
                            </div>
                            <div>
                                <h4
                                    class="font-bold text-[14px] text-[#1A1C19] mb-1"
                                >
                                    Lokal, Bukan Impor
                                </h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed">QRIS, Transfer Bank, dan WhatsApp bukan add-on, tapi fitur inti sejak hari pertama.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div
                                class="w-8 h-8 rounded-full bg-white border border-[#E8EBED] flex items-center justify-center text-[#2E5136] font-serif text-sm flex-shrink-0"
                            >
                                3
                            </div>
                            <div>
                                <h4
                                    class="font-bold text-[14px] text-[#1A1C19] mb-1"
                                >
                                    Data Milik Kamu
                                </h4>
                                <p class="text-[13px] text-gray-500 leading-relaxed">Tidak ada komisi, tidak ada ketergantungan platform. Bisnis kamu, kendali kamu.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-[#1A1C19] text-white rounded-3xl p-8">
                    <div
                        class="text-[10px] font-bold text-[#DCE2D8] opacity-70 uppercase tracking-widest mb-3"
                    >
                        Riset Pendukung
                    </div>
                    <p class="text-[13px] text-gray-300 leading-relaxed italic">"Hanya 23% UMKM yang benar-benar bisa memanfaatkan teknologi digital, padahal 65% sadar mereka membutuhkannya."</p>
                    <p class="text-[11px] text-gray-500 mt-3">- Rajagukguk & Rusadi, 2025</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-24 lg:py-32 px-6 bg-[#FBFBF9] text-center">
        <div class="max-w-xl mx-auto">
            <h2
                class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-4"
            >
                Siap untuk <span class="italic text-[#2E5136]">Go Online?</span>
            </h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-10">Bangun identitas digital bisnismu dalam hitungan menit. Gratis, tanpa kartu kredit, tanpa jebakan biaya bulanan.</p>
            <div
                class="flex flex-col sm:flex-row items-center justify-center gap-4"
            >
                <a
                    href="{{ route('register') }}"
                    class="w-full sm:w-auto px-8 py-3.5 rounded-full text-white bg-[#1A1C19] hover:bg-black text-[12px] font-bold uppercase tracking-widest shadow-xl transition-transform hover:-translate-y-1 duration-200"
                >
                    Mulai Sekarang - Gratis
                </a>
                <a
                    href="#fitur"
                    class="text-[12px] font-bold uppercase tracking-widest text-gray-500 hover:text-[#1A1C19] transition-colors"
                >
                    Pelajari Fitur →
                </a>
            </div>
        </div>
    </section>
    <footer
        class="pt-20 pb-10 px-6 border-t border-[#DCE2D8] bg-[#1A1C19] text-[#FBFBF9]"
    >
        <div
            class="max-w-[1240px] mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 mb-16"
        >
            <div>
                <div
                    class="font-bold text-2xl tracking-tighter text-[#DCE2D8] mb-4"
                >
                    MyLinx
                </div>
                <p class="text-gray-400 text-xs leading-relaxed max-w-xs">Platform low-code untuk membantu UMKM Indonesia masuk ke ekonomi digital tanpa terhalang biaya IT dan kerumitan teknis.</p>
            </div>
            <div>
                <h4 class="font-serif text-lg mb-4">Navigasi</h4>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li>
                        <a
                            href="#fitur"
                            class="hover:text-white transition-colors"
                            >Fitur</a
                        >
                    </li>
                    <li>
                        <a
                            href="#tentang"
                            class="hover:text-white transition-colors"
                            >Tentang Kami</a
                        >
                    </li>
                    <li>
                        <a
                            href="{{ route('register') }}"
                            class="hover:text-white transition-colors"
                            >Daftar</a
                        >
                    </li>
                    <li>
                        <a
                            href="{{ route('login') }}"
                            class="hover:text-white transition-colors"
                            >Masuk</a
                        >
                    </li>
                </ul>
            </div>
            <div>
                <h4 class="font-serif text-lg mb-4">Akademik</h4>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li>Proyek riset digitalisasi UMKM</li>
                    <li>Universitas Bina Nusantara</li>
                    <li>School of Computer Science, 2026</li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-[1240px] mx-auto border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-500"
        >
            <p>&copy; {{ date('Y') }} MyLinx. Proyek akademik untuk penelitian digitalisasi UMKM Indonesia.</p>
            <p class="mt-2 md:mt-0">Dibuat dengan ❤️ dari Bandung.</p>
        </div>
    </footer>
</body>
</html>
