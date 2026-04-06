<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesan — {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,600;0,700;1,400&family=Source+Sans+3:wght@400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Source Sans 3', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
        input { background:white; border:1.5px solid #E8D5B7; color:#3D2B1F; }
        input:focus { outline:2px solid #7C4C2A; border-color:#7C4C2A; }
        input::placeholder { color:#C4A882; }
    </style>
</head>
<body style="background:#FBF7F0; color:#3D2B1F; min-height:100vh;">

    <header style="background:#FBF7F0; border-bottom:2px solid #E8D5B7;">
        <div style="max-width:900px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid #E8C87B;">
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

    <main style="max-width:900px; margin:0 auto; padding:40px 28px;">

        <nav style="display:flex; align-items:center; gap:8px; font-size:13px; color:#8B6A52; margin-bottom:32px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#8B6A52; text-decoration:none;">Menu</a>
            <span>›</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="color:#8B6A52; text-decoration:none;">{{ $produk->nama_produk }}</a>
            <span>›</span>
            <span style="color:#3D2B1F; font-weight:500;">Pesan</span>
        </nav>

        @if(session('error'))
            <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 18px;font-size:14px;color:#B91C1C;margin-bottom:24px;font-weight:600;">
                ⚠ {{ session('error') }}
            </div>
        @endif

        <div style="display:grid; grid-template-columns:1fr 360px; gap:24px; align-items:start;">

            <div style="background:white; border-radius:20px; padding:32px; border:1px solid #E8D5B7; box-shadow:0 4px 16px rgba(139,90,43,0.06);">
                <h1 class="font-lora" style="font-size:24px; font-weight:700; color:#3D2B1F; margin-bottom:28px; font-style:italic;">Lengkapi Pesanan</h1>

                <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
                    @csrf

                    <div>
                        <label for="nama_pembeli" style="display:block; font-size:12px; font-weight:600; color:#8B6A52; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Nama Lengkap</label>
                        <input type="text" id="nama_pembeli" name="nama_pembeli" value="{{ old('nama_pembeli') }}" placeholder="Siapa namanya?" required
                               style="width:100%; padding:13px 16px; border-radius:10px; font-size:15px; font-family:'Source Sans 3',sans-serif;">
                        @error('nama_pembeli')
                            <p style="color:#B91C1C; font-size:12px; margin-top:6px; font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_pembeli" style="display:block; font-size:12px; font-weight:600; color:#8B6A52; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Email</label>
                        <input type="email" id="email_pembeli" name="email_pembeli" value="{{ old('email_pembeli') }}" placeholder="email@kamu.com" required
                               style="width:100%; padding:13px 16px; border-radius:10px; font-size:15px; font-family:'Source Sans 3',sans-serif;">
                        @error('email_pembeli')
                            <p style="color:#B91C1C; font-size:12px; margin-top:6px; font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" style="display:block; font-size:12px; font-weight:600; color:#8B6A52; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:8px;">Jumlah (maks. {{ $produk->stok }})</label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" max="{{ $produk->stok }}" required
                               style="width:100%; padding:13px 16px; border-radius:10px; font-size:15px; font-family:'Source Sans 3',sans-serif;">
                        @error('jumlah')
                            <p style="color:#B91C1C; font-size:12px; margin-top:6px; font-weight:500;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            style="background:#7C4C2A; color:#E8C87B; padding:16px 24px; border-radius:12px; font-size:16px; font-weight:600; border:none; cursor:pointer; margin-top:8px; font-family:'Lora',serif; font-style:italic;">
                        Konfirmasi Pesanan ✦
                    </button>
                </form>
            </div>

            <div style="background:white; border-radius:20px; padding:24px; border:1px solid #E8D5B7; box-shadow:0 4px 16px rgba(139,90,43,0.06);">
                <h2 style="font-size:12px; font-weight:600; color:#8B6A52; text-transform:uppercase; letter-spacing:0.1em; margin-bottom:20px;">Ringkasan Pesanan</h2>
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:160px; object-fit:cover; border-radius:12px; margin-bottom:16px;">
                @else
                    <div style="height:160px; background:linear-gradient(135deg,#F5EDDF,#EAD9C4); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:40px; color:#C4A882; margin-bottom:16px;">☕</div>
                @endif
                <p class="font-lora" style="font-weight:600; font-size:17px; color:#3D2B1F; margin-bottom:6px; font-style:italic;">{{ $produk->nama_produk }}</p>
                <p style="font-size:13px; color:#8B6A52; margin-bottom:20px; line-height:1.6;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                <div style="border-top:1px solid #E8D5B7; padding-top:16px;">
                    <div style="display:flex; justify-content:space-between; font-size:14px; color:#8B6A52;">
                        <span>Harga satuan</span>
                        <span class="font-lora" style="font-weight:700; color:#7C4C2A; font-size:17px;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <p style="font-size:11px; color:#C4A882; margin-top:8px;">Total dihitung saat konfirmasi</p>
                </div>
            </div>
        </div>
    </main>

    <footer style="background:#3D2B1F; padding:28px; text-align:center; margin-top:48px;">
        <p style="font-size:13px; color:#5A3920;">Dibuat dengan <a href="{{ route('landing') }}" style="color:#E8C87B; text-decoration:none; font-weight:600;">MyLinx</a></p>
    </footer>
</body>
</html>
