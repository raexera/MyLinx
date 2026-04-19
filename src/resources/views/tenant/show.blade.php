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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --accent: {{ $custom['accent_color'] ?? '#2E5136' }};
            --accent-hover: color-mix(in srgb, var(--accent) 85%, black);
            --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};

            /* Light Mode Variables - Modernized */
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --border-color: color-mix(in srgb, var(--text-main) 8%, transparent);
            --accent-soft: color-mix(in srgb, var(--accent) 8%, transparent);
            --input-bg: color-mix(in srgb, var(--text-main) 3%, transparent);
            --ring-color: color-mix(in srgb, var(--text-main) 5%, transparent);
        }

        /* Dark Mode Variables - Modernized */
        .is-dark {
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: color-mix(in srgb, var(--bg) 95%, white);
            --border-color: color-mix(in srgb, white 12%, transparent);
            --accent-soft: color-mix(in srgb, var(--accent) 20%, transparent);
            --input-bg: color-mix(in srgb, black 20%, transparent);
            --ring-color: color-mix(in srgb, white 10%, transparent);
        }

        body { background-color: var(--bg); color: var(--text-main); }
        .glass-header { background-color: color-mix(in srgb, var(--card-bg) 80%, transparent); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    </style>
</head>
<body class="min-h-screen antialiased flex flex-col {{ $isDark ? 'is-dark' : '' }}">

    {{-- ═══════════════ HERO ═══════════════ --}}
    @if(($custom['hero_style'] ?? 'banner') === 'banner')
        <header class="relative bg-[var(--accent-soft)] border-b border-[var(--border-color)] overflow-hidden">
            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[var(--accent)]/10 blur-[80px] rounded-full pointer-events-none"></div>

            <div class="relative mx-auto max-w-4xl px-6 py-20 md:py-28 text-center z-10">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="mx-auto mb-6 h-28 w-28 rounded-full object-cover shadow-xl ring-4 ring-[var(--card-bg)]">
                @else
                    <div class="mx-auto mb-6 flex h-28 w-28 items-center justify-center rounded-full text-4xl font-bold text-white shadow-xl ring-4 ring-[var(--card-bg)] bg-[var(--accent)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-serif text-[var(--text-main)] mb-4 tracking-tight">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </h1>

                @if($profil?->deskripsi)
                    <p class="mx-auto max-w-xl text-[15px] text-[var(--text-muted)] leading-relaxed">
                        {{ Str::limit($profil->deskripsi, 200) }}
                    </p>
                @endif

                @if($profil?->no_hp)
                    @php
                        $waLink = \App\Support\WaHelper::link($profil->no_hp, "Halo, saya mau tanya produk di {$tenant->nama_tenant}.");
                    @endphp
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank"
                           class="mt-8 inline-flex items-center gap-2.5 rounded-full bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white px-7 py-3.5 text-[14px] font-bold shadow-lg shadow-[var(--accent)]/20 transition-all duration-300 hover:-translate-y-1">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                            Tanya via WhatsApp
                        </a>
                    @endif
                @endif
            </div>
        </header>
    @else
        <header class="border-b border-[var(--border-color)] glass-header sticky top-0 z-50 transition-all shadow-sm">
            <div class="mx-auto max-w-4xl px-6 py-4 flex items-center gap-4">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-11 w-11 rounded-full object-cover ring-2 ring-[var(--border-color)]">
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-full text-sm font-bold text-white bg-[var(--accent)] ring-2 ring-[var(--border-color)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div class="flex flex-col">
                    <h1 class="font-bold text-[var(--text-main)] text-[15px] leading-tight">{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</h1>
                    @if($profil?->alamat)
                        <p class="text-[12px] text-[var(--text-muted)] font-medium truncate max-w-[200px] sm:max-w-md">{{ $profil->alamat }}</p>
                    @endif
                </div>
            </div>
        </header>
    @endif

    <main class="mx-auto max-w-4xl px-6 py-12 md:py-16 flex-1 w-full">

        @php
            $orderRule = $custom['content_order'] ?? 'products_first';
            $showProducts = in_array($orderRule, ['products_first', 'portfolio_first', 'products_only'], true);
            $showPortfolio = in_array($orderRule, ['products_first', 'portfolio_first', 'portfolio_only'], true);
            $productsFirst = in_array($orderRule, ['products_first', 'products_only'], true);
        @endphp

        <div class="space-y-16">
            @if($productsFirst)
                @if($showProducts) @include('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
                @if($showPortfolio && $portofolios->isNotEmpty()) @include('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
            @else
                @if($showPortfolio && $portofolios->isNotEmpty()) @include('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
                @if($showProducts) @include('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
            @endif
        </div>
    </main>

    <footer class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-8 text-center mt-auto">
        <p class="text-[13px] font-medium text-[var(--text-muted)]">
            Powered by <a href="{{ route('landing') }}" class="font-bold text-[var(--accent)] hover:underline">MyLinx</a>
        </p>
    </footer>
</body>
</html>
