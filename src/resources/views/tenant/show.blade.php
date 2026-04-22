@php
    $bgHex = ltrim($custom['background_color'] ?? '#FBFBF9', '#');
    $r = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 0, 1), 2) : substr($bgHex, 0, 2));
    $g = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 1, 1), 2) : substr($bgHex, 2, 2));
    $b = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 2, 1), 2) : substr($bgHex, 4, 2));
    $isDark = (($r * 299) + ($g * 587) + ($b * 114)) / 1000 < 128;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=instrument-serif:400,400i|inter:400,500,600,700"
        rel="stylesheet"
    />

    @vite (['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --accent: {{ $custom['accent_color'] ?? '#2E5136' }};
            --accent-hover: color-mix(in srgb, var(--accent) 85%, black);
            --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --border-color: color-mix(in srgb, var(--text-main) 8%, transparent);
            --accent-soft: color-mix(in srgb, var(--accent) 8%, transparent);
            --input-bg: color-mix(in srgb, var(--text-main) 3%, transparent);
            --ring-color: color-mix(in srgb, var(--text-main) 5%, transparent);
        }
        .is-dark {
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: color-mix(in srgb, var(--bg) 95%, white);
            --border-color: color-mix(in srgb, white 12%, transparent);
            --accent-soft: color-mix(in srgb, var(--accent) 20%, transparent);
            --input-bg: color-mix(in srgb, black 20%, transparent);
            --ring-color: color-mix(in srgb, white 10%, transparent);
        }
        body {
            background-color: var(--bg);
            color: var(--text-main);
            font-family: "Inter", sans-serif;
        }
        .font-serif {
            font-family: "Instrument Serif", serif;
        }

        .glass-header {
            background-color: color-mix(in srgb, var(--card-bg) 80%, transparent);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .bg-dot-pattern {
            background-image: radial-gradient(var(--border-color) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        @keyframes
        fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-up {
            opacity: 0;
            animation: fadeUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .delay-100 {
            animation-delay: 100ms;
        }
        .delay-200 {
            animation-delay: 200ms;
        }
        .delay-300 {
            animation-delay: 300ms;
        }
    </style>
</head>
<body
    class="min-h-screen antialiased flex flex-col {{ $isDark ? 'is-dark' : '' }} bg-dot-pattern"
>
    @if (($custom['hero_style'] ?? 'banner') === 'banner')
        <header
            class="relative border-b border-[var(--border-color)] bg-[var(--bg)] pb-6 md:pb-10"
        >
            <div
                class="relative w-full h-[200px] md:h-[280px] bg-[var(--accent)] overflow-hidden"
            >
                <div
                    class="absolute inset-0 opacity-20 bg-dot-pattern mix-blend-overlay"
                ></div>
                <div
                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-transparent to-black/30"
                ></div>
                <div
                    class="absolute -bottom-32 -right-32 w-[500px] h-[500px] bg-white/10 blur-[80px] rounded-full pointer-events-none"
                ></div>
                <div
                    class="absolute -top-24 -left-24 w-[300px] h-[300px] bg-black/10 blur-[60px] rounded-full pointer-events-none"
                ></div>
            </div>

            <div class="relative mx-auto max-w-4xl px-6 z-10">
                <div
                    class="flex flex-col md:flex-row md:items-end justify-between gap-6 -mt-16 md:-mt-20"
                >
                    <div
                        class="flex flex-col md:flex-row md:items-end gap-5 md:gap-6"
                    >
                        <div class="shrink-0 animate-fade-up">
                            @if ($profil?->logo)
                                <img
                                    src="{{ asset('storage/' . $profil->logo) }}"
                                    alt="{{ $profil->nama_usaha }}"
                                    class="h-32 w-32 md:h-40 md:w-40 rounded-[1.5rem] object-cover shadow-[0_8px_30px_rgb(0,0,0,0.12)] shadow-[var(--accent)]/20 ring-[6px] ring-[var(--bg)] bg-[var(--card-bg)]"
                                />
                            @else
                                <div
                                    class="flex h-32 w-32 md:h-40 md:w-40 items-center justify-center rounded-[1.5rem] text-5xl md:text-6xl font-bold text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] shadow-[var(--accent)]/20 ring-[6px] ring-[var(--bg)] bg-[var(--accent)]"
                                >
                                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <div class="pb-1 md:pb-3 animate-fade-up delay-100">
                            <h1
                                class="text-3xl md:text-4xl lg:text-[2.75rem] font-serif text-[var(--text-main)] mb-2 tracking-tight leading-tight"
                            >
                                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                            </h1>
                            @if ($profil?->alamat)
                                <div
                                    class="flex items-center gap-1.5 text-[13.5px] font-medium text-[var(--text-muted)]"
                                >
                                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $profil->alamat }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($profil?->no_hp)
                        @php
                            $waLink = \App\Support\WaHelper::link($profil->no_hp, "Halo, saya mau tanya produk di {$tenant->nama_tenant}.");
                        @endphp
                        @if ($waLink)
                            <div
                                class="animate-fade-up delay-200 shrink-0 md:pb-3"
                            >
                                <a
                                    href="{{ $waLink }}"
                                    target="_blank"
                                    class="inline-flex w-full md:w-auto justify-center items-center gap-2.5 rounded-xl bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white px-7 py-3.5 text-[14px] font-bold shadow-[0_8px_20px_color-mix(in_srgb,var(--accent)_30%,transparent)] transition-all duration-300 hover:-translate-y-0.5"
                                >
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                                    Hubungi Kami
                                </a>
                            </div>
                        @endif
                    @endif
                </div>

                @if ($profil?->deskripsi)
                    <div
                        class="animate-fade-up delay-300 mt-8 md:mt-10 p-6 rounded-[1.25rem] bg-[var(--card-bg)] border border-[var(--border-color)] shadow-sm"
                    >
                        <h3
                            class="text-[11px] font-bold text-[var(--text-muted)] uppercase tracking-widest mb-3 flex items-center gap-2"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tentang Toko
                        </h3>
                        <div
                            class="text-[14px] md:text-[14.5px] text-[var(--text-main)] leading-relaxed font-medium"
                        >
                            {!! nl2br(e($profil->deskripsi)) !!}
                        </div>
                    </div>
                @endif
            </div>
        </header>
    @else
        <header
            class="border-b border-[var(--border-color)] glass-header sticky top-0 z-50 transition-all shadow-sm"
        >
            <div
                class="mx-auto max-w-4xl px-6 py-4 flex items-center justify-between gap-4"
            >
                <div class="flex items-center gap-4 min-w-0">
                    @if ($profil?->logo)
                        <img
                            src="{{ asset('storage/' . $profil->logo) }}"
                            alt="{{ $profil->nama_usaha }}"
                            class="h-12 w-12 rounded-full object-cover ring-2 ring-[var(--border-color)] shrink-0 shadow-sm"
                        />
                    @else
                        <div
                            class="flex h-12 w-12 items-center justify-center rounded-full text-sm font-bold text-white bg-[var(--accent)] ring-2 ring-[var(--border-color)] shrink-0 shadow-sm"
                        >
                            {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex flex-col min-w-0">
                        <h1
                            class="font-bold text-[var(--text-main)] text-[16px] leading-tight truncate"
                        >
                            {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                        </h1>

                        @if ($profil?->deskripsi)
                            <p class="text-[12px] text-[var(--text-muted)] font-medium truncate max-w-[200px] sm:max-w-md mt-0.5">{{ Str::limit($profil->deskripsi, 60) }}</p>
                        @endif

                        @if ($profil?->alamat)
                            <div
                                class="flex items-center gap-1 mt-1 text-[11px] text-[var(--text-muted)] font-medium opacity-80"
                            >
                                <svg class="w-3 h-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span
                                    class="truncate max-w-[200px] sm:max-w-md"
                                    >{{ $profil->alamat }}</span
                                >
                            </div>
                        @endif
                    </div>
                </div>

                @if ($profil?->no_hp)
                    @php
                        $waLink = \App\Support\WaHelper::link($profil->no_hp, "Halo, saya mau tanya produk di {$tenant->nama_tenant}.");
                    @endphp
                    @if ($waLink)
                        <a
                            href="{{ $waLink }}"
                            target="_blank"
                            class="hidden sm:flex items-center gap-2 rounded-full bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white px-5 py-2.5 text-[13px] font-bold shadow-md transition-all hover:-translate-y-0.5 shrink-0"
                        >
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                            Hubungi
                        </a>
                        <a
                            href="{{ $waLink }}"
                            target="_blank"
                            class="sm:hidden flex items-center justify-center h-10 w-10 rounded-full bg-[var(--accent)] text-white shadow-md shrink-0"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                        </a>
                    @endif
                @endif
            </div>
        </header>
    @endif

    <main
        class="animate-fade-up delay-300 mx-auto max-w-4xl px-6 py-12 md:py-16 flex-1 w-full"
    >
        @php
            $orderRule = $custom['content_order'] ?? 'products_first';
            $showProducts = in_array($orderRule, ['products_first', 'portfolio_first', 'products_only'], true);
            $showPortfolio = in_array($orderRule, ['products_first', 'portfolio_first', 'portfolio_only'], true);
            $productsFirst = in_array($orderRule, ['products_first', 'products_only'], true);
        @endphp
        <div class="space-y-16 relative z-10">
            @if ($productsFirst)
                @if ($showProducts) @include ('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
                @if ($showPortfolio && $portofolios->isNotEmpty()) @include ('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
            @else
                @if ($showPortfolio && $portofolios->isNotEmpty()) @include ('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
                @if ($showProducts) @include ('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
            @endif
        </div>
    </main>

    <footer
        class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-8 text-center mt-auto relative z-10 shadow-[0_-4px_20px_rgb(0,0,0,0.02)]"
    >
        <p class="text-[13px] font-medium text-[var(--text-muted)]">
            Powered by
            <a
                href="{{ route('landing') }}"
                class="font-bold text-[var(--accent)] hover:text-[var(--accent-hover)] transition-colors"
                >MyLinx</a
            >
        </p>
    </footer>
</body>
</html>
