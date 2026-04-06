<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700;800;900&display=swap');
        * { font-family: 'Barlow', sans-serif; margin:0; padding:0; box-sizing:border-box; }
        input { background:#1A1A1A; border:1.5px solid #333; color:white; }
        input:focus { outline:2px solid #F59E0B; border-color:#F59E0B; }
        input::placeholder { color:#555; }
    </style>
</head>
<body style="background:#111111; color:white; min-height:100vh;">

    <header style="background:#0A0A0A; border-bottom:2px solid #F59E0B; position:sticky; top:0; z-index:100;">
        <div style="max-width:900px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; gap:14px;">
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

    <main style="max-width:900px; margin:0 auto; padding:48px 28px;">

        <nav style="display:flex; align-items:center; gap:10px; font-size:12px; color:#666; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:36px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#F59E0B; text-decoration:none;">Toko</a>
            <span style="color:#333;">›</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="color:#888; text-decoration:none;">{{ $produk->nama_produk }}</a>
            <span style="color:#333;">›</span>
            <span style="color:white;">Checkout</span>
        </nav>

        @if(session('error'))
            <div style="background:#450A0A;border:1px solid #7F1D1D;border-radius:8px;padding:14px 18px;font-size:14px;color:#FCA5A5;margin-bottom:24px;font-weight:600;">
                ⚠ {{ session('error') }}
            </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

            <div style="background:#1A1A1A; border-radius:12px; padding:32px; border:1px solid #2A2A2A;">
                <h1 style="font-size:24px; font-weight:900; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:28px;">Data Pemesanan</h1>

                <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
                    @csrf

                    <div>
                        <label for="nama_pembeli" style="display:block; font-size:11px; font-weight:800; color:#888; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Nama Lengkap</label>
                        <input type="text" id="nama_pembeli" name="nama_pembeli" value="{{ old('nama_pembeli') }}" placeholder="Nama kamu..." required
                               style="width:100%; padding:14px 16px; border-radius:8px; font-size:15px; font-weight:600;">
                        @error('nama_pembeli')
                            <p style="color:#F87171; font-size:12px; margin-top:6px; font-weight:600;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_pembeli" style="display:block; font-size:11px; font-weight:800; color:#888; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Email</label>
                        <input type="email" id="email_pembeli" name="email_pembeli" value="{{ old('email_pembeli') }}" placeholder="email@kamu.com" required
                               style="width:100%; padding:14px 16px; border-radius:8px; font-size:15px; font-weight:600;">
                        @error('email_pembeli')
                            <p style="color:#F87171; font-size:12px; margin-top:6px; font-weight:600;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" style="display:block; font-size:11px; font-weight:800; color:#888; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Jumlah (Maks. {{ $produk->stok }})</label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required
                               style="width:100%; padding:14px 16px; border-radius:8px; font-size:15px; font-weight:600;">
                        @error('jumlah')
                            <p style="color:#F87171; font-size:12px; margin-top:6px; font-weight:600;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            style="background:#F59E0B; color:#0A0A0A; padding:18px 24px; border-radius:8px; font-size:16px; font-weight:900; text-transform:uppercase; letter-spacing:0.06em; border:none; cursor:pointer; margin-top:8px;">
                        Konfirmasi Pesanan →
                    </button>
                </form>
            </div>

            <div style="background:#1A1A1A; border-radius:12px; padding:24px; border:1px solid #2A2A2A;">
                <h2 style="font-size:11px; font-weight:800; color:#888; text-transform:uppercase; letter-spacing:0.12em; margin-bottom:20px;">Ringkasan Pesanan</h2>
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:160px; object-fit:cover; border-radius:8px; margin-bottom:16px;">
                @else
                    <div style="height:160px; background:#222; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:40px; color:#444; margin-bottom:16px;">📦</div>
                @endif
                <p style="font-weight:700; font-size:16px; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px;">{{ $produk->nama_produk }}</p>
                <p style="font-size:13px; color:#888; margin-bottom:20px; line-height:1.5;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                <div style="border-top:1px solid #2A2A2A; padding-top:16px;">
                    <div style="display:flex; justify-content:space-between; font-size:14px; color:#888; margin-bottom:6px;">
                        <span>Harga Satuan</span>
                        <span style="color:#F59E0B; font-weight:800;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <p style="font-size:11px; color:#555; margin-top:8px;">Total dihitung saat konfirmasi</p>
                </div>
            </div>
        </div>
    </main>

    <footer style="border-top:2px solid #F59E0B; background:#0A0A0A; padding:24px 28px; text-align:center; margin-top:48px;">
        <p style="font-size:12px; color:#555; font-weight:700; text-transform:uppercase; letter-spacing:0.08em;">
            Powered by <a href="{{ route('landing') }}" style="color:#F59E0B; text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
