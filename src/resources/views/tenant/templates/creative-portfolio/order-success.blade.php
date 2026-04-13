<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'DM Sans', sans-serif; }
        .font-serif { font-family: 'DM Serif Display', serif; }
        .glass { backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
        .gradient-text { background: linear-gradient(135deg, #E879F9, #818CF8, #38BDF8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:text; }
    </style>
</head>
<body style="background:#0A0A15; color:white; min-height:100vh;">

    <div style="position:fixed;top:-20%;left:-10%;width:500px;height:500px;background:radial-gradient(circle, rgba(129,140,248,0.1) 0%, transparent 70%);pointer-events:none;z-index:0;"></div>
    <div style="position:fixed;bottom:-20%;right:-10%;width:400px;height:400px;background:radial-gradient(circle, rgba(232,121,249,0.08) 0%, transparent 70%);pointer-events:none;z-index:0;"></div>

    <header class="glass" style="background:rgba(10,10,21,0.8); border-bottom:1px solid rgba(255,255,255,0.08); position:sticky; top:0; z-index:100;">
        <div style="max-width:800px; margin:0 auto; padding:0 32px; height:72px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid rgba(129,140,248,0.4);">
            @else
                <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#818CF8,#E879F9);display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:white;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" class="font-serif" style="font-size:16px;color:white;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:800px; margin:0 auto; padding:56px 32px; position:relative;">

        {{-- Success --}}
        <div class="glass" style="text-align:center; padding:56px 32px; background:rgba(129,140,248,0.06); border-radius:24px; border:1px solid rgba(129,140,248,0.2); margin-bottom:24px; position:relative; overflow:hidden;">
            <div style="position:absolute;inset:0;background:linear-gradient(135deg,rgba(129,140,248,0.05),rgba(232,121,249,0.03));pointer-events:none;"></div>
            <div style="font-size:52px; margin-bottom:20px; position:relative;">✦</div>
            <h1 class="font-serif gradient-text" style="font-size:30px; margin-bottom:12px; position:relative;">Pesanan Berhasil!</h1>
            <p style="color:rgba(255,255,255,0.45); font-size:15px; line-height:1.7; font-weight:300; position:relative;">
                Terima kasih, <span style="color:rgba(255,255,255,0.8); font-weight:500;">{{ $order->nama_pembeli }}</span>.<br>
                Pesananmu sudah diterima dan akan segera diproses.
            </p>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

            <div class="glass" style="background:rgba(255,255,255,0.03); border-radius:16px; padding:24px; border:1px solid rgba(255,255,255,0.07);">
                <h2 style="font-size:11px; font-weight:500; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Detail Pesanan</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px; font-weight:300;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Kode</span>
                        <span style="font-family:monospace; font-weight:500; color:rgba(129,140,248,0.9); font-size:11px;">{{ $order->kode_order }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Status</span>
                        <span style="background:rgba(129,140,248,0.15); border:1px solid rgba(129,140,248,0.3); color:rgba(129,140,248,0.9); padding:3px 10px; border-radius:100px; font-size:11px; font-weight:500; text-transform:capitalize;">{{ $order->status }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Email</span>
                        <span style="color:rgba(255,255,255,0.55); font-size:11px;">{{ $order->email_pembeli }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Tanggal</span>
                        <span style="color:rgba(255,255,255,0.55); font-size:11px;">{{ $order->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="glass" style="background:rgba(255,255,255,0.03); border-radius:16px; padding:24px; border:1px solid rgba(255,255,255,0.07);">
                <h2 style="font-size:11px; font-weight:500; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Invoice</h2>
                <div style="display:flex; flex-direction:column; gap:12px; font-size:13px; font-weight:300;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Nomor</span>
                        <span style="font-family:monospace; font-weight:500; color:rgba(255,255,255,0.7); font-size:11px;">{{ $invoice->nomor_invoice }}</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <span style="color:rgba(255,255,255,0.35);">Status</span>
                        @if($invoice->status_pembayaran === 'paid')
                            <span style="background:rgba(74,222,128,0.1);border:1px solid rgba(74,222,128,0.3);color:rgba(74,222,128,0.9);padding:3px 10px;border-radius:100px;font-size:11px;font-weight:500;">Lunas</span>
                        @elseif($invoice->status_pembayaran === 'cancelled')
                            <span style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);color:rgba(248,113,113,0.9);padding:3px 10px;border-radius:100px;font-size:11px;font-weight:500;">Batal</span>
                        @else
                            <span style="background:rgba(251,191,36,0.1);border:1px solid rgba(251,191,36,0.3);color:rgba(251,191,36,0.9);padding:3px 10px;border-radius:100px;font-size:11px;font-weight:500;">Belum Bayar</span>
                        @endif
                    </div>
                    <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
                        <span class="font-serif" style="font-size:14px; color:rgba(255,255,255,0.6);">Total</span>
                        <span class="font-serif gradient-text" style="font-size:22px;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="glass" style="background:rgba(255,255,255,0.02); border-radius:16px; padding:24px; border:1px solid rgba(255,255,255,0.06); margin-bottom:28px;">
            <h2 style="font-size:11px; font-weight:500; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:16px;">Item Pesanan</h2>
            @foreach($order->orderItems as $item)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid rgba(255,255,255,0.04);">
                    <div style="display:flex; align-items:center; gap:12px;">
                        @if($item->produk->gambar)
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" style="width:44px;height:44px;border-radius:8px;object-fit:cover;opacity:0.8;border:1px solid rgba(255,255,255,0.08);">
                        @else
                            <div style="width:44px;height:44px;background:rgba(129,140,248,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;color:rgba(255,255,255,0.2);">✨</div>
                        @endif
                        <div>
                            <p class="font-serif" style="font-size:14px;color:rgba(255,255,255,0.8);margin-bottom:2px;">{{ $item->produk->nama_produk }}</p>
                            <p style="font-size:12px;color:rgba(255,255,255,0.3);font-weight:300;">{{ $item->jumlah }}× Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <span class="gradient-text font-serif" style="font-size:15px;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            @endforeach
        </div>

        <div style="text-align:center;">
            <a href="{{ route('tenant.show', $tenant) }}"
               class="glass"
               style="display:inline-block;border:1px solid rgba(255,255,255,0.1);color:rgba(255,255,255,0.4);padding:14px 28px;border-radius:14px;font-size:14px;font-weight:400;text-decoration:none;">
                ← Kembali ke Toko
            </a>
        </div>
    </main>

    <footer class="glass" style="border-top:1px solid rgba(255,255,255,0.06); padding:28px; text-align:center; margin-top:48px;">
        <p style="font-size:13px; color:rgba(255,255,255,0.2); font-weight:300;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:rgba(129,140,248,0.6); text-decoration:none; font-weight:500;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
