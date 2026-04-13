<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
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

        {{-- Success Banner --}}
        <div class="mb-8 flex flex-col items-center rounded-2xl bg-green-50 px-6 py-10 text-center">
            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-green-100 text-3xl">✅</div>
            <h1 class="mt-4 text-2xl font-bold text-green-800">Pesanan Berhasil Dibuat!</h1>
            <p class="mt-2 text-sm text-green-700">
                Terima kasih, <strong>{{ $order->nama_pembeli }}</strong>. Pesananmu sudah kami terima.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Order Info --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900">Detail Pesanan</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Kode Order</dt>
                        <dd class="font-mono font-medium text-gray-800">{{ $order->kode_order }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd>
                            <span class="rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-medium text-yellow-700 capitalize">
                                {{ $order->status }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Email</dt>
                        <dd class="text-gray-800">{{ $order->email_pembeli }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tanggal</dt>
                        <dd class="text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Invoice Info --}}
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold text-gray-900">Invoice</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nomor Invoice</dt>
                        <dd class="font-mono font-medium text-gray-800">{{ $invoice->nomor_invoice }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status Pembayaran</dt>
                        <dd>
                            @if($invoice->status_pembayaran === 'paid')
                                <span class="rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700">Lunas</span>
                            @elseif($invoice->status_pembayaran === 'cancelled')
                                <span class="rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-600">Dibatalkan</span>
                            @else
                                <span class="rounded-full bg-orange-50 px-2.5 py-0.5 text-xs font-medium text-orange-600">Belum Dibayar</span>
                            @endif
                        </dd>
                    </div>
                    <div class="border-t border-gray-100 pt-3">
                        <div class="flex justify-between font-semibold">
                            <dt class="text-gray-700">Total</dt>
                            <dd class="text-green-800">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Order Items --}}
        <div class="mt-6 rounded-2xl bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold text-gray-900">Item Pesanan</h2>
            <div class="mt-4 divide-y divide-gray-100">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center justify-between py-3">
                        <div class="flex items-center gap-3">
                            @if($item->produk->gambar)
                                <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                     alt="{{ $item->produk->nama_produk }}"
                                     class="h-12 w-12 rounded-lg object-cover">
                            @else
                                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 text-xl text-gray-300">📦</div>
                            @endif
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $item->produk->nama_produk }}</p>
                                <p class="text-xs text-gray-500">{{ $item->jumlah }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-semibold text-gray-800">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('tenant.show', $tenant) }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-200 px-6 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                ← Kembali ke Toko
            </a>
        </div>
    </main>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 bg-white py-6 text-center text-sm text-gray-400">
        Dibuat dengan
        <a href="{{ route('landing') }}" class="font-medium text-green-700 hover:underline">MyLinx</a>
    </footer>

</body>
</html>
