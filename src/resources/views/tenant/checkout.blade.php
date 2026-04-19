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
    <title>Checkout — {{ $produk->nama_produk }}</title>
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

    <header class="bg-[var(--card-bg)] shadow-sm border-b border-[var(--border-color)]">
        <div class="mx-auto max-w-3xl px-6 py-5">
            <div class="flex items-center gap-3">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" class="h-10 w-10 rounded-full object-cover ring-2 ring-[var(--border-color)]">
                @else
                    <div class="flex h-10 w-10 items-center justify-center rounded-full btn-accent text-sm font-bold ring-2 ring-[var(--border-color)]">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <a href="{{ route('tenant.show', $tenant) }}" class="font-bold text-[var(--text-main)] hover:text-[var(--accent)] transition-colors">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-3xl px-6 py-10 flex-1 w-full">

        <nav class="mb-8 flex items-center gap-2 text-sm font-medium text-[var(--text-muted)]">
            <a href="{{ route('tenant.show', $tenant) }}" class="hover:text-[var(--accent)] transition-colors">Toko</a>
            <span class="opacity-50">/</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" class="hover:text-[var(--accent)] transition-colors">{{ $produk->nama_produk }}</a>
            <span class="opacity-50">/</span>
            <span class="text-[var(--text-main)]">Checkout</span>
        </nav>

        <div class="grid gap-6 md:grid-cols-5">

            <div class="md:col-span-3">
                <div class="rounded-2xl bg-[var(--card-bg)] p-6 border border-[var(--border-color)] shadow-sm">
                    <h1 class="text-xl font-bold text-[var(--text-main)]">Data Pemesanan</h1>
                    <p class="mt-1 text-sm text-[var(--text-muted)]">Pastikan data lengkap — penjual akan menghubungi kamu via WhatsApp.</p>

                    @if(session('error'))
                        <div class="mt-4 rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm font-bold text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" class="mt-6 space-y-5">
                        @csrf

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required
                                   placeholder="Masukkan nama lengkap"
                                   class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors">
                            @error('nama_pembeli') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="no_hp_pembeli" value="{{ old('no_hp_pembeli') }}" required
                                   placeholder="08123456789 atau +62812..."
                                   class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors">
                            <p class="mt-1.5 text-[11px] font-medium text-[var(--text-muted)]">Penjual akan kirim invoice &amp; resi via WA.</p>
                            @error('no_hp_pembeli') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email_pembeli" value="{{ old('email_pembeli') }}" required
                                   placeholder="nama@email.com"
                                   class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors">
                            @error('email_pembeli') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Alamat Pengiriman <span class="text-red-500">*</span></label>
                            <textarea name="alamat_pengiriman" rows="3" required
                                      placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                      class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors resize-none">{{ old('alamat_pengiriman') }}</textarea>
                            @error('alamat_pengiriman') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        @if($produk->hasVariants())
                            <div>
                                <label class="block text-[13px] font-bold text-[var(--text-main)] mb-2">
                                    {{ $produk->varian_label ?? 'Varian' }} <span class="text-red-500">*</span>
                                </label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($produk->varian_opsi_array as $opsi)
                                        <label class="inline-flex cursor-pointer items-center justify-center min-w-[3rem] px-4 py-2.5 rounded-xl border border-[var(--border-color)] bg-[var(--input-bg)] text-[13px] font-bold text-[var(--text-main)] transition-colors has-[:checked]:border-[var(--accent)] has-[:checked]:bg-[var(--accent)] has-[:checked]:text-white">
                                            <input type="radio" name="varian" value="{{ $opsi }}" class="sr-only" {{ old('varian') === $opsi ? 'checked' : '' }}>
                                            {{ $opsi }}
                                        </label>
                                    @endforeach
                                </div>
                                @error('varian') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required
                                   class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors">
                            <p class="mt-1.5 text-[11px] font-medium text-[var(--text-muted)]">Maks. {{ $produk->stok }} unit tersedia.</p>
                            @error('jumlah') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5">Catatan untuk Penjual <span class="opacity-50 font-normal">(opsional)</span></label>
                            <textarea name="catatan_pembeli" rows="2" placeholder="Permintaan khusus, warna, dll."
                                      class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors resize-none">{{ old('catatan_pembeli') }}</textarea>
                            @error('catatan_pembeli') <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="rounded-xl border border-amber-200/50 bg-amber-50/50 px-4 py-3.5 text-[12px] text-amber-800 leading-relaxed font-medium">
                            <strong class="font-bold text-amber-900">Perhatian:</strong> Ongkos kirim belum termasuk. Penjual akan menginformasikan total akhir beserta ongkir via WhatsApp.
                        </div>

                        <button type="submit"
                                class="mt-4 w-full rounded-xl btn-accent px-6 py-4 text-base font-bold shadow-md transition-all hover:-translate-y-0.5">
                            Lanjut ke Pembayaran →
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="rounded-2xl bg-[var(--card-bg)] p-6 border border-[var(--border-color)] shadow-sm sticky top-6">
                    <h2 class="text-[15px] font-bold text-[var(--text-main)]">Ringkasan Pesanan</h2>
                    <div class="mt-5">
                        @if($produk->gambar)
                            <div class="rounded-xl overflow-hidden bg-[var(--input-bg)] border border-[var(--border-color)]">
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="h-36 w-full object-cover">
                            </div>
                        @else
                            <div class="flex h-36 items-center justify-center rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] text-4xl text-[var(--text-muted)] opacity-50">📦</div>
                        @endif

                        <p class="mt-4 font-bold text-[14px] text-[var(--text-main)] leading-snug">{{ $produk->nama_produk }}</p>
                        <p class="mt-1.5 text-[12.5px] font-medium text-[var(--text-muted)] leading-relaxed">{{ Str::limit($produk->deskripsi, 80) }}</p>

                        <div class="mt-5 border-t border-[var(--border-color)] pt-5 text-[13px] font-bold">
                            <div class="flex justify-between text-[var(--text-main)]">
                                <span>Harga satuan</span>
                                <span class="text-[var(--accent)]">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <p class="mt-4 text-[11px] font-medium text-[var(--text-muted)] text-center p-3 rounded-lg bg-[var(--input-bg)]">
                            Total produk dihitung saat konfirmasi.<br>Ongkir via WA.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-6 text-center text-sm font-medium text-[var(--text-muted)] mt-auto">
        Dibuat dengan <a href="{{ route('landing') }}" class="font-bold text-[var(--accent)] hover:underline">MyLinx</a>
    </footer>
</body>
</html>
