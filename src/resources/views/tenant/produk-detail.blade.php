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
        --accent-hover: color-mix(in srgb, {{ $custom['accent_color'] ?? '#2E5136' }} 85%, black);
        --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};
    }
    body { background: var(--bg); }
    .btn-accent { background: var(--accent); color: white; }
    .btn-accent:hover { background: var(--accent-hover); }
    .text-accent { color: var(--accent); }
    </style>
</head>
<body class="min-h-screen bg-gray-50 antialiased flex flex-col">

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-4xl px-6 py-6">
            <div class="flex items-center gap-4">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-14 w-14 rounded-full object-cover">
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-full btn-accent text-xl font-bold">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <a href="{{ route('tenant.show', $tenant) }}" class="text-2xl font-bold text-gray-900 hover:text-accent">
                        {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                    </a>
                    @if($profil?->deskripsi)
                        <p class="mt-1 text-sm text-gray-600">{{ Str::limit($profil->deskripsi, 120) }}</p>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10 flex-1 w-full">

        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('tenant.show', $tenant) }}" class="hover:text-accent">Toko</a>
            <span>/</span>
            <span class="text-gray-800">{{ $produk->nama_produk }}</span>
        </nav>

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
            <div class="grid gap-0 md:grid-cols-2">

                {{-- Product Image --}}
                <div class="bg-gray-100">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}"
                             alt="{{ $produk->nama_produk }}"
                             class="h-full w-full object-cover" style="min-height: 320px;">
                    @else
                        <div class="flex h-80 items-center justify-center bg-gray-100 text-6xl text-gray-300">
                            📦
                        </div>
                    @endif
                </div>

                {{-- Product Info --}}
                <div class="flex flex-col justify-between p-8">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $produk->nama_produk }}</h1>
                        <p class="mt-4 text-3xl font-bold text-accent">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        <div class="mt-3">
                            @if($produk->stok > 0)
                                <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-3 py-1 text-sm font-medium text-accent">
                                    ✓ Stok tersedia ({{ $produk->stok }})
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-600">
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                        <p class="mt-6 text-sm leading-relaxed text-gray-600">{{ $produk->deskripsi }}</p>
                    </div>

                    <div class="mt-8 flex flex-col gap-3">
                        @if($produk->stok > 0)
                            <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                               class="flex w-full items-center justify-center rounded-xl btn-accent px-6 py-3 text-base font-semibold transition">
                                Beli Sekarang
                            </a>
                        @else
                            <button disabled
                                    class="w-full cursor-not-allowed rounded-xl bg-gray-200 px-6 py-3 text-base font-semibold text-gray-400">
                                Stok Habis
                            </button>
                        @endif
                        <a href="{{ route('tenant.show', $tenant) }}"
                           class="flex w-full items-center justify-center rounded-xl border border-gray-200 px-6 py-3 text-base font-medium text-gray-600 transition hover:bg-gray-50">
                            ← Kembali ke Toko
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400 mt-auto">
        Dibuat dengan
        <a href="{{ route('landing') }}" class="font-medium text-accent hover:underline">MyLinx</a>
    </footer>

</body>
</html>
