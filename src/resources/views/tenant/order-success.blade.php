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
    $isPaid = $order->invoice?->status_pembayaran === 'paid';
    $isShipped = !empty($order->nomor_resi);
    $waMessageUnpaid = "Halo, saya baru checkout pesanan:\n\n"
        . "*{$order->kode_order}*\n"
        . "Invoice: {$order->invoice?->nomor_invoice}\n\n"
        . "Items:\n{$items}\n\n"
        . "Total produk: Rp " . number_format($order->total_harga, 0, ',', '.') . "\n"
        . "Nama: {$order->nama_pembeli}\n"
        . "Alamat: {$order->alamat_pengiriman}\n\n"
        . "Ini bukti transfer saya 👇";
    $waMessagePaid = "Halo, saya mau nanya update pesanan saya:\n\n"
        . "*{$order->kode_order}*\n"
        . "Invoice: {$order->invoice?->nomor_invoice}\n"
        . "Nama: {$order->nama_pembeli}\n\n"
        . "Mohon infonya ya, terima kasih.";
    $waLink = WaHelper::link($sellerWa, $isPaid ? $waMessagePaid : $waMessageUnpaid);
    $bgHex = ltrim($custom['background_color'] ?? '#FBFBF9', '#');
    $r = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 0, 1), 2) : substr($bgHex, 0, 2));
    $g = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 1, 1), 2) : substr($bgHex, 2, 2));
    $b = hexdec(strlen($bgHex) === 3 ? str_repeat(substr($bgHex, 2, 1), 2) : substr($bgHex, 4, 2));
    $isDark = (($r * 299) + ($g * 587) + ($b * 114)) / 1000 < 128;
    $banks = $profil?->rekening_banks ?? [];
    $hasPayment = $profil?->qris_image || count($banks) > 0;
    $defaultTab = $profil?->qris_image ? 'qris' : (count($banks) > 0 ? 'bank-0' : '');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"
    />
    <title>
        Pesanan {{ $order->kode_order }} - {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
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
    </style>
</head>
<body
    class="min-h-screen antialiased flex flex-col {{ $isDark ? 'is-dark' : '' }}"
>
    <header
        class="bg-[var(--card-bg)] shadow-sm border-b border-[var(--border-color)] sticky top-0 z-50"
    >
        <div class="mx-auto max-w-3xl px-4 py-4 sm:px-6 sm:py-5">
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
                    class="font-bold text-[var(--text-main)] text-[15px] sm:text-[16px] hover:text-[var(--accent)] transition-colors truncate"
                >
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </a>
            </div>
        </div>
    </header>
    <main class="mx-auto max-w-3xl px-4 py-8 sm:px-6 sm:py-10 flex-1 w-full">
        <div
            class="mb-8 flex flex-col items-center rounded-3xl px-5 py-8 text-center border"
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
                class="flex h-14 w-14 items-center justify-center rounded-full mb-4 bg-[var(--card-bg)] shadow-sm border border-[var(--accent)]/20 text-2xl"
            >
                {!! $isShipped ? '📦' : ($isPaid ? '✅' : '<svg class="w-7 h-7 text-[var(--accent)]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>') !!}
            </div>
            <h1
                class="text-[20px] sm:text-[22px] font-bold text-[var(--accent)] mb-1"
            >
                {{ $isShipped ? 'Pesanan Dikirim!' : ($isPaid ? 'Pembayaran Berhasil!' : 'Pesanan Dibuat!') }}
            </h1>
            <p class="text-[13px] sm:text-[13.5px] font-medium text-[var(--text-main)] opacity-80 max-w-[280px]">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>.<br />
                No Pesanan:
                <strong
                    class="font-mono bg-[var(--card-bg)] px-1.5 py-0.5 rounded ml-1 border border-[var(--border-color)]"
                    >{{ $order->kode_order }}</strong
                >
            </p>
        </div>
        @if (!$isPaid)
            @if ($hasPayment)
                <div class="text-center mb-5">
                    <div
                        class="inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-[10px] font-bold uppercase tracking-widest text-amber-700 bg-amber-50 border border-amber-100"
                    >
                        <span
                            class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"
                        ></span>
                        Menunggu Pembayaran
                    </div>
                    <h2
                        class="mt-4 text-[18px] sm:text-xl font-bold text-[var(--text-main)]"
                    >
                        Pilih Cara Bayar
                    </h2>
                    <p class="mt-1 text-[13px] text-[var(--text-muted)]">Pilih salah satu metode di bawah ini</p>
                </div>
                <div
                    class="mb-8 space-y-4"
                    x-data="{ activeTab: '{{ $defaultTab }}' }"
                >
                    @if ($profil?->qris_image)
                        <div
                            class="rounded-[1.25rem] border border-[var(--border-color)] bg-[var(--card-bg)] shadow-sm overflow-hidden"
                        >
                            <button
                                @click="
                                    activeTab =
                                        activeTab === 'qris' ? '' : 'qris'
                                "
                                class="w-full flex items-center justify-between p-4 sm:p-5 bg-[var(--card-bg)] active:bg-[var(--input-bg)] transition-colors"
                            >
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 shrink-0"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[14px] font-bold text-[var(--text-main)] leading-tight">Bayar via QRIS</p>
                                        <p class="text-[11.5px] font-medium text-[var(--text-muted)] mt-0.5">OVO, GoPay, Dana, dll</p>
                                    </div>
                                </div>
                                <svg :class="activeTab === 'qris' ? 'rotate-180' : ''" class="w-5 h-5 text-[var(--text-muted)] transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div
                                x-show="activeTab === 'qris'"
                                x-collapse.duration.200ms
                                class="border-t border-[var(--border-color)] bg-[var(--input-bg)]"
                            >
                                <div class="p-4 sm:p-7">
                                    <div class="flex justify-center">
                                        <div
                                            class="bg-white p-2 sm:p-4 rounded-xl sm:rounded-2xl sm:border-[3px] sm:border-dashed border-[var(--border-color)] w-full max-w-[300px] aspect-square shadow-sm"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $profil->qris_image) }}"
                                                alt="QRIS"
                                                class="w-full h-full object-contain mix-blend-multiply"
                                            />
                                        </div>
                                    </div>
                                    @if ($profil->qris_merchant_name)
                                        <div class="mt-5 text-center">
                                            <p class="text-[10.5px] text-[var(--text-muted)] uppercase tracking-wider font-bold mb-1">A.N MERCHANT</p>
                                            <p class="text-[14px] font-bold text-[var(--text-main)] bg-white border border-[var(--border-color)] inline-block px-4 py-1.5 rounded-lg shadow-sm">{{ $profil->qris_merchant_name }}</p>
                                        </div>
                                    @endif
                                    <p class="text-center text-[12px] text-[var(--text-muted)] mt-4 max-w-[280px] mx-auto leading-relaxed">Simpan (<span class="font-semibold text-[var(--text-main)]">Screenshot</span>) gambar QRIS ini, lalu buka aplikasi e-Wallet / m-Banking Anda untuk membayar.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @foreach ($banks as $index => $bank)
                        <div
                            class="rounded-[1.25rem] border border-[var(--border-color)] bg-[var(--card-bg)] shadow-sm overflow-hidden"
                        >
                            <button
                                @click="activeTab = activeTab === 'bank-{{$index}}' ? '' : 'bank-{{$index}}'"
                                class="w-full flex items-center justify-between p-4 sm:p-5 bg-[var(--card-bg)] active:bg-[var(--input-bg)] transition-colors"
                            >
                                <div class="flex items-center gap-3.5">
                                    <div
                                        class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 shrink-0"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[14px] font-bold text-[var(--text-main)] leading-tight">Transfer {{ $bank['nama_bank'] }}</p>
                                        <p class="text-[11.5px] font-medium text-[var(--text-muted)] mt-0.5">Transfer Manual</p>
                                    </div>
                                </div>
                                <svg :class="activeTab === 'bank-{{$index}}' ? 'rotate-180' : ''" class="w-5 h-5 text-[var(--text-muted)] transition-transform shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                            </button>
                            <div
                                x-show="activeTab === 'bank-{{$index}}'"
                                x-collapse.duration.200ms
                                class="border-t border-[var(--border-color)] bg-[var(--input-bg)]"
                                x-data="{ copied: false }"
                            >
                                <div class="p-5 sm:p-6">
                                    <div class="mb-4 text-center sm:text-left">
                                        <p class="text-[14px] font-bold text-[var(--text-main)] uppercase tracking-wide">{{ $bank['nama_bank'] }}</p>
                                        <p class="text-[13px] text-[var(--text-muted)] mt-1">a.n. <strong class="text-[var(--text-main)]">{{ $bank['atas_nama'] }}</strong></p>
                                    </div>
                                    <div
                                        class="flex flex-col sm:flex-row items-center justify-between gap-3 bg-[var(--card-bg)] p-3 sm:pl-4 rounded-xl border border-[var(--border-color)] shadow-sm"
                                    >
                                        <p class="text-[24px] font-mono font-bold text-[var(--text-main)] tracking-widest break-all text-center sm:text-left">{{ $bank['nomor_rekening'] }}</p>
                                        <button
                                            @click="navigator.clipboard.writeText('{{ $bank['nomor_rekening'] }}'); copied = true; setTimeout(() => copied = false, 2000);"
                                            class="w-full sm:w-auto shrink-0 flex justify-center items-center gap-2 px-5 py-3 rounded-lg text-[13px] font-bold transition-all border"
                                            :class="copied
                                                ? 'bg-green-50 text-green-700 border-green-200'
                                                : 'bg-[var(--bg)] text-[var(--text-main)] border-[var(--border-color)] active:bg-gray-200'"
                                        >
                                            <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <svg x-show="copied" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span
                                                x-text="
                                                    copied
                                                        ? 'Tersalin!'
                                                        : 'Salin'
                                                "
                                            ></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div
                    class="mb-8 rounded-[1.25rem] bg-[var(--card-bg)] p-5 text-center border border-[var(--border-color)] shadow-sm"
                >
                    <div
                        class="text-[11px] font-bold uppercase tracking-widest text-[var(--text-muted)] mb-2"
                    >
                        Total Tagihan
                    </div>
                    <div
                        class="text-[28px] sm:text-3xl font-bold text-[var(--text-main)]"
                    >
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </div>
                    <div
                        class="mt-3 text-[11px] sm:text-[11.5px] font-medium text-amber-700 bg-amber-50 inline-block px-3 py-1.5 rounded-lg border border-amber-100"
                    >
                        ⚠️ Belum termasuk ongkir. Penjual akan infokan ongkir di
                        WA.
                    </div>
                </div>
            @else
                <div
                    class="mb-8 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-center shadow-sm"
                >
                    <p class="text-[14px] font-bold text-amber-900 mb-1">Metode Pembayaran Belum Diatur</p>
                    <p class="text-[12.5px] font-medium text-amber-800">Silakan hubungi penjual via WhatsApp untuk instruksi transfer selanjutnya.</p>
                </div>
            @endif
            @if ($waLink)
                <div
                    class="fixed bottom-0 left-0 right-0 p-4 bg-[var(--bg)] border-t border-[var(--border-color)] sm:relative sm:border-0 sm:bg-transparent sm:p-0 z-40"
                >
                    <a
                        href="{{ $waLink }}"
                        target="_blank"
                        class="flex w-full mx-auto max-w-3xl items-center justify-center gap-2.5 rounded-[1.25rem] btn-accent px-6 py-4 text-[14px] sm:text-[15px] font-bold shadow-[0_4px_12px_rgba(0,0,0,0.1)] active:scale-[0.98] transition-all"
                    >
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" />
                        </svg>
                        Selesai Bayar? Konfirmasi via WhatsApp
                    </a>
                </div>
                <p class="mt-4 text-center text-[12px] font-medium text-[var(--text-muted)] pb-20 sm:pb-0">Pesan otomatis berisi detail order akan dikirim ke penjual.</p>
            @else
                <div
                    class="rounded-xl border border-red-200 bg-red-50 p-4 text-center text-sm font-bold text-red-700 pb-20 sm:pb-0"
                >
                    Penjual belum mengisi nomor WhatsApp. Silakan hubungi via
                    email: {{ $profil->no_hp ?? '-' }}
                </div>
            @endif
        @else
            @if ($isShipped)
                <div
                    class="mb-8 rounded-[1.25rem] border border-blue-200 bg-blue-50 p-6 sm:p-8 text-center shadow-sm relative overflow-hidden"
                    x-data="{ copied: false }"
                >
                    <div
                        class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-500 opacity-5 rounded-full blur-xl pointer-events-none"
                    ></div>
                    <p class="text-[11px] font-bold text-blue-600 uppercase tracking-widest mb-4">Pesanan Dalam Perjalanan</p>
                    <div
                        class="bg-white rounded-xl border border-blue-100 p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 shadow-sm relative z-10"
                    >
                        <div class="text-center sm:text-left w-full sm:w-auto">
                            <p class="text-[12px] text-gray-500 font-medium mb-1">Kurir / Ekspedisi</p>
                            <p class="text-[16px] font-bold text-blue-900 uppercase">{{ $order->ekspedisi ?? 'Kurir Internal' }}</p>
                        </div>
                        <div
                            class="h-px w-full sm:w-px sm:h-10 bg-blue-100 hidden sm:block"
                        ></div>
                        <div
                            class="text-center sm:text-left w-full sm:w-auto flex-1"
                        >
                            <p class="text-[12px] text-gray-500 font-medium mb-1">Nomor Resi Pengiriman</p>
                            <div
                                class="flex items-center justify-center sm:justify-start gap-2"
                            >
                                <p class="text-[18px] sm:text-[20px] font-mono font-bold text-blue-900 tracking-widest break-all">{{ $order->nomor_resi }}</p>
                            </div>
                        </div>
                        <button
                            @click="navigator.clipboard.writeText('{{ $order->nomor_resi }}'); copied = true; setTimeout(() => copied = false, 2000);"
                            class="w-full sm:w-auto shrink-0 flex justify-center items-center gap-2 px-4 py-2.5 rounded-lg text-[12px] font-bold transition-all border"
                            :class="copied
                                ? 'bg-green-50 text-green-700 border-green-200'
                                : 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100'"
                        >
                            <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <svg x-show="copied" x-cloak class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span
                                x-text="copied ? 'Tersalin' : 'Salin Resi'"
                            ></span>
                        </button>
                    </div>
                </div>
            @else
                <div
                    class="mb-8 rounded-[1.25rem] border border-green-200 bg-green-50 p-6 sm:p-8 text-center shadow-sm"
                >
                    <div
                        class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3"
                    >
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-[15px] font-bold text-green-900 mb-1.5">Pembayaran Telah Dikonfirmasi</p>
                    <p class="text-[13px] font-medium text-green-800 max-w-sm mx-auto leading-relaxed">Pesananmu sedang disiapkan oleh penjual. Harap pantau halaman ini secara berkala untuk mengecek nomor resi pengiriman.</p>
                </div>
            @endif
            @if ($waLink)
                <div class="mb-6">
                    <a
                        href="{{ $waLink }}"
                        target="_blank"
                        class="flex w-full mx-auto items-center justify-center gap-2.5 rounded-2xl bg-white border border-[var(--border-color)] text-[var(--text-main)] hover:bg-[var(--input-bg)] px-6 py-3.5 text-[13px] font-bold shadow-sm transition-all active:scale-[0.98]"
                    >
                        <svg class="h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z" /></svg>
                        Hubungi Penjual via WhatsApp
                    </a>
                </div>
            @endif
        @endif
        <details
            class="mt-4 sm:mt-8 rounded-2xl bg-[var(--card-bg)] shadow-sm border border-[var(--border-color)]"
        >
            <summary
                class="cursor-pointer list-none px-5 py-4 text-[13.5px] font-bold text-[var(--text-main)] active:bg-[var(--input-bg)] sm:hover:bg-[var(--input-bg)] transition-colors rounded-2xl"
            >
                <span class="inline-flex items-center gap-2.5">
                    <svg class="h-4 w-4 text-[var(--text-muted)] transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" /></svg>
                    Lihat Detail Pesanan
                </span>
            </summary>
            <div
                class="border-t border-[var(--border-color)] px-5 py-5 space-y-3.5 text-[12.5px] sm:text-[13px] font-medium"
            >
                <div
                    class="flex justify-between items-center pb-3 border-b border-[var(--border-color)] mb-3"
                >
                    <span class="text-[var(--text-muted)]"
                        >Status Pembayaran</span
                    >
                    @if ($isPaid)
                        <span
                            class="font-bold text-green-700 bg-green-100 px-2.5 py-1 rounded-md text-[10px] uppercase tracking-widest border border-green-200"
                            >Lunas</span
                        >
                    @else
                        <span
                            class="font-bold text-amber-700 bg-amber-100 px-2.5 py-1 rounded-md text-[10px] uppercase tracking-widest border border-amber-200"
                            >Belum Bayar</span
                        >
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="text-[var(--text-muted)]">Nomor Invoice</span>
                    <span
                        class="font-mono font-bold text-[var(--text-main)]"
                        >{{ $order->invoice?->nomor_invoice }}</span
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
                        <div class="flex justify-between py-1.5 gap-2">
                            <span class="text-[var(--text-main)] font-bold">
                                {{ $item->produk->nama_produk }}
                                @if ($item->varian)
                                    <span
                                        class="text-[var(--text-muted)] font-medium ml-0.5 block sm:inline"
                                        >- {{ $item->varian }}</span
                                    >
                                @endif
                                <span class="text-[var(--text-muted)] ml-1"
                                    >× {{ $item->jumlah }}</span
                                >
                            </span>
                            <span
                                class="font-bold text-[var(--text-main)] shrink-0"
                                >Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span
                            >
                        </div>
                    @endforeach
                </div>
                <div
                    class="flex justify-between border-t border-[var(--border-color)] pt-4 mt-2 font-bold text-[14px]"
                >
                    <span class="text-[var(--text-main)]">Total Tagihan</span>
                    <span class="text-[var(--accent)]"
                        >Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span
                    >
                </div>
                <div class="pt-3 border-t border-[var(--border-color)] mt-2">
                    <a
                        href="{{ route('public.invoice', $order->public_token) }}?v={{ time() }}"
                        target="_blank"
                        class="inline-flex w-full sm:w-auto justify-center items-center gap-1.5 text-[12px] font-bold text-[var(--accent)] hover:underline border border-transparent active:bg-[var(--border-color)] sm:hover:border-[var(--accent)]/30 bg-[var(--accent-soft)] px-3 py-2.5 rounded-lg transition-colors"
                    >
                        Lihat Invoice PDF →
                    </a>
                </div>
            </div>
        </details>
        <div class="mt-8 text-center pb-8 sm:pb-0">
            <a
                href="{{ route('tenant.show', $tenant) }}"
                class="text-[13px] font-bold text-[var(--text-muted)] active:text-[var(--accent)] transition-colors inline-block p-2"
            >
                ← Kembali ke Toko
            </a>
        </div>
    </main>
</body>
</html>
