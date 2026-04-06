<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400&family=Source+Sans+3:wght@400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Source Sans 3', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
    </style>
</head>
<body style="background:#FBF7F0; color:#3D2B1F; min-height:100vh;">

    <header style="background:#FBF7F0; border-bottom:2px solid #E8D5B7;">
        <div style="max-width:800px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:38px;height:38px;border-radius:50%;border:2px solid #E8C87B;object-fit:cover;">
            @else
                <div style="width:38px;height:38px;border-radius:50%;background:#7C4C2A;display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#E8C87B;font-family:'Lora',serif;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" class="font-lora" style="font-size:17px;font-weight:700;color:#3D2B1F;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:800px; margin:0 auto; padding:48px 28px;">

        <div style="text-align:center; padding:52px 28px; background:white; border-radius:24px; border:1px solid #E8D5B7; box-shadow:0 8px 32px rgba(139,90,43,0.08); margin-bottom:24px;">
            <p style="font-size:48px; margin-bottom:20px;">☕</p>
            <h1 class="font-lora" style="font-size:28px; font-weight:700; color:#3D2B1F; margin-bottom:10px; font-style:italic;">Pesanan Berhasil!</h1>
            <div style="width:40px; height:2px; background:#E8C87B; margin:12px auto 16px;"></div>
            <p style="font-size:15px; color:#8B6A52; line-height:1.7;">
                Terima kasih, <strong style="color:#3D2B1F;">{{ $order->nama_pembeli }}</strong>.<br>
                Kami akan segera memproses pesananmu.
            </p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

            <div style="background:white; border-radius:16px; padding:24px; border:1px solid #E8D5B7;">
                <h2 style="font-size:11px; font-weight:700; color:#8B6A52; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Detail Pesanan</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Kode</span>
                        <span style="font-family:monospace; font-weight:700; color:#3D2B1F; font-size:12px;">{{ $order->kode_order }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Status</span>
                        <span style="background:#FEF9EC; border:1px solid #E8C87B; color:#7C4C2A; padding:3px 12px; border-radius:100px; font-size:11px; font-weight:600; text-transform:capitalize;">{{ $order->status }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Email</span>
                        <span style="color:#3D2B1F; font-size:12px;">{{ $order->email_pembeli }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Tanggal</span>
                        <span style="color:#3D2B1F; font-size:12px;">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div style="background:white; border-radius:16px; padding:24px; border:1px solid #E8D5B7;">
                <h2 style="font-size:11px; font-weight:700; color:#8B6A52; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Invoice</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Nomor</span>
                        <span style="font-family:monospace; font-weight:700; color:#3D2B1F; font-size:12px;">{{ $invoice->nomor_invoice }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#8B6A52; font-weight:500;">Bayar</span>
                        @if($invoice->status_pembayaran === 'paid')
                            <span style="background:#F0FDF4; color:#166534; border:1px solid #BBF7D0; padding:3px 12px; border-radius:100px; font-size:11px; font-weight:600;">Lunas</span>
                        @elseif($invoice->status_pembayaran === 'cancelled')
                            <span style="background:#FEF2F2; color:#B91C1C; border:1px solid #FECACA; padding:3px 12px; border-radius:100px; font-size:11px; font-weight:600;">Batal</span>
                        @else
                            <span style="background:#FFF9E6; color:#92620A; border:1px solid #E8C87B; padding:3px 12px; border-radius:100px; font-size:11px; font-weight:600;">Belum Bayar</span>
                        @endif
                    </div>
                    <div style="border-top:1px solid #E8D5B7; padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
                        <span class="font-lora" style="font-size:14px; font-weight:700; color:#3D2B1F;">Total</span>
                        <span class="font-lora" style="font-size:22px; font-weight:700; color:#7C4C2A;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div style="background:white; border-radius:16px; padding:24px; border:1px solid #E8D5B7; margin-bottom:28px;">
            <h2 style="font-size:11px; font-weight:700; color:#8B6A52; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Item Pesanan</h2>
            @foreach($order->orderItems as $item)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #F5EDE0;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        @if($item->produk->gambar)
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid #E8D5B7;">
                        @else
                            <div style="width:44px;height:44px;background:#F5EDDF;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#C4A882;">☕</div>
                        @endif
                        <div>
                            <p class="font-lora" style="font-size:14px;font-weight:600;color:#3D2B1F;margin-bottom:2px;font-style:italic;">{{ $item->produk->nama_produk }}</p>
                            <p style="font-size:12px;color:#8B6A52;">{{ $item->jumlah }}× Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <span class="font-lora" style="font-size:15px;font-weight:700;color:#7C4C2A;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div style="text-align:center;">
            <a href="{{ route('tenant.show', $tenant) }}"
               class="font-lora"
               style="display:inline-block;border:1.5px solid #E8D5B7;color:#8B6A52;padding:14px 28px;border-radius:12px;font-size:15px;font-weight:500;text-decoration:none;font-style:italic;background:white;">
                ← Kembali ke Menu
            </a>
        </div>
    </main>

    <footer style="background:#3D2B1F; padding:28px; text-align:center; margin-top:48px;">
        <p style="font-size:13px; color:#5A3920;">Dibuat dengan <a href="{{ route('landing') }}" style="color:#E8C87B; text-decoration:none; font-weight:600;">MyLinx</a></p>
    </footer>
</body>
</html>
