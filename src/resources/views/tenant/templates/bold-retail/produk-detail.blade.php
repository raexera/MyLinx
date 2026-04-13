<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700;800;900&display=swap');
        * { font-family: 'Barlow', sans-serif; margin:0; padding:0; box-sizing:border-box; }
        .tag { display:inline-block; background:#F59E0B; color:#0A0A0A; font-size:10px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; padding:4px 10px; border-radius:4px; }
    </style>
</head>
<body style="background:#111111; color:white; min-height:100vh;">

    <header style="background:#0A0A0A; border-bottom:2px solid #F59E0B; position:sticky; top:0; z-index:100;">
        <div style="max-width:1100px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:36px;height:36px;border-radius:6px;object-fit:cover;border:2px solid #F59E0B;">
            @else
                <div style="width:36px;height:36px;border-radius:6px;background:#F59E0B;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:15px;color:#0A0A0A;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" style="font-weight:900;font-size:18px;text-transform:uppercase;letter-spacing:0.05em;color:white;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:1100px; margin:0 auto; padding:48px 28px;">

        <nav style="display:flex; align-items:center; gap:10px; font-size:12px; color:#666; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:40px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#F59E0B; text-decoration:none;">Toko</a>
            <span style="color:#333;">›</span>
            <span style="color:#888;">{{ $produk->nama_produk }}</span>
        </nav>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:48px; align-items:start;">
            {{-- Image --}}
            <div style="background:#1A1A1A; border-radius:12px; overflow:hidden; border:1px solid #2A2A2A;">
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; aspect-ratio:3/4; object-fit:cover;">
                @else
                    <div style="aspect-ratio:3/4; display:flex; align-items:center; justify-content:center; font-size:80px; color:#333;">📦</div>
                @endif
            </div>

            {{-- Info --}}
            <div style="padding-top:12px;">
                <span class="tag" style="margin-bottom:16px;">Retail Store</span>
                <h1 style="font-size:36px; font-weight:900; text-transform:uppercase; letter-spacing:0.02em; line-height:1.1; margin-bottom:16px;">
                    {{ $produk->nama_produk }}
                </h1>
                <p style="font-size:40px; font-weight:900; color:#F59E0B; margin-bottom:16px;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                @if($produk->stok > 0)
                    <p style="color:#4ADE80; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:24px;">
                        ● In Stock — {{ $produk->stok }} unit
                    </p>
                @else
                    <p style="color:#F87171; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; margin-bottom:24px;">
                        ● Out of Stock
                    </p>
                @endif

                <p style="color:#A0A0A0; font-size:15px; line-height:1.7; margin-bottom:36px;">
                    {{ $produk->deskripsi }}
                </p>

                <div style="display:flex; flex-direction:column; gap:14px;">
                    @if($produk->stok > 0)
                        <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                           style="display:block; text-align:center; background:#F59E0B; color:#0A0A0A; padding:18px 28px; border-radius:8px; font-size:16px; font-weight:900; text-transform:uppercase; letter-spacing:0.06em; text-decoration:none;">
                            Beli Sekarang ↗
                        </a>
                    @else
                        <button disabled style="display:block; width:100%; background:#333; color:#666; padding:18px 28px; border-radius:8px; font-size:16px; font-weight:900; text-transform:uppercase; border:none; cursor:not-allowed;">
                            Sold Out
                        </button>
                    @endif
                    <a href="{{ route('tenant.show', $tenant) }}"
                       style="display:block; text-align:center; border:2px solid #333; color:#888; padding:16px 28px; border-radius:8px; font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; text-decoration:none;">
                        ← Back to Store
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer style="border-top:2px solid #F59E0B; background:#0A0A0A; padding:24px 28px; text-align:center; margin-top:60px;">
        <p style="font-size:12px; color:#555; font-weight:700; text-transform:uppercase; letter-spacing:0.08em;">
            Powered by <a href="{{ route('landing') }}" style="color:#F59E0B; text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
