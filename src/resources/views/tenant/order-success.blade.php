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

    <main class="mx-auto max-w-3xl px-6 py-10 flex-1 w-full">

        {{-- Success banner --}}
        <div class="mb-8 flex flex-col items-center rounded-2xl bg-green-50 px-6 py-8 text-center">
            <div class="flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-2xl">✓</div>
            <h1 class="mt-3 text-xl font-bold text-accent">Pesanan Dibuat!</h1>
            <p class="mt-1 text-sm text-accent">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>. Pesananmu: <strong>{{ $order->kode_order }}</strong>
            </p>
        </div>

        {{-- QRIS + Payment CTA (the main action) --}}
        @if($profil?->qris_image)
            <div class="mb-6 rounded-2xl bg-white p-6 shadow-sm">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1 text-[10px] font-bold uppercase tracking-widest text-amber-700">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        Menunggu Pembayaran
                    </div>
                    <h2 class="mt-4 text-lg font-bold text-gray-900">Scan QRIS di Bawah untuk Bayar</h2>
                    <p class="mt-1 text-sm text-gray-500">Pakai e-wallet apapun (GoPay, DANA, OVO, ShopeePay, mobile banking)</p>
                </div>

                <div class="mt-6 flex justify-center">
                    <div class="rounded-2xl border-4 border-dashed border-accent bg-white p-4">
                        <img src="{{ asset('storage/' . $profil->qris_image) }}"
                             alt="QRIS {{ $profil->qris_merchant_name }}"
                             class="h-64 w-64 object-contain">
                    </div>
                </div>

                <div class="mt-5 rounded-xl bg-gray-50 p-4 text-center">
                    <div class="text-[11px] font-bold uppercase tracking-widest text-gray-500">Bayar Sebesar</div>
                    <div class="mt-1 text-3xl font-bold text-gray-900">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                    <div class="mt-2 text-xs text-amber-700">
                        ⚠️ Belum termasuk ongkos kirim. Ongkir akan diinformasikan penjual via WhatsApp.
                    </div>
                </div>

                @if($profil->qris_merchant_name)
                    <p class="mt-3 text-center text-xs text-gray-400">
                        QRIS atas nama: <strong>{{ $profil->qris_merchant_name }}</strong>
                    </p>
                @endif
            </div>
        @else
            {{-- No QRIS uploaded yet — fallback to WA-only flow --}}
            <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-6 text-center">
                <p class="text-sm font-medium text-amber-900">Penjual belum mengatur QRIS.</p>
                <p class="mt-1 text-xs text-amber-700">Silakan hubungi penjual via WhatsApp untuk informasi pembayaran.</p>
            </div>
        @endif

        {{-- WhatsApp CTA --}}
        @if($waLink)
            <a href="{{ $waLink }}" target="_blank"
               class="block w-full rounded-xl btn-accent px-6 py-4 text-center text-base font-bold shadow-lg transition">
                <span class="inline-flex items-center gap-2">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.066.376-.05c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824z"/>
                    </svg>
                    Selesai Bayar? Konfirmasi via WhatsApp
                </span>
            </a>
            <p class="mt-2 text-center text-xs text-gray-500">Chat akan terbuka dengan detail pesanan sudah di-format.</p>
        @else
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-center text-sm text-red-700">
                Penjual belum mengisi nomor WhatsApp. Silakan hubungi via email: {{ $profil->no_hp ?? '-' }}
            </div>
        @endif

        {{-- Order details (collapsed) --}}
        <details class="mt-6 rounded-2xl bg-white shadow-sm">
            <summary class="cursor-pointer list-none px-6 py-4 text-sm font-medium text-gray-700 hover:bg-gray-50">
                <span class="inline-flex items-center gap-2">
                    <svg class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    Detail Pesanan
                </span>
            </summary>
            <div class="border-t border-gray-100 px-6 py-5 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nomor Invoice</span>
                    <span class="font-mono font-medium text-gray-800">{{ $order->invoice->nomor_invoice }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal</span>
                    <span class="text-gray-800">{{ $order->created_at->translatedFormat('d M Y, H:i') }} WIB</span>
                </div>

                <div class="border-t border-gray-100 pt-3">
                    <div class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-2">Item</div>
                    @foreach($order->orderItems as $item)
                        <div class="flex justify-between py-1.5">
                            <span class="text-gray-700">
                                {{ $item->produk->nama_produk }}
                                @if($item->varian)
                                    <span class="text-gray-400">— {{ $item->varian }}</span>
                                @endif
                                <span class="text-gray-400">× {{ $item->jumlah }}</span>
                            </span>
                            <span class="font-medium text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-between border-t border-gray-100 pt-3 font-semibold">
                    <span class="text-gray-800">Total Produk</span>
                    <span class="text-accent">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>

                <div class="pt-2">
                    <a href="{{ route('public.invoice', $order->public_token) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 text-xs font-bold text-accent hover:underline">
                        Lihat Invoice PDF →
                    </a>
                </div>
            </div>
        </details>

        <div class="mt-8 text-center">
            <a href="{{ route('tenant.show', $tenant) }}" class="text-sm font-medium text-gray-500 hover:text-accent">
                ← Kembali ke toko
            </a>
        </div>
    </main>

    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400 mt-auto">
        Dibuat dengan <a href="{{ route('landing') }}" class="font-medium text-accent hover:underline">MyLinx</a>
    </footer>
</body>
</html>
