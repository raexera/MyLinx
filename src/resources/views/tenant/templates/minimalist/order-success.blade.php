<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen antialiased" style="background:#F9F9F7; color:#1A1A18;">

    <header style="background:white; border-bottom:1px solid #E8E8E4;">
        <div style="max-width:800px; margin:0 auto; padding:0 24px; height:68px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:34px;height:34px;border-radius:50%;object-fit:cover;">
            @else
                <div style="width:34px;height:34px;border-radius:50%;background:#1A1A18;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;color:white;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" style="font-weight:700;font-size:16px;color:#1A1A18;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:800px;margin:0 auto;padding:48px 24px;">

        {{-- Success Banner --}}
        <div style="text-align:center;padding:48px 24px;background:white;border-radius:24px;border:1px solid #E8E8E4;margin-bottom:24px;">
            <div style="width:64px;height:64px;background:#F0F5F1;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 20px;">✅</div>
            <h1 style="font-size:26px;font-weight:700;color:#1A1A18;margin-bottom:10px;">Pesanan Berhasil Dibuat!</h1>
            <p style="font-size:15px;color:#7A7A6A;line-height:1.6;">
                Terima kasih, <strong style="color:#1A1A18;">{{ $order->nama_pembeli }}</strong>.<br>
                Pesananmu sudah kami terima dan akan segera diproses.
            </p>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">

            {{-- Order Info --}}
            <div style="background:white;border-radius:20px;padding:24px;border:1px solid #E8E8E4;">
                <h2 style="font-size:14px;font-weight:700;color:#1A1A18;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.05em;">Detail Pesanan</h2>
                <div style="display:flex;flex-direction:column;gap:12px;font-size:13px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Kode Order</span>
                        <span style="font-family:monospace;font-weight:600;color:#1A1A18;">{{ $order->kode_order }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Status</span>
                        <span style="background:#FFF9E6;color:#92620A;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:600;text-transform:capitalize;">{{ $order->status }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Email</span>
                        <span style="color:#1A1A18;">{{ $order->email_pembeli }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Tanggal</span>
                        <span style="color:#1A1A18;">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            {{-- Invoice Info --}}
            <div style="background:white;border-radius:20px;padding:24px;border:1px solid #E8E8E4;">
                <h2 style="font-size:14px;font-weight:700;color:#1A1A18;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.05em;">Invoice</h2>
                <div style="display:flex;flex-direction:column;gap:12px;font-size:13px;">
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Nomor Invoice</span>
                        <span style="font-family:monospace;font-weight:600;color:#1A1A18;">{{ $invoice->nomor_invoice }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="color:#9E9E8A;">Status Bayar</span>
                        @if($invoice->status_pembayaran === 'paid')
                            <span style="background:#F0F9F4;color:#166534;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:600;">Lunas</span>
                        @elseif($invoice->status_pembayaran === 'cancelled')
                            <span style="background:#FEF2F2;color:#B91C1C;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:600;">Dibatalkan</span>
                        @else
                            <span style="background:#FFF7ED;color:#C2410C;padding:3px 10px;border-radius:100px;font-size:11px;font-weight:600;">Belum Dibayar</span>
                        @endif
                    </div>
                    <div style="border-top:1px solid #F0F0EC;padding-top:12px;display:flex;justify-content:space-between;">
                        <span style="font-weight:600;color:#1A1A18;">Total</span>
                        <span style="font-weight:700;font-size:16px;color:#1A1A18;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div style="background:white;border-radius:20px;padding:24px;border:1px solid #E8E8E4;margin-bottom:28px;">
            <h2 style="font-size:14px;font-weight:700;color:#1A1A18;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.05em;">Item Pesanan</h2>
            <div style="display:flex;flex-direction:column;gap:0;">
                @foreach($order->orderItems as $item)
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid #F5F5F0;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            @if($item->produk->gambar)
                                <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover;">
                            @else
                                <div style="width:44px;height:44px;background:#F0F0EC;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#C8C8BC;">📦</div>
                            @endif
                            <div>
                                <p style="font-size:14px;font-weight:600;color:#1A1A18;margin-bottom:2px;">{{ $item->produk->nama_produk }}</p>
                                <p style="font-size:12px;color:#9E9E8A;">{{ $item->jumlah }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span style="font-size:14px;font-weight:600;color:#1A1A18;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div style="text-align:center;">
            <a href="{{ route('tenant.show', $tenant) }}"
               style="display:inline-flex;align-items:center;gap:8px;padding:14px 28px;border:1.5px solid #E0E0D8;border-radius:12px;font-size:14px;font-weight:500;color:#5A5A4A;text-decoration:none;background:white;">
                ← Kembali ke Toko
            </a>
        </div>
    </main>

    <footer style="border-top:1px solid #E8E8E4;background:white;padding:24px;text-align:center;margin-top:48px;">
        <p style="font-size:13px;color:#9E9E8A;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:#1A1A18;font-weight:600;text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
