@php
    $bgHex = ltrim($custom['background_color'] ?? '#FBFBF9', '#');
    $r = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 0, 1), 2) : substr($bgHex, 0, 2));
    $g = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 1, 1), 2) : substr($bgHex, 2, 2));
    $b = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 2, 1), 2) : substr($bgHex, 4, 2));
    $isDark = (($r * 299) + ($g * 587) + ($b * 114)) / 1000 < 128;
    $maxJumlah = min($produk->stok, 9999);
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout - {{ $produk->nama_produk }}</title>
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --accent: {{ $custom['accent_color'] ?? '#2E5136' }};
            --accent-hover: color-mix(in srgb, var(--accent) 85%, black);
            --bg: {{ $custom['background_color'] ?? '#FBFBF9' }};
            --text-main: #1a1c19;
            --text-muted: #6a7b8c;
            --card-bg: #ffffff;
            --border-color: #e8ebed;
            --accent-soft: color-mix(in srgb, var(--accent) 8%, white);
            --input-bg: #f9fafb;
        }
        .is-dark {
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: color-mix(in srgb, var(--bg) 95%, white);
            --border-color: color-mix(in srgb, var(--bg) 85%, white);
            --accent-soft: color-mix(in srgb, var(--accent) 20%, transparent);
            --input-bg: color-mix(in srgb, var(--bg) 98%, white);
        }
        body {
            background-color: var(--bg);
            color: var(--text-main);
        }
        .btn-accent {
            background: var(--accent);
            color: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .btn-accent:hover {
            background: var(--accent-hover);
        }
        .text-accent {
            color: var(--accent);
        }
    </style>
</head>
<body
    class="min-h-screen antialiased flex flex-col {{ $isDark ? 'is-dark' : '' }}"
>
    <header
        class="bg-[var(--card-bg)] shadow-sm border-b border-[var(--border-color)]"
    >
        <div class="mx-auto max-w-3xl px-6 py-5">
            <div class="flex items-center gap-3">
                @if ($profil?->logo)
                    <img
                        src="{{ asset('storage/' . $profil->logo) }}"
                        class="h-10 w-10 rounded-full object-cover ring-2 ring-[var(--border-color)]"
                    />
                @else
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full btn-accent text-sm font-bold ring-2 ring-[var(--border-color)]"
                    >
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <a
                    href="{{ route('tenant.show', $tenant) }}"
                    class="font-bold text-[var(--text-main)] hover:text-[var(--accent)] transition-colors"
                    >{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</a
                >
            </div>
        </div>
    </header>
    <main class="mx-auto max-w-3xl px-6 py-10 flex-1 w-full">
        <nav
            class="mb-8 flex items-center gap-2 text-sm font-medium text-[var(--text-muted)]"
        >
            <a
                href="{{ route('tenant.show', $tenant) }}"
                class="hover:text-[var(--accent)] transition-colors"
                >Toko</a
            >
            <span class="opacity-50">/</span>
            <a
                href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                class="hover:text-[var(--accent)] transition-colors"
                >{{ $produk->nama_produk }}</a
            >
            <span class="opacity-50">/</span>
            <span class="text-[var(--text-main)]">Checkout</span>
        </nav>

        {{-- Guard against out-of-stock products --}}
        @if ($produk->stok < 1)
            <div
                class="rounded-2xl bg-[var(--card-bg)] p-8 border border-[var(--border-color)] shadow-sm text-center"
            >
                <div class="text-5xl mb-4">😔</div>
                <h1 class="text-xl font-bold text-[var(--text-main)] mb-2">
                    Produk Habis
                </h1>
                <p class="text-sm text-[var(--text-muted)] mb-6">Maaf, produk ini sedang tidak tersedia.<br />Silakan cek produk lain di toko kami.</p>
                <a
                    href="{{ route('tenant.show', $tenant) }}"
                    class="inline-block rounded-xl btn-accent px-6 py-3 text-sm font-bold shadow-md transition-all hover:-translate-y-0.5"
                    >← Kembali ke Toko</a
                >
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-5">
                <div class="md:col-span-3">
                    <div
                        class="rounded-2xl bg-[var(--card-bg)] p-6 border border-[var(--border-color)] shadow-sm"
                    >
                        <h1 class="text-xl font-bold text-[var(--text-main)]">
                            Data Pemesanan
                        </h1>
                        <p class="mt-1 text-sm text-[var(--text-muted)]">Pastikan data lengkap - penjual akan menghubungi kamu via WhatsApp.</p>

                        @if (session('error'))
                            <div
                                class="mt-4 rounded-lg bg-red-50 border border-red-100 px-4 py-3 text-sm font-bold text-red-700"
                            >
                                {{ session('error') }}
                            </div>
                        @endif

                        {{-- Summary error block for all validation errors --}}
                        @if ($errors->any())
                            <div
                                class="mt-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3"
                            >
                                <p class="text-sm font-bold text-red-800 mb-1.5">Terdapat kesalahan pada form:</p>
                                <ul
                                    class="list-disc list-inside text-xs text-red-700 space-y-0.5"
                                >
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}"
                            method="POST"
                            class="mt-6 space-y-5"
                            x-data="{ submitting: false }"
                            @submit="submitting = true"
                            novalidate
                        >
                            @csrf
                            <div>
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Nama Lengkap
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="nama_pembeli"
                                    value="{{ old('nama_pembeli') }}"
                                    required
                                    maxlength="100"
                                    autocomplete="name"
                                    placeholder="Masukkan nama lengkap"
                                    class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors"
                                />
                                @error ('nama_pembeli')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div
                                x-data="{
                                localNumber: '{{ old('no_hp_pembeli_local', preg_replace('/^(\+?62|0+)/', '', old('no_hp_pembeli', ''))) }}',
                                get fullNumber() {
                                    const cleaned = this.localNumber.replace(/\D/g, '').replace(/^(62|0)+/, '');
                                    return cleaned ? '+62' + cleaned : '';
                                }
                            }"
                            >
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Nomor WhatsApp
                                    <span class="text-red-500">*</span>
                                </label>
                                <div
                                    class="flex items-center rounded-xl border border-[var(--border-color)] bg-[var(--input-bg)] pl-3 overflow-hidden focus-within:border-[var(--accent)] focus-within:ring-1 focus-within:ring-[var(--accent)] transition-colors"
                                >
                                    <span
                                        class="shrink-0 px-2.5 py-1 rounded-full bg-[var(--accent-soft)] text-[var(--accent)] text-[13px] font-bold"
                                    >
                                        +62
                                    </span>
                                    <input
                                        type="tel"
                                        x-model="localNumber"
                                        @input="
                                            localNumber = localNumber
                                                .replace(/\D/g, '')
                                                .replace(/^(62|0)+/, '')
                                        "
                                        required
                                        maxlength="13"
                                        inputmode="numeric"
                                        autocomplete="tel-national"
                                        placeholder="8123456789"
                                        class="flex-1 bg-transparent border-none outline-none px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:ring-0"
                                    />
                                    <input
                                        type="hidden"
                                        name="no_hp_pembeli"
                                        :value="fullNumber"
                                    />
                                </div>
                                <p class="mt-1.5 text-[11px] font-medium text-[var(--text-muted)]">Tanpa angka 0 di depan. Contoh: 8123456789.
                                <br />
                                Penjual akan kirim invoice &amp; resi via WA.</p>
                                @error ('no_hp_pembeli')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Email
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email_pembeli"
                                    value="{{ old('email_pembeli') }}"
                                    required
                                    maxlength="150"
                                    autocomplete="email"
                                    inputmode="email"
                                    placeholder="nama@email.com"
                                    class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors"
                                />
                                @error ('email_pembeli')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Alamat Pengiriman
                                    <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    name="alamat_pengiriman"
                                    rows="3"
                                    required
                                    minlength="10"
                                    maxlength="500"
                                    autocomplete="street-address"
                                    placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos"
                                    class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors resize-none"
                                    >{{ old('alamat_pengiriman') }}</textarea
                                >
                                @error ('alamat_pengiriman')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($produk->hasVariants())
                                <div>
                                    <label
                                        class="block text-[13px] font-bold text-[var(--text-main)] mb-2"
                                    >
                                        {{ $produk->varian_label ?? 'Varian' }}
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($produk->varian_opsi_array as $opsi)
                                            <label
                                                class="inline-flex cursor-pointer items-center justify-center min-w-[3rem] px-4 py-2.5 rounded-xl border border-[var(--border-color)] bg-[var(--input-bg)] text-[13px] font-bold text-[var(--text-main)] transition-colors has-[:checked]:border-[var(--accent)] has-[:checked]:bg-[var(--accent)] has-[:checked]:text-white"
                                            >
                                                <input
                                                    type="radio"
                                                    name="varian"
                                                    value="{{ $opsi }}"
                                                    class="sr-only"
                                                    {{ old('varian') === $opsi ? 'checked' : '' }}
                                                />
                                                {{ $opsi }}
                                            </label>
                                        @endforeach
                                    </div>
                                    @error ('varian')
                                        <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            <div>
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Jumlah
                                    <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="number"
                                    name="jumlah"
                                    value="{{ old('jumlah', 1) }}"
                                    min="1"
                                    max="{{ $maxJumlah }}"
                                    required
                                    inputmode="numeric"
                                    class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors"
                                />
                                <p class="mt-1.5 text-[11px] font-medium text-[var(--text-muted)]">Maks. {{ $maxJumlah }} unit tersedia.</p>
                                @error ('jumlah')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label
                                    class="block text-[13px] font-bold text-[var(--text-main)] mb-1.5"
                                >
                                    Catatan untuk Penjual
                                    <span class="opacity-50 font-normal"
                                        >(opsional)</span
                                    >
                                </label>
                                <textarea
                                    name="catatan_pembeli"
                                    rows="2"
                                    maxlength="500"
                                    placeholder="Permintaan khusus, warna, dll."
                                    class="block w-full rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] px-4 py-3 text-[14px] text-[var(--text-main)] placeholder-[var(--text-muted)] focus:border-[var(--accent)] focus:outline-none focus:ring-1 focus:ring-[var(--accent)] transition-colors resize-none"
                                    >{{ old('catatan_pembeli') }}</textarea
                                >
                                @error ('catatan_pembeli')
                                    <p class="mt-1.5 text-xs font-bold text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div
                                class="rounded-xl border border-amber-200/50 bg-amber-50/50 px-4 py-3.5 text-[12px] text-amber-800 leading-relaxed font-medium"
                            >
                                <strong class="font-bold text-amber-900"
                                    >Perhatian:</strong
                                >
                                Ongkos kirim belum termasuk. Penjual akan
                                menginformasikan total akhir beserta ongkir via
                                WhatsApp.
                            </div>

                            <button
                                type="submit"
                                :disabled="submitting"
                                :class="submitting
                                    ? 'opacity-60 cursor-not-allowed'
                                    : 'hover:-translate-y-0.5'"
                                class="mt-4 w-full rounded-xl btn-accent px-6 py-4 text-base font-bold shadow-md transition-all flex items-center justify-center gap-2"
                            >
                                <span x-show="!submitting"
                                    >Lanjut ke Pembayaran →</span
                                >
                                <span
                                    x-show="submitting"
                                    x-cloak
                                    class="flex items-center gap-2"
                                >
                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Memproses pesanan...
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <div
                        class="rounded-2xl bg-[var(--card-bg)] p-6 border border-[var(--border-color)] shadow-sm sticky top-6"
                    >
                        <h2
                            class="text-[15px] font-bold text-[var(--text-main)]"
                        >
                            Ringkasan Pesanan
                        </h2>
                        <div class="mt-5">
                            @if ($produk->gambar)
                                <div
                                    class="rounded-xl overflow-hidden bg-[var(--input-bg)] border border-[var(--border-color)]"
                                >
                                    <img
                                        src="{{ asset('storage/' . $produk->gambar) }}"
                                        alt="{{ $produk->nama_produk }}"
                                        class="h-36 w-full object-cover"
                                    />
                                </div>
                            @else
                                <div
                                    class="flex h-36 items-center justify-center rounded-xl bg-[var(--input-bg)] border border-[var(--border-color)] text-4xl text-[var(--text-muted)] opacity-50"
                                >
                                    📦
                                </div>
                            @endif
                            <p class="mt-4 font-bold text-[14px] text-[var(--text-main)] leading-snug">{{ $produk->nama_produk }}</p>
                            <p class="mt-1.5 text-[12.5px] font-medium text-[var(--text-muted)] leading-relaxed">{{ Str::limit($produk->deskripsi, 80) }}</p>
                            <div
                                class="mt-5 border-t border-[var(--border-color)] pt-5 text-[13px] font-bold"
                            >
                                <div
                                    class="flex justify-between text-[var(--text-main)]"
                                >
                                    <span>Harga satuan</span>
                                    <span class="text-[var(--accent)]">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                            <p class="mt-4 text-[11px] font-medium text-[var(--text-muted)] text-center p-3 rounded-lg bg-[var(--input-bg)]">Total produk dihitung saat konfirmasi.<br />Ongkir via WA.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
    <footer
        class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-6 text-center text-sm font-medium text-[var(--text-muted)] mt-auto"
    >
        Dibuat dengan
        <a
            href="{{ route('landing') }}"
            class="font-bold text-[var(--accent)] hover:underline"
            >MyLinx</a
        >
    </footer>
</body>
</html>
