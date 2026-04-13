<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'DM Sans', sans-serif; }
        .font-serif { font-family: 'DM Serif Display', serif; }
        .glass { backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
        .gradient-text { background: linear-gradient(135deg, #E879F9, #818CF8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:text; }
        input { background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.12); color:white; }
        input:focus { outline:none; border-color:rgba(129,140,248,0.6); box-shadow:0 0 0 2px rgba(129,140,248,0.15); }
        input::placeholder { color:rgba(255,255,255,0.2); }
    </style>
</head>
<body style="background:#0A0A15; color:white; min-height:100vh;">

    <div style="position:fixed;top:-20%;left:-10%;width:400px;height:400px;background:radial-gradient(circle, rgba(129,140,248,0.08) 0%, transparent 70%);pointer-events:none;z-index:0;"></div>

    <header class="glass" style="background:rgba(10,10,21,0.8); border-bottom:1px solid rgba(255,255,255,0.08); position:sticky; top:0; z-index:100;">
        <div style="max-width:900px; margin:0 auto; padding:0 32px; height:72px; display:flex; align-items:center; gap:14px;">
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

    <main style="max-width:900px; margin:0 auto; padding:48px 32px; position:relative;">

        <nav style="display:flex; align-items:center; gap:10px; font-size:13px; margin-bottom:36px; font-weight:300;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:rgba(129,140,248,0.7); text-decoration:none;">Toko</a>
            <span style="color:rgba(255,255,255,0.2);">›</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="color:rgba(255,255,255,0.4); text-decoration:none;">{{ $produk->nama_produk }}</a>
            <span style="color:rgba(255,255,255,0.2);">›</span>
            <span style="color:rgba(255,255,255,0.7);">Checkout</span>
        </nav>

        @if(session('error'))
            <div class="glass" style="background:rgba(248,113,113,0.1);border:1px solid rgba(248,113,113,0.3);border-radius:12px;padding:14px 18px;font-size:14px;color:rgba(248,113,113,0.9);margin-bottom:24px;font-weight:400;">
                ⚠ {{ session('error') }}
            </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

            <div class="glass" style="background:rgba(255,255,255,0.04); border-radius:20px; padding:36px; border:1px solid rgba(255,255,255,0.08);">
                <h1 class="font-serif" style="font-size:26px; color:white; margin-bottom:32px;">Data Pemesanan</h1>

                <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
                    @csrf

                    <div>
                        <label for="nama_pembeli" style="display:block; font-size:11px; font-weight:500; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:8px;">Nama Lengkap</label>
                        <input type="text" id="nama_pembeli" name="nama_pembeli" value="{{ old('nama_pembeli') }}" placeholder="Nama kamu..." required
                               style="width:100%; padding:14px 18px; border-radius:12px; font-size:15px; font-weight:400;">
                        @error('nama_pembeli')
                            <p style="color:rgba(248,113,113,0.9); font-size:12px; margin-top:6px; font-weight:400;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_pembeli" style="display:block; font-size:11px; font-weight:500; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:8px;">Email</label>
                        <input type="email" id="email_pembeli" name="email_pembeli" value="{{ old('email_pembeli') }}" placeholder="email@kamu.com" required
                               style="width:100%; padding:14px 18px; border-radius:12px; font-size:15px; font-weight:400;">
                        @error('email_pembeli')
                            <p style="color:rgba(248,113,113,0.9); font-size:12px; margin-top:6px; font-weight:400;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" style="display:block; font-size:11px; font-weight:500; color:rgba(255,255,255,0.4); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:8px;">Jumlah (maks. {{ $produk->stok }})</label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required
                               style="width:100%; padding:14px 18px; border-radius:12px; font-size:15px; font-weight:400;">
                        @error('jumlah')
                            <p style="color:rgba(248,113,113,0.9); font-size:12px; margin-top:6px; font-weight:400;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            style="background:linear-gradient(135deg,#818CF8,#E879F9); color:white; padding:18px 24px; border-radius:14px; font-size:16px; font-weight:600; border:none; cursor:pointer; margin-top:8px; letter-spacing:0.01em;">
                        Konfirmasi Pesanan ✦
                    </button>
                </form>
            </div>

            <div class="glass" style="background:rgba(255,255,255,0.03); border-radius:20px; padding:24px; border:1px solid rgba(255,255,255,0.07);">
                <h2 style="font-size:11px; font-weight:500; color:rgba(255,255,255,0.3); text-transform:uppercase; letter-spacing:0.12em; margin-bottom:20px;">Ringkasan</h2>
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:160px; object-fit:cover; border-radius:12px; margin-bottom:16px; opacity:0.85;">
                @else
                    <div style="height:160px; background:linear-gradient(135deg,rgba(129,140,248,0.1),rgba(232,121,249,0.08)); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:40px; color:rgba(255,255,255,0.1); margin-bottom:16px;">✨</div>
                @endif
                <p class="font-serif" style="font-size:17px; color:white; margin-bottom:6px;">{{ $produk->nama_produk }}</p>
                <p style="font-size:13px; color:rgba(255,255,255,0.35); margin-bottom:20px; line-height:1.6; font-weight:300;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                <div style="border-top:1px solid rgba(255,255,255,0.06); padding-top:16px;">
                    <div style="display:flex; justify-content:space-between; font-size:14px; color:rgba(255,255,255,0.4); font-weight:300;">
                        <span>Harga satuan</span>
                        <span class="gradient-text font-serif" style="font-size:18px;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <p style="font-size:11px; color:rgba(255,255,255,0.2); margin-top:8px; font-weight:300;">Total dihitung saat konfirmasi</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="glass" style="border-top:1px solid rgba(255,255,255,0.06); padding:28px; text-align:center; margin-top:48px;">
        <p style="font-size:13px; color:rgba(255,255,255,0.2); font-weight:300;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:rgba(129,140,248,0.6); text-decoration:none; font-weight:500;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
