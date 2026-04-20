@php
    use App\Support\WaHelper;
    $sellerWa = $profil?->no_hp ?? null;
    $items = $order->orderItems->map(function ($i) {
        $label = '• ' . $i->produk->nama_produk . ' (' . $i->jumlah . 'x)';
        if ($i->varian) {
            $label .= ' - ' . $i->varian;
        }
        return $label;
    })->implode("\n");
    $waMessage = "Halo, saya baru checkout pesanan:\n\n"
        . "*{$order->kode_order}*\n"
        . "Invoice: {$order->invoice->nomor_invoice}\n\n"
        . "Items:\n{$items}\n\n"
        . "Total produk: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n"
        . "Nama: {$order->nama_pembeli}\n"
        . "Alamat: {$order->alamat_pengiriman}\n\n"
        . "Ini bukti transfer saya 👇";
    $waLink = WaHelper::link($sellerWa, $waMessage);
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
    <title>
        Pesanan Berhasil - {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
    </title>
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
                >
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </a>
            </div>
        </div>
    </header>
    <main class="mx-auto max-w-3xl px-6 py-10 flex-1 w-full">
        <div
            class="mb-8 flex flex-col items-center rounded-3xl px-6 py-8 text-center border"
            style="
                background: var(--accent-soft);
                border-color: color-mix(
                    in srgb,
                    var(--accent) 30%,
                    transparent
                );
            "
        >
            <div
                class="flex h-14 w-14 items-center justify-center rounded-full text-2xl mb-4 bg-[var(--card-bg)] shadow-sm"
            >
                🎉
            </div>
            <h1 class="text-[22px] font-bold text-[var(--accent)] mb-1">
                Pesanan Dibuat!
            </h1>
            <p class="text-[13.5px] font-medium text-[var(--text-main)] opacity-80">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>.
                Pesananmu:
                <strong class="font-mono">{{ $order->kode_order }}</strong>
            </p>
        </div>
        @if ($profil?->qris_image)
            <div
                class="mb-8 rounded-3xl bg-[var(--card-bg)] p-6 sm:p-8 border border-[var(--border-color)] shadow-sm"
            >
                <div class="text-center">
                    <div
                        class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-widest text-amber-700 bg-amber-50 border border-amber-100"
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"
                        ></span>
                        Menunggu Pembayaran
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[var(--text-main)]">
                        Scan QRIS di Bawah untuk Bayar
                    </h2>
                    <p class="mt-1.5 text-[13px] font-medium text-[var(--text-muted)]">Pakai e-wallet apapun (GoPay, DANA, OVO, ShopeePay, m-Banking)</p>
                </div>
                <div class="mt-8 flex justify-center">
                    <div
                        class="rounded-3xl border-4 border-dashed border-[var(--border-color)] bg-white p-5 w-[260px] h-[260px] shadow-sm"
                    >
                        <img
                            src="{{ asset('storage/' . $profil->qris_image) }}"
                            alt="QRIS {{ $profil->qris_merchant_name }}"
                            class="h-full w-full object-contain"
                        />
                    </div>
                </div>
                <div
                    class="mt-8 rounded-2xl bg-[var(--input-bg)] p-5 text-center border border-[var(--border-color)]"
                >
                    <div
                        class="text-[11px] font-bold uppercase tracking-widest text-[var(--text-muted)] mb-1.5"
                    >
                        Bayar Sebesar
                    </div>
                    <div class="text-3xl font-bold text-[var(--text-main)]">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                    <div
                        class="mt-3 text-[11.5px] font-medium text-amber-600 bg-amber-50/50 inline-block px-3 py-1.5 rounded-lg border border-amber-100/50"
                    >
                        ⚠️ Belum termasuk ongkir. Penjual akan infokan ongkir di
                        WA.
                    </div>
                </div>
                @if ($profil->qris_merchant_name)
                    <p class="mt-5 text-center text-[12px] font-medium text-[var(--text-muted)]">
                        QRIS atas nama:
                        <strong
                            class="text-[var(--text-main)]"
                            >{{ $profil->qris_merchant_name }}</strong
                        >
                    </p>
                @endif
            </div>
        @else
            <div
                class="mb-8 rounded-2xl border border-amber-200/50 bg-amber-50/50 p-6 text-center shadow-sm"
            >
                <p class="text-[14px] font-bold text-amber-900 mb-1">Penjual belum mengatur QRIS.</p>
                <p class="text-[12.5px] font-medium text-amber-800">Silakan hubungi penjual via WhatsApp untuk instruksi transfer manual.</p>
            </div>
        @endif
        @if ($waLink)
            <a
                href="{{ $waLink }}"
                target="_blank"
                class="flex w-full items-center justify-center gap-2.5 rounded-2xl btn-accent px-6 py-4 text-[15px] font-bold shadow-[0_8px_16px_rgba(0,0,0,0.1)] transition-all transform hover:-translate-y-0.5"
            >
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                </svg>
                Selesai Bayar? Konfirmasi via WhatsApp
            </a>
            <p class="mt-3 text-center text-[12px] font-medium text-[var(--text-muted)]">Chat WA akan otomatis terbuka dengan detail pesanan.</p>
        @else
            <div
                class="rounded-xl border border-red-200 bg-red-50 p-4 text-center text-sm font-bold text-red-700"
            >
                Penjual belum mengisi nomor WhatsApp. Silakan hubungi via email: {{ $profil->no_hp ?? '-' }}
            </div>
        @endif
        <details
            class="mt-8 rounded-2xl bg-[var(--card-bg)] shadow-sm border border-[var(--border-color)]"
        >
            <summary
                class="cursor-pointer list-none px-6 py-5 text-[14px] font-bold text-[var(--text-main)] hover:bg-[var(--input-bg)] transition-colors rounded-2xl"
            >
                <span class="inline-flex items-center gap-2.5">
                    <svg class="h-4 w-4 text-[var(--text-muted)] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    Lihat Detail Pesanan
                </span>
            </summary>
            <div
                class="border-t border-[var(--border-color)] px-6 py-6 space-y-3.5 text-[13px] font-medium"
            >
                <div class="flex justify-between">
                    <span class="text-[var(--text-muted)]">Nomor Invoice</span>
                    <span
                        class="font-mono font-bold text-[var(--text-main)]"
                        >{{ $order->invoice->nomor_invoice }}</span
                    >
                </div>
                <div class="flex justify-between">
                    <span class="text-[var(--text-muted)]">Tanggal</span>
                    <span class="font-bold text-[var(--text-main)]"
                        >{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</span
                    >
                </div>
                <div class="border-t border-[var(--border-color)] pt-4 mt-2">
                    <div
                        class="text-[10px] font-bold uppercase tracking-widest text-[var(--text-muted)] mb-3"
                    >
                        Item Dibeli
                    </div>
                    @foreach ($order->orderItems as $item)
                        <div class="flex justify-between py-1.5">
                            <span class="text-[var(--text-main)] font-bold">
                                {{ $item->produk->nama_produk }}
                                @if ($item->varian)
                                    <span
                                        class="text-[var(--text-muted)] font-medium ml-1"
                                        >- {{ $item->varian }}</span
                                    >
                                @endif
                                <span class="text-[var(--text-muted)] ml-2"
                                    >× {{ $item->jumlah }}</span
                                >
                            </span>
                            <span class="font-bold text-[var(--text-main)]"
                                >Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span
                            >
                        </div>
                    @endforeach
                </div>
                <div
                    class="flex justify-between border-t border-[var(--border-color)] pt-4 mt-2 font-bold text-[14px]"
                >
                    <span class="text-[var(--text-main)]">Total Produk</span>
                    <span class="text-[var(--accent)]"
                        >Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span
                    >
                </div>
                <div class="pt-3">
                    <a
                        href="{{ route('public.invoice', $order->public_token) }}"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 text-[12px] font-bold text-[var(--accent)] hover:underline border border-transparent hover:border-[var(--accent)]/30 bg-[var(--accent-soft)] px-3 py-1.5 rounded-lg"
                    >
                        Lihat Draft Invoice PDF →
                    </a>
                </div>
            </div>
        </details>
        <div class="mt-10 text-center">
            <a
                href="{{ route('tenant.show', $tenant) }}"
                class="text-[13px] font-bold text-[var(--text-muted)] hover:text-[var(--accent)] transition-colors"
            >
                ← Kembali ke Halaman Utama
            </a>
        </div>
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
