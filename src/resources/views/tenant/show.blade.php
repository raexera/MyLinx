<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }} — MyLinx</title>

    {{-- Vite assets (Tailwind + Alpine) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 antialiased">

    {{-- ================================================================
         Public Tenant Storefront — Placeholder Layout
         This will be replaced by the selected template engine later.
         For now it serves as a functional proof-of-concept for the
         manual multi-tenancy routing.
         ================================================================ --}}

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-4xl px-6 py-6">
            <div class="flex items-center gap-4">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-14 w-14 rounded-full object-cover">
                @else
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-800 text-xl font-bold text-white">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                    </h1>
                    @if($profil?->deskripsi)
                        <p class="mt-1 text-sm text-gray-600">
                            {{ Str::limit($profil->deskripsi, 120) }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Contact Info --}}
            @if($profil)
                <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500">
                    @if($profil->alamat)
                        <span>📍 {{ $profil->alamat }}</span>
                    @endif
                    @if($profil->no_hp)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}"
                           class="text-green-700 hover:underline">
                            📱 {{ $profil->no_hp }}
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </header>

    {{-- Product Catalog --}}
    <main class="mx-auto max-w-4xl px-6 py-10">

        @if($produks->isEmpty())
            <div class="rounded-lg border-2 border-dashed border-gray-200 py-16 text-center">
                <p class="text-gray-500">Belum ada produk yang ditampilkan.</p>
            </div>
        @else
            <h2 class="text-lg font-semibold text-gray-900">Produk Kami</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($produks as $produk)
                    <div class="overflow-hidden rounded-xl bg-white shadow-sm transition hover:shadow-md">
                        {{-- Product Image --}}
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama_produk }}"
                                 class="h-48 w-full object-cover">
                        @else
                            <div class="flex h-48 items-center justify-center bg-gray-100 text-4xl text-gray-300">
                                📦
                            </div>
                        @endif

                        {{-- Product Details --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                {{ Str::limit($produk->deskripsi, 80) }}
                            </p>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-lg font-bold text-green-800">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                                @if($produk->stok > 0)
                                    <span class="text-xs text-gray-400">Stok: {{ $produk->stok }}</span>
                                @else
                                    <span class="text-xs font-medium text-red-500">Habis</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Portfolio Section --}}
        @if($portofolios->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-lg font-semibold text-gray-900">Portofolio</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2">
                    @foreach($portofolios as $portofolio)
                        <div class="overflow-hidden rounded-xl bg-white shadow-sm">
                            @if($portofolio->gambar)
                                <img src="{{ asset('storage/' . $portofolio->gambar) }}"
                                     alt="{{ $portofolio->judul }}"
                                     class="h-48 w-full object-cover">
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900">{{ $portofolio->judul }}</h3>
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ Str::limit($portofolio->deskripsi, 100) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400">
        Dibuat dengan
        <a href="{{ route('landing') }}" class="font-medium text-green-700 hover:underline">MyLinx</a>
    </footer>

</body>
</html>
