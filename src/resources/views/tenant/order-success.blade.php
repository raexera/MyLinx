@php
    use App\Support\WaHelper;

    $sellerWa = $profil?->no_hp ?? null;
    $items = $order->orderItems->map(function ($i) {
        $label = '• ' . $i->produk->nama_produk . ' (' . $i->jumlah . 'x)';
        if ($i->varian) {
            $label .= ' — ' . $i->varian;
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
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

        <div class="mb-8 flex flex-col items-center rounded-3xl px-6 py-8 text-center border" style="background: var(--accent-soft); border-color: color-mix(in srgb, var(--accent) 30%, transparent);">
            <div class="flex h-14 w-14 items-center justify-center rounded-full text-2xl mb-4 bg-[var(--card-bg)] shadow-sm">🎉</div>
            <h1 class="text-[22px] font-bold text-[var(--accent)] mb-1">Pesanan Dibuat!</h1>
            <p class="text-[13.5px] font-medium text-[var(--text-main)] opacity-80">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>. Pesananmu: <strong class="font-mono">{{ $order->kode_order }}</strong>
            </p>
        </div>

        @if($profil?->qris_image)
            <div class="mb-8 rounded-3xl bg-[var(--card-bg)] p-6 sm:p-8 border border-[var(--border-color)] shadow-sm">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-widest text-amber-700 bg-amber-50 border border-amber-100">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Pembayaran
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-[var(--text-main)]">Scan QRIS di Bawah untuk Bayar</h2>
                    <p class="mt-1.5 text-[13px] font-medium text-[var(--text-muted)]">Pakai e-wallet apapun (GoPay, DANA, OVO, ShopeePay, m-Banking)</p>
                </div>

                <div class="mt-8 flex justify-center">
                    <div class="rounded-3xl border-4 border-dashed border-[var(--border-color)] bg-white p-5 w-[260px] h-[260px] shadow-sm">
                        <img src="{{ asset('storage/' . $profil->qris_image) }}"
                             alt="QRIS {{ $profil->qris_merchant_name }}"
                             class="h-full w-full object-contain">
                    </div>
                </div>

                <div class="mt-8 rounded-2xl bg-[var(--input-bg)] p-5 text-center border border-[var(--border-color)]">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-[var(--text-muted)] mb-1.5">Bayar Sebesar</div>
                    <div class="text-3xl font-bold text-[var(--text-main)]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    <div class="mt-3 text-[11.5px] font-medium text-amber-600 bg-amber-50/50 inline-block px-3 py-1.5 rounded-lg border border-amber-100/50">
                        ⚠️ Belum termasuk ongkir. Penjual akan infokan ongkir di WA.
                    </div>
                </div>

                @if($profil->qris_merchant_name)
                    <p class="mt-5 text-center text-[12px] font-medium text-[var(--text-muted)]">
                        QRIS atas nama: <strong class="text-[var(--text-main)]">{{ $profil->qris_merchant_name }}</strong>
                    </p>
                @endif
            </div>
        @else
            <div class="mb-8 rounded-2xl border border-amber-200/50 bg-amber-50/50 p-6 text-center shadow-sm">
                <p class="text-[14px] font-bold text-amber-900 mb-1">Penjual belum mengatur QRIS.</p>
                <p class="text-[12.5px] font-medium text-amber-800">Silakan hubungi penjual via WhatsApp untuk instruksi transfer manual.</p>
            </div>
        @endif

        @if($waLink)
            <a href="{{ $waLink }}" target="_blank"
               class="flex w-full items-center justify-center gap-2.5 rounded-2xl btn-accent px-6 py-4 text-[15px] font-bold shadow-[0_8px_16px_rgba(0,0,0,0.1)] transition-all transform hover:-translate-y-0.5">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.066.376-.05c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824z"/>
                </svg>
                Selesai Bayar? Konfirmasi via WhatsApp
            </a>
            <p class="mt-3 text-center text-[12px] font-medium text-[var(--text-muted)]">Chat WA akan otomatis terbuka dengan detail pesanan.</p>
        @else
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-center text-sm font-bold text-red-700">
                Penjual belum mengisi nomor WhatsApp. Silakan hubungi via email: {{ $profil->no_hp ?? '-' }}
            </div>
        @endif

        <details class="mt-8 rounded-2xl bg-[var(--card-bg)] shadow-sm border border-[var(--border-color)]">
            <summary class="cursor-pointer list-none px-6 py-5 text-[14px] font-bold text-[var(--text-main)] hover:bg-[var(--input-bg)] transition-colors rounded-2xl">
                <span class="inline-flex items-center gap-2.5">
                    <svg class="h-4 w-4 text-[var(--text-muted)] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                    Lihat Detail Pesanan
                </span>
            </summary>
            <div class="border-t border-[var(--border-color)] px-6 py-6 space-y-3.5 text-[13px] font-medium">
                <div class="flex justify-between">
                    <span class="text-[var(--text-muted)]">Nomor Invoice</span>
                    <span class="font-mono font-bold text-[var(--text-main)]">{{ $order->invoice->nomor_invoice }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-[var(--text-muted)]">Tanggal</span>
                    <span class="font-bold text-[var(--text-main)]">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                </div>

                <div class="border-t border-[var(--border-color)] pt-4 mt-2">
                    <div class="text-[10px] font-bold uppercase tracking-widest text-[var(--text-muted)] mb-3">Item Dibeli</div>
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between py-1.5">
                            <span class="text-[var(--text-main)] font-bold">
                                {{ $item->produk->nama_produk }}
                                @if($item->varian)
                                    <span class="text-[var(--text-muted)] font-medium ml-1">— {{ $item->varian }}</span>
                                @endif
                                <span class="text-[var(--text-muted)] ml-2">× {{ $item->jumlah }}</span>
                            </span>
                            <span class="font-bold text-[var(--text-main)]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between border-t border-[var(--border-color)] pt-4 mt-2 font-bold text-[14px]">
                    <span class="text-[var(--text-main)]">Total Produk</span>
                    <span class="text-[var(--accent)]">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <div class="pt-3">
                    <a href="{{ route('public.invoice', $order->public_token) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-[12px] font-bold text-[var(--accent)] hover:underline border border-transparent hover:border-[var(--accent)]/30 bg-[var(--accent-soft)] px-3 py-1.5 rounded-lg">
                        Lihat Draft Invoice PDF →
                    </a>
                </div>
            </div>
        </details>

        <div class="mt-10 text-center">
            <a href="{{ route('tenant.show', $tenant) }}" class="text-[13px] font-bold text-[var(--text-muted)] hover:text-[var(--accent)] transition-colors">
                ← Kembali ke Halaman Utama
            </a>
        </div>
    </main>

    <footer class="border-t border-[var(--border-color)] bg-[var(--card-bg)] py-6 text-center text-sm font-medium text-[var(--text-muted)] mt-auto">
        Dibuat dengan <a href="{{ route('landing') }}" class="font-bold text-[var(--accent)] hover:underline">MyLinx</a>
    </footer>
</body>
</html>
