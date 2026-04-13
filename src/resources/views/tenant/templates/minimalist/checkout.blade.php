<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout — {{ $produk->nama_produk }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        input:focus { outline: 2px solid #1A1A18; outline-offset: -1px; }
    </style>
</head>
<body class="min-h-screen antialiased" style="background:#F9F9F7; color:#1A1A18;">

    <header style="background:white; border-bottom:1px solid #E8E8E4;">
        <div style="max-width:900px; margin:0 auto; padding:0 24px; height:68px; display:flex; align-items:center; gap:14px;">
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

    <main style="max-width:900px;margin:0 auto;padding:40px 24px;">

        <nav style="display:flex;align-items:center;gap:8px;font-size:13px;color:#9E9E8A;margin-bottom:32px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#9E9E8A;text-decoration:none;">Toko</a>
            <span>›</span>
            <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="color:#9E9E8A;text-decoration:none;">{{ $produk->nama_produk }}</a>
            <span>›</span>
            <span style="color:#1A1A18;">Checkout</span>
        </nav>

        {{-- Flash Error --}}
        @if(session('error'))
            <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:14px 18px;font-size:14px;color:#B91C1C;margin-bottom:24px;">
                {{ session('error') }}
            </div>
        @endif

        <div style="display:grid;grid-template-columns:1fr 380px;gap:24px;align-items:start;">

            {{-- Form --}}
            <div style="background:white;border-radius:20px;padding:32px;border:1px solid #E8E8E4;">
                <h1 style="font-size:22px;font-weight:700;color:#1A1A18;margin-bottom:28px;">Data Pemesanan</h1>

                <form action="{{ route('tenant.checkout.store', [$tenant, $produk]) }}" method="POST" style="display:flex;flex-direction:column;gap:20px;">
                    @csrf

                    <div>
                        <label for="nama_pembeli" style="display:block;font-size:13px;font-weight:600;color:#5A5A4A;margin-bottom:8px;">Nama Lengkap</label>
                        <input type="text" id="nama_pembeli" name="nama_pembeli"
                               value="{{ old('nama_pembeli') }}"
                               placeholder="Masukkan nama lengkap"
                               required
                               style="width:100%;padding:12px 16px;border:1.5px solid #E0E0D8;border-radius:10px;font-size:14px;color:#1A1A18;background:white;box-sizing:border-box;">
                        @error('nama_pembeli')
                            <p style="color:#B91C1C;font-size:12px;margin-top:6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email_pembeli" style="display:block;font-size:13px;font-weight:600;color:#5A5A4A;margin-bottom:8px;">Email</label>
                        <input type="email" id="email_pembeli" name="email_pembeli"
                               value="{{ old('email_pembeli') }}"
                               placeholder="nama@email.com"
                               required
                               style="width:100%;padding:12px 16px;border:1.5px solid #E0E0D8;border-radius:10px;font-size:14px;color:#1A1A18;background:white;box-sizing:border-box;">
                        @error('email_pembeli')
                            <p style="color:#B91C1C;font-size:12px;margin-top:6px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="jumlah" style="display:block;font-size:13px;font-weight:600;color:#5A5A4A;margin-bottom:8px;">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah"
                               value="{{ old('jumlah', 1) }}"
                               min="1" max="{{ $produk->stok }}"
                               required
                               style="width:100%;padding:12px 16px;border:1.5px solid #E0E0D8;border-radius:10px;font-size:14px;color:#1A1A18;background:white;box-sizing:border-box;">
                        <p style="font-size:12px;color:#9E9E8A;margin-top:6px;">Maks. {{ $produk->stok }} unit tersedia</p>
                        @error('jumlah')
                            <p style="color:#B91C1C;font-size:12px;margin-top:4px;">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            style="background:#1A1A18;color:white;padding:15px 24px;border-radius:12px;font-size:15px;font-weight:600;border:none;cursor:pointer;margin-top:8px;">
                        Konfirmasi Pesanan →
                    </button>
                </form>
            </div>

            {{-- Order Summary --}}
            <div style="background:white;border-radius:20px;padding:24px;border:1px solid #E8E8E4;">
                <h2 style="font-size:15px;font-weight:700;color:#1A1A18;margin-bottom:20px;">Ringkasan Pesanan</h2>
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                         alt="{{ $produk->nama_produk }}"
                         style="width:100%;height:160px;object-fit:cover;border-radius:12px;margin-bottom:16px;">
                @else
                    <div style="height:160px;background:#F0F0EC;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:40px;color:#C8C8BC;margin-bottom:16px;">📦</div>
                @endif
                <p style="font-weight:600;font-size:15px;color:#1A1A18;margin-bottom:4px;">{{ $produk->nama_produk }}</p>
                <p style="font-size:13px;color:#7A7A6A;margin-bottom:20px;line-height:1.5;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                <div style="border-top:1px solid #F0F0EC;padding-top:16px;">
                    <div style="display:flex;justify-content:space-between;font-size:14px;color:#5A5A4A;">
                        <span>Harga satuan</span>
                        <span style="font-weight:600;color:#1A1A18;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                    </div>
                    <p style="font-size:11px;color:#9E9E8A;margin-top:8px;">Total dihitung saat konfirmasi</p>
                </div>
            </div>
        </div>
    </main>

    <footer style="border-top:1px solid #E8E8E4;background:white;padding:24px;text-align:center;margin-top:48px;">
        <p style="font-size:13px;color:#9E9E8A;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:#1A1A18;font-weight:600;text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
