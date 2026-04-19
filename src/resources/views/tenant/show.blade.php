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
            --accent-soft: color-mix(in srgb, var(--accent) 8%, white);
            --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};
        }
        body { background-color: var(--bg); }
    </style>
</head>
<body class="min-h-screen antialiased text-gray-900 flex flex-col">

    {{-- ═══════════════ HERO ═══════════════ --}}
    @if(($custom['hero_style'] ?? 'banner') === 'banner')
        <header class="bg-[var(--accent-soft)] border-b border-[var(--accent)]/10">
            <div class="mx-auto max-w-4xl px-6 py-16 text-center">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="mx-auto mb-5 h-24 w-24 rounded-full object-cover shadow-lg ring-4 ring-white">
                @else
                    <div class="mx-auto mb-5 flex h-24 w-24 items-center justify-center rounded-full text-3xl font-bold text-white shadow-lg ring-4 ring-white bg-[var(--accent)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif

                <h1 class="text-4xl md:text-5xl font-serif text-gray-900 mb-3">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </h1>

                @if($profil?->deskripsi)
                    <p class="mx-auto max-w-xl text-gray-600 leading-relaxed">
                        {{ Str::limit($profil->deskripsi, 180) }}
                    </p>
                @endif

                @if($profil?->no_hp)
                    @php
                        $waLink = \App\Support\WaHelper::link($profil->no_hp, "Halo, saya mau tanya produk di {$tenant->nama_tenant}.");
                    @endphp
                    @if($waLink)
                        <a href="{{ $waLink }}" target="_blank"
                           class="mt-6 inline-flex items-center gap-2 rounded-full bg-[var(--accent)] hover:bg-[var(--accent-hover)] text-white px-6 py-3 text-sm font-bold shadow-md transition-all hover:-translate-y-0.5 hover:shadow-lg">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                            Tanya via WhatsApp
                        </a>
                    @endif
                @endif
            </div>
        </header>
    @else
        <header class="border-b border-gray-200 bg-white/80 backdrop-blur-md sticky top-0 z-50">
            <div class="mx-auto max-w-4xl px-6 py-4 flex items-center gap-3">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-10 w-10 rounded-full object-cover ring-2 ring-[var(--accent-soft)]">
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white bg-[var(--accent)] ring-2 ring-[var(--accent-soft)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="font-bold text-gray-900">{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</h1>
                    @if($profil?->alamat)
                        <p class="text-xs text-gray-500">{{ Str::limit($profil->alamat, 60) }}</p>
                    @endif
                </div>
            </div>
        </header>
    @endif

    <main class="mx-auto max-w-4xl px-6 py-10 flex-1 w-full">

        @php
            $orderRule = $custom['content_order'] ?? 'products_first';
            $showProducts = in_array($orderRule, ['products_first', 'portfolio_first', 'products_only'], true);
            $showPortfolio = in_array($orderRule, ['products_first', 'portfolio_first', 'portfolio_only'], true);
            $productsFirst = in_array($orderRule, ['products_first', 'products_only'], true);
        @endphp

        <div class="space-y-12">
            @if($productsFirst)
                @if($showProducts) @include('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
                @if($showPortfolio && $portofolios->isNotEmpty()) @include('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
            @else
                @if($showPortfolio && $portofolios->isNotEmpty()) @include('tenant.partials.portfolio', ['portofolios' => $portofolios]) @endif
                @if($showProducts) @include('tenant.partials.products', ['produks' => $produks, 'tenant' => $tenant, 'custom' => $custom]) @endif
            @endif
        </div>
    </main>

    <footer class="border-t border-gray-200 bg-white py-6 text-center text-sm text-gray-400 mt-auto">
        Dibuat dengan <a href="{{ route('landing') }}" class="text-[var(--accent)] font-medium hover:underline">MyLinx</a>
    </footer>
</body>
</html>
