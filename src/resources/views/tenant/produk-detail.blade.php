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
    <title>{{ $produk->nama_produk }} — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
    :root {
        --accent: {{ $custom['accent_color'] ?? '#2E5136' }};
        --accent-hover: color-mix(in srgb, var(--accent) 85%, black);
        --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};
        --text-main: #1A1C19;
        --text-muted: #6A7B8C;
        --card-bg: #FFFFFF;
        --border-color: #E8EBED;
        --accent-soft: color-mix(in srgb, var(--accent) 8%, white);
        --input-bg: #F9FAFB;
    }
    .is-dark {
        --text-main: #F8FAFC;
        --text-muted: #94A3B8;
        --card-bg: color-mix(in srgb, var(--bg) 95%, white);
        --border-color: color-mix(in srgb, var(--bg) 85%, white);
        --accent-soft: color-mix(in srgb, var(--accent) 20%, transparent);
        --input-bg: color-mix(in srgb, var(--bg) 98%, white);
    }
    body { background-color: var(--bg); color: var(--text-main); }
    .btn-accent { background: var(--accent); color: white; border: 1px solid rgba(0,0,0,0.05); }
    .btn-accent:hover { background: var(--accent-hover); }
    .text-accent { color: var(--accent); }
    </style>
</head>
<body class="min-h-screen antialiased flex flex-col {{ $isDark ? 'is-dark' : '' }}">

    {{-- Header --}}
    <header class="bg-[var(--card-bg)] shadow-sm border-b border-[var(--border-color)]">
        <div class="mx-auto max-w-4xl px-6 py-6">
            <div class="flex items-center gap-4">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-14 w-14 rounded-full object-cover ring-2 ring-[var(--border-color)]">
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-full btn-accent text-xl font-bold ring-2 ring-[var(--border-color)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <a href="{{ route('tenant.show', $tenant) }}" class="text-2xl font-bold text-[var(--text-main)] hover:text-[var(--accent)] transition-colors">
                        {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                    </a>
                    @if($profil?->deskripsi)
                        <p class="mt-1 text-sm text-[var(--text-muted)]">{{ Str::limit($profil->deskripsi, 120) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10 flex-1 w-full">

        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-sm font-medium text-[var(--text-muted)]">
            <a href="{{ route('tenant.show', $tenant) }}" class="hover:text-[var(--accent)] transition-colors">Toko</a>
            <span class="opacity-50">/</span>
            <span class="text-[var(--text-main)]">{{ $produk->nama_produk }}</span>
        </nav>

        <div class="overflow-hidden rounded-2xl bg-[var(--card-bg)] border border-[var(--border-color)] shadow-sm">
            <div class="grid gap-0 md:grid-cols-2">

                {{-- Product Image --}}
                <div class="bg-[var(--input-bg)] border-b md:border-b-0 md:border-r border-[var(--border-color)]">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama_produk }}"
                             class="h-full w-full object-cover" style="min-height: 320px;">
                    @else
                        <div class="flex h-80 items-center justify-center text-6xl text-[var(--text-muted)] opacity-50">
                            📦
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="flex flex-col justify-between p-8">
                    <div>
                        <h1 class="text-2xl font-bold text-[var(--text-main)]">{{ $produk->nama_produk }}</h1>
                        <p class="mt-4 text-3xl font-bold text-[var(--accent)]">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        <div class="mt-4">
                            @if($produk->stok > 0)
                                <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-sm font-bold text-[var(--accent)]" style="background: var(--accent-soft)">
                                    ✓ Stok tersedia ({{ $produk->stok }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-1 text-sm font-bold text-red-600 border border-red-100">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                        <p class="mt-6 text-sm leading-relaxed text-[var(--text-muted)]">{{ $produk->deskripsi }}</p>
                    </div>

                    <div class="mt-8 flex flex-col gap-3">
                        @if($produk->stok > 0)
                            <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                               class="flex w-full items-center justify-center rounded-xl btn-accent px-6 py-3.5 text-base font-bold shadow-md transition-all hover:-translate-y-0.5">
                                Beli Sekarang
                            </a>
                        @else
                            <button disabled
                                    class="w-full cursor-not-allowed rounded-xl bg-[var(--border-color)] px-6 py-3.5 text-base font-bold text-[var(--text-muted)]">
                                Stok Habis
                            </button>
                        @endif
                        <a href="{{ route('tenant.show', $tenant) }}"
                           class="flex w-full items-center justify-center rounded-xl border border-[var(--border-color)] px-6 py-3 text-base font-bold text-[var(--text-main)] transition hover:bg-[var(--input-bg)]">
                            ← Kembali ke Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-6 text-center text-sm text-[var(--text-muted)] mt-auto">
        Dibuat dengan
        <a href="{{ route('landing') }}" class="font-bold text-[var(--accent)] hover:underline">MyLinx</a>
    </footer>

</body>
</html>
