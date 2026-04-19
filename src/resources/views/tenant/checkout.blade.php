<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $produk->nama_produk }}</title>
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
<body class="min-h-screen bg-gray-50 antialiased">

    <header class="bg-white shadow-sm">
        <div class="mx-auto max-w-3xl px-6 py-5">
            <div class="flex items-center gap-3">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" class="h-10 w-10 rounded-full object-cover">
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full btn-accent text-sm font-bold">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <a href="{{ route('tenant.show', $tenant) }}" class="font-semibold text-gray-900 hover:text-accent">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-10">

        <nav class="mb-8 flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('tenant.show', $tenant) }}" class="hover:text-accent">Toko</a>
            <span>/</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" class="hover:text-accent">{{ $produk->nama_produk }}</a>
            <span>/</span>
            <span class="text-gray-800">Checkout</span>
        </nav>

        <div class="grid gap-6 md:grid-cols-5">

            {{-- Checkout Form --}}
            <div class="md:col-span-3">
                <div class="rounded-2xl bg-white p-6 shadow-sm">
                    <h1 class="text-xl font-bold text-gray-900">Data Pemesanan</h1>
                    <p class="mt-1 text-sm text-gray-500">Pastikan data lengkap — penjual akan menghubungi kamu via WhatsApp.</p>

                    {{-- Flash Error --}}
                    @if(session('error'))
                        <div class="mt-4 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required
                                   placeholder="Masukkan nama lengkap"
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                            @error('nama_pembeli') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp_pembeli" value="{{ old('no_hp_pembeli') }}" required
                                   placeholder="08123456789 atau +62812..."
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                            <p class="mt-1 text-xs text-gray-400">Penjual akan kirim invoice &amp; resi via WA.</p>
                            @error('no_hp_pembeli') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email_pembeli" value="{{ old('email_pembeli') }}" required
                                   placeholder="nama@email.com"
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                            @error('email_pembeli') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Alamat Pengiriman <span class="text-red-500">*</span></label>
                            <textarea name="alamat_pengiriman" rows="3" required
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                      class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">{{ old('alamat_pengiriman') }}</textarea>
                            @error('alamat_pengiriman') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Variant (if applicable) --}}
                        @if($produk->hasVariants())
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    {{ $produk->varian_label ?? 'Varian' }} <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach($produk->varian_opsi_array as $opsi)
                                        <label class="inline-flex cursor-pointer items-center gap-2 rounded-full border px-4 py-2 text-sm transition has-[:checked]:border-accent has-[:checked]:bg-green-50 has-[:checked]:text-accent {{ old('varian') === $opsi ? 'border-accent bg-green-50 text-accent' : 'border-gray-200' }}">
                                            <input type="radio" name="varian" value="{{ $opsi }}" class="sr-only" {{ old('varian') === $opsi ? 'checked' : '' }}>
                                            {{ $opsi }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('varian') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        {{-- Jumlah --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required
                                   class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">
                            <p class="mt-1 text-xs text-gray-400">Maks. {{ $produk->stok }} unit tersedia.</p>
                            @error('jumlah') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        {{-- Catatan --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Catatan untuk Penjual <span class="text-gray-400 font-normal">(opsional)</span></label>
                            <textarea name="catatan_pembeli" rows="2" placeholder="Permintaan khusus, warna, dll."
                                      class="mt-1 block w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm placeholder-gray-400 focus:border-accent focus:outline-none focus:ring-1 focus:ring-accent">{{ old('catatan_pembeli') }}</textarea>
                            @error('catatan_pembeli') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-xs text-amber-800">
                            <strong>Perhatian:</strong> Ongkos kirim belum termasuk. Penjual akan menginformasikan total + ongkir via WhatsApp.
                        </div>

                        <button type="submit"
                                class="mt-2 w-full rounded-xl btn-accent px-6 py-3 text-base font-semibold transition">
                            Lanjut ke Pembayaran →
                        </button>
                    </form>
                </div>
            </div>

            {{-- Order Summary --}}
            <div class="md:col-span-2">
                <div class="rounded-2xl bg-white p-6 shadow-sm sticky top-6">
                    <h2 class="text-base font-semibold text-gray-900">Ringkasan Pesanan</h2>
                    <div class="mt-4">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="h-32 w-full rounded-lg object-cover">
                        @else
                            <div class="flex h-32 items-center justify-center rounded-lg bg-gray-100 text-4xl text-gray-300">📦</div>
                        @endif
                        <p class="mt-3 font-medium text-gray-900">{{ $produk->nama_produk }}</p>
                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($produk->deskripsi, 80) }}</p>

                        <div class="mt-4 border-t border-gray-100 pt-4 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Harga satuan</span>
                                <span>Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <p class="mt-3 text-xs text-gray-400">Total produk dihitung saat konfirmasi. Ongkir via WA.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400">
        Dibuat dengan <a href="{{ route('landing') }}" class="font-medium text-accent hover:underline">MyLinx</a>
    </footer>
</body>
</html>
