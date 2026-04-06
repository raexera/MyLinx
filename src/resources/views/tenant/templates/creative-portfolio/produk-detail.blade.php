<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
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

    <header class="glass" style="background:rgba(10,10,21,0.8); border-bottom:1px solid rgba(255,255,255,0.08); position:sticky; top:0; z-index:100;">
        <div style="max-width:1100px; margin:0 auto; padding:0 32px; height:72px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid rgba(129,140,248,0.4);">
            @else
                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#818CF8,#E879F9);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:white;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" class="font-serif" style="font-size:17px;color:white;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:1100px; margin:0 auto; padding:48px 32px; position:relative;">

        <nav style="display:flex; align-items:center; gap:10px; font-size:13px; color:rgba(255,255,255,0.3); margin-bottom:40px; font-weight:300;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:rgba(129,140,248,0.7); text-decoration:none;">Toko</a>
            <span>›</span>
            <span style="color:rgba(255,255,255,0.6);">{{ $produk->nama_produk }}</span>
        </nav>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:56px; align-items:start;">

            <div class="glass" style="border-radius:24px; overflow:hidden; border:1px solid rgba(255,255,255,0.08);">
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; aspect-ratio:4/3; object-fit:cover;">
                @else
                    <div style="aspect-ratio:4/3; background:linear-gradient(135deg,rgba(129,140,248,0.1),rgba(232,121,249,0.08)); display:flex; align-items:center; justify-content:center; font-size:80px; color:rgba(255,255,255,0.1);">✨</div>
                @endif
            </div>

            <div style="padding-top:8px;">
                <p style="color:rgba(232,121,249,0.7); font-size:11px; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:12px;">Produk / Layanan</p>
                <h1 class="font-serif" style="font-size:36px; color:white; margin-bottom:16px; line-height:1.15;">
                    {{ $produk->nama_produk }}
                </h1>

                <p class="gradient-text font-serif" style="font-size:34px; margin-bottom:20px;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                @if($produk->stok > 0)
                    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(129,140,248,0.1); border:1px solid rgba(129,140,248,0.25); padding:8px 18px; border-radius:100px; margin-bottom:28px;">
                        <span style="width:7px; height:7px; background:#818CF8; border-radius:50%; box-shadow:0 0 8px #818CF8;"></span>
                        <span style="color:rgba(129,140,248,0.9); font-size:13px; font-weight:500;">Tersedia · {{ $produk->stok }} unit</span>
                    </div>
                @else
                    <div style="display:inline-flex; align-items:center; gap:8px; background:rgba(248,113,113,0.1); border:1px solid rgba(248,113,113,0.25); padding:8px 18px; border-radius:100px; margin-bottom:28px;">
                        <span style="color:rgba(248,113,113,0.9); font-size:13px; font-weight:500;">Stok Habis</span>
                    </div>
                @endif

                <p style="color:rgba(255,255,255,0.45); font-size:15px; line-height:1.8; margin-bottom:36px; font-weight:300;">
                    {{ $produk->deskripsi }}
                </p>

                <div style="display:flex; flex-direction:column; gap:12px;">
                    @if($produk->stok > 0)
                        <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                           style="display:block; text-align:center; background:linear-gradient(135deg,#818CF8,#E879F9); color:white; padding:17px 28px; border-radius:14px; font-size:16px; font-weight:600; text-decoration:none; letter-spacing:0.01em;">
                            Beli Sekarang ✦
                        </a>
                    @else
                        <button disabled style="display:block; width:100%; background:rgba(255,255,255,0.05); color:rgba(255,255,255,0.25); padding:17px 28px; border-radius:14px; font-size:16px; font-weight:600; border:1px solid rgba(255,255,255,0.08); cursor:not-allowed;">
                            Stok Habis
                        </button>
                    @endif
                    <a href="{{ route('tenant.show', $tenant) }}"
                       style="display:block; text-align:center; border:1px solid rgba(255,255,255,0.1); color:rgba(255,255,255,0.4); padding:15px 28px; border-radius:14px; font-size:14px; font-weight:400; text-decoration:none;">
                        ← Kembali
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer class="glass" style="border-top:1px solid rgba(255,255,255,0.06); padding:28px; text-align:center; margin-top:60px;">
        <p style="font-size:13px; color:rgba(255,255,255,0.2); font-weight:300;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:rgba(129,140,248,0.7); text-decoration:none; font-weight:500;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
