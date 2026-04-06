<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700;800;900&display=swap');
        * { font-family: 'Barlow', sans-serif; margin:0; padding:0; box-sizing:border-box; }
    </style>
</head>
<body style="background:#111111; color:white; min-height:100vh;">

    <header style="background:#0A0A0A; border-bottom:2px solid #F59E0B; position:sticky; top:0; z-index:100;">
        <div style="max-width:800px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:34px;height:34px;border-radius:6px;object-fit:cover;border:2px solid #F59E0B;">
            @else
                <div style="width:34px;height:34px;border-radius:6px;background:#F59E0B;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:14px;color:#0A0A0A;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" style="font-weight:900;font-size:17px;text-transform:uppercase;color:white;text-decoration:none;letter-spacing:0.05em;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:800px; margin:0 auto; padding:48px 28px;">

        {{-- Success Banner --}}
        <div style="background:#1A1A1A; border:2px solid #F59E0B; border-radius:12px; padding:48px 28px; text-align:center; margin-bottom:24px;">
            <div style="font-size:48px; margin-bottom:16px;">✅</div>
            <h1 style="font-size:32px; font-weight:900; text-transform:uppercase; letter-spacing:0.04em; color:#F59E0B; margin-bottom:12px;">Pesanan Diterima!</h1>
            <p style="font-size:15px; color:#A0A0A0; font-weight:600;">
                Terima kasih, <span style="color:white;">{{ $order->nama_pembeli }}</span>. Pesananmu sudah masuk.
            </p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

            <div style="background:#1A1A1A; border-radius:10px; padding:24px; border:1px solid #2A2A2A;">
                <h2 style="font-size:11px; font-weight:800; color:#666; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Detail Pesanan</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Kode</span>
                        <span style="font-family:monospace; font-weight:800; color:#F59E0B; font-size:12px;">{{ $order->kode_order }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Status</span>
                        <span style="background:#F59E0B; color:#0A0A0A; padding:3px 10px; border-radius:4px; font-size:11px; font-weight:800; text-transform:uppercase;">{{ $order->status }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Email</span>
                        <span style="color:#A0A0A0; font-size:12px;">{{ $order->email_pembeli }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Tanggal</span>
                        <span style="color:#A0A0A0; font-size:12px;">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div style="background:#1A1A1A; border-radius:10px; padding:24px; border:1px solid #2A2A2A;">
                <h2 style="font-size:11px; font-weight:800; color:#666; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Invoice</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Nomor</span>
                        <span style="font-family:monospace; font-weight:800; color:white; font-size:12px;">{{ $invoice->nomor_invoice }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:#666; font-weight:700;">Bayar</span>
                        @if($invoice->status_pembayaran === 'paid')
                            <span style="background:#166534; color:#4ADE80; padding:3px 10px; border-radius:4px; font-size:11px; font-weight:800; text-transform:uppercase;">Lunas</span>
                        @elseif($invoice->status_pembayaran === 'cancelled')
                            <span style="background:#7F1D1D; color:#F87171; padding:3px 10px; border-radius:4px; font-size:11px; font-weight:800; text-transform:uppercase;">Batal</span>
                        @else
                            <span style="background:#78350F; color:#FCD34D; padding:3px 10px; border-radius:4px; font-size:11px; font-weight:800; text-transform:uppercase;">Belum Bayar</span>
                        @endif
                    </div>
                    <div style="border-top:1px solid #2A2A2A; padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
                        <span style="font-weight:800; text-transform:uppercase; letter-spacing:0.06em; font-size:12px;">Total</span>
                        <span style="font-size:22px; font-weight:900; color:#F59E0B;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Order Items --}}
        <div style="background:#1A1A1A; border-radius:10px; padding:24px; border:1px solid #2A2A2A; margin-bottom:28px;">
            <h2 style="font-size:11px; font-weight:800; color:#666; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Item Pesanan</h2>
            @foreach($order->orderItems as $item)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #2A2A2A;">
                    <div style="display:flex; align-items:center; gap:12px;">
                        @if($item->produk->gambar)
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" style="width:44px;height:44px;border-radius:6px;object-fit:cover;border:1px solid #333;">
                        @else
                            <div style="width:44px;height:44px;background:#222;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#444;">📦</div>
                        @endif
                        <div>
                            <p style="font-size:14px;font-weight:700;color:white;text-transform:uppercase;margin-bottom:4px;">{{ $item->produk->nama_produk }}</p>
                            <p style="font-size:12px;color:#666;font-weight:600;">{{ $item->jumlah }}× Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <span style="font-size:15px;font-weight:800;color:#F59E0B;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div style="text-align:center;">
            <a href="{{ route('tenant.show', $tenant) }}"
               style="display:inline-block;border:2px solid #333;color:#888;padding:14px 28px;border-radius:8px;font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;text-decoration:none;">
                ← Back to Store
            </a>
        </div>
    </main>

    <footer style="border-top:2px solid #F59E0B; background:#0A0A0A; padding:24px 28px; text-align:center; margin-top:48px;">
        <p style="font-size:12px; color:#555; font-weight:700; text-transform:uppercase; letter-spacing:0.08em;">
            Powered by <a href="{{ route('landing') }}" style="color:#F59E0B; text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
