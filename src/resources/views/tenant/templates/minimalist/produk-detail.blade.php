<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="min-h-screen antialiased" style="background:#F9F9F7; color:#1A1A18;">

    <header style="background:white; border-bottom:1px solid #E8E8E4;">
        <div style="max-width:1100px; margin:0 auto; padding:0 24px; height:72px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:36px;height:36px;border-radius:50%;object-fit:cover;">
            @else
                <div style="width:36px;height:36px;border-radius:50%;background:#1A1A18;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;color:white;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" style="font-weight:700;font-size:17px;color:#1A1A18;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:1100px;margin:0 auto;padding:48px 24px;">

        {{-- Breadcrumb --}}
        <nav style="display:flex;align-items:center;gap:8px;font-size:13px;color:#9E9E8A;margin-bottom:40px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#9E9E8A;text-decoration:none;hover:color:#1A1A18;">Toko</a>
            <span>›</span>
            <span style="color:#1A1A18;">{{ $produk->nama_produk }}</span>
        </nav>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:start;" class="md:grid-cols-2">

            {{-- Product Image --}}
            <div style="border-radius:20px;overflow:hidden;background:#F0F0EC;">
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}"
                         alt="{{ $produk->nama_produk }}"
                         style="width:100%;aspect-ratio:4/3;object-fit:cover;">
                @else
                    <div style="aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;font-size:80px;color:#C8C8BC;">📦</div>
                @endif
            </div>

            {{-- Product Info --}}
            <div style="padding-top:8px;">
                <h1 class="font-display" style="font-size:32px;font-weight:700;color:#1A1A18;margin-bottom:12px;line-height:1.2;">
                    {{ $produk->nama_produk }}
                </h1>

                <p style="font-size:32px;font-weight:700;color:#1A1A18;margin-bottom:16px;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                @if($produk->stok > 0)
                    <span style="display:inline-block;background:#F0F5F1;color:#2A6041;font-size:12px;font-weight:600;padding:5px 14px;border-radius:100px;margin-bottom:24px;">
                        ✓ Tersedia · Stok {{ $produk->stok }}
                    </span>
                @else
                    <span style="display:inline-block;background:#FEF2F2;color:#B91C1C;font-size:12px;font-weight:600;padding:5px 14px;border-radius:100px;margin-bottom:24px;">
                        Stok Habis
                    </span>
                @endif

                <p style="font-size:15px;color:#5A5A4A;line-height:1.75;margin-bottom:32px;">
                    {{ $produk->deskripsi }}
                </p>

                <div style="display:flex;flex-direction:column;gap:12px;">
                    @if($produk->stok > 0)
                        <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                           style="display:block;text-align:center;background:#1A1A18;color:white;padding:16px 24px;border-radius:12px;font-weight:600;font-size:15px;text-decoration:none;letter-spacing:0.01em;">
                            Beli Sekarang
                        </a>
                    @else
                        <button disabled style="display:block;width:100%;background:#E0E0D8;color:#9E9E8A;padding:16px 24px;border-radius:12px;font-weight:600;font-size:15px;border:none;cursor:not-allowed;">
                            Stok Habis
                        </button>
                    @endif
                    <a href="{{ route('tenant.show', $tenant) }}"
                       style="display:block;text-align:center;border:1.5px solid #E0E0D8;color:#5A5A4A;padding:14px 24px;border-radius:12px;font-weight:500;font-size:14px;text-decoration:none;">
                        ← Kembali ke Toko
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer style="border-top:1px solid #E8E8E4;background:white;padding:28px 24px;text-align:center;margin-top:48px;">
        <p style="font-size:13px;color:#9E9E8A;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:#1A1A18;font-weight:600;text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
