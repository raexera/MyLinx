<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 antialiased">

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-3xl px-6 py-5">
            <div class="flex items-center gap-3">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         class="h-10 w-10 rounded-full object-cover">
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-800 text-sm font-bold text-white">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <a href="{{ route('tenant.show', $tenant) }}" class="font-semibold text-gray-900 hover:text-green-800">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-10">

        {{-- Breadcrumb --}}
        <nav class="mb-8 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('tenant.show', $tenant) }}" class="hover:text-green-700">Toko</a>
            <span>/</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" class="hover:text-green-700">{{ $produk->nama_produk }}</a>
            <span>/</span>
            <span class="text-gray-800">Checkout</span>
        </nav>

        <div class="grid gap-6 md:grid-cols-5">

            {{-- Checkout Form --}}
            <div class="md:col-span-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h1 class="text-xl font-bold text-gray-900">Data Pemesanan</h1>

                    {{-- Flash Error --}}
                    @if(session('error'))
                        <div class="mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        {{-- Nama Pembeli --}}
                        <div>
                            <label for="nama_pembeli" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <input type="text"
                                   id="nama_pembeli"
                                   name="nama_pembeli"
                                   value="{{ old('nama_pembeli') }}"
                                   placeholder="Masukkan nama lengkap"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                            @error('nama_pembeli')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email Pembeli --}}
                        <div>
                            <label for="email_pembeli" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email"
                                   id="email_pembeli"
                                   name="email_pembeli"
                                   value="{{ old('email_pembeli') }}"
                                   placeholder="nama@email.com"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                            @error('email_pembeli')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jumlah --}}
                        <div>
                            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                            <input type="number"
                                   id="jumlah"
                                   name="jumlah"
                                   value="{{ old('jumlah', 1) }}"
                                   min="1"
                                   max="{{ $produk->stok }}"
                                   required
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-900 focus:border-green-600 focus:outline-none focus:ring-1 focus:ring-green-600">
                            <p class="mt-1 text-xs text-gray-400">Maks. {{ $produk->stok }} unit</p>
                            @error('jumlah')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="mt-2 w-full rounded-xl bg-green-800 px-6 py-3 text-base font-semibold text-white transition hover:bg-green-700">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="md:col-span-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h2 class="text-base font-semibold text-gray-900">Ringkasan Pesanan</h2>
                    <div class="mt-4">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama_produk }}"
                                 class="h-32 w-full rounded-lg object-cover">
                        @else
                            <div class="flex h-32 items-center justify-center rounded-lg bg-gray-100 text-4xl text-gray-300">📦</div>
                        @endif
                        <p class="mt-3 font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($produk->deskripsi, 80) }}</p>
                        <div class="mt-4 border-t border-gray-100 pt-4">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Harga satuan</span>
                                <span>Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <p class="mt-2 text-xs text-gray-400">Total dihitung saat konfirmasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400">
        Dibuat dengan
        <a href="{{ route('landing') }}" class="font-medium text-green-700 hover:underline">MyLinx</a>
    </footer>

</body>
</html>
