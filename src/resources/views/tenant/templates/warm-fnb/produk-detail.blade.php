<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} — {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;0,700;1,400;1,500&family=Source+Sans+3:wght@400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Source Sans 3', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
    </style>
</head>
<body style="background:#FBF7F0; color:#3D2B1F; min-height:100vh;">

    <header style="background:#FBF7F0; border-bottom:2px solid #E8D5B7; position:sticky; top:0; z-index:100;">
        <div style="max-width:1100px; margin:0 auto; padding:0 28px; height:72px; display:flex; align-items:center; gap:14px;">
            @if($profil?->logo)
                <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid #E8C87B;">
            @else
                <div style="width:40px;height:40px;border-radius:50%;background:#7C4C2A;display:flex;align-items:center;justify-content:center;font-family:'Lora',serif;font-size:16px;font-weight:700;color:#E8C87B;">
                    {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                </div>
            @endif
            <a href="{{ route('tenant.show', $tenant) }}" class="font-lora" style="font-size:18px;font-weight:700;color:#3D2B1F;text-decoration:none;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </a>
        </div>
    </header>

    <main style="max-width:1100px; margin:0 auto; padding:40px 28px;">

        <nav style="display:flex; align-items:center; gap:8px; font-size:13px; color:#8B6A52; margin-bottom:36px;">
            <a href="{{ route('tenant.show', $tenant) }}" style="color:#8B6A52; text-decoration:none;">Menu</a>
            <span>›</span>
            <span style="color:#3D2B1F; font-weight:500;">{{ $produk->nama_produk }}</span>
        </nav>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:52px; align-items:start;">

            {{-- Image --}}
            <div style="border-radius:24px; overflow:hidden; border:2px solid #E8D5B7; box-shadow:0 12px 40px rgba(139,90,43,0.1);">
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; aspect-ratio:4/3; object-fit:cover;">
                @else
                    <div style="aspect-ratio:4/3; background:linear-gradient(135deg,#F5EDDF,#EAD9C4); display:flex; align-items:center; justify-content:center; font-size:80px; color:#C4A882;">☕</div>
                @endif
            </div>

            <div style="padding-top:12px;">
                <p style="font-size:11px; font-weight:600; color:#8B6A52; text-transform:uppercase; letter-spacing:0.15em; margin-bottom:12px;">Menu Detail</p>
                <h1 class="font-lora" style="font-size:34px; font-weight:700; color:#3D2B1F; margin-bottom:16px; line-height:1.2; font-style:italic;">
                    {{ $produk->nama_produk }}
                </h1>

                <p class="font-lora" style="font-size:32px; font-weight:600; color:#7C4C2A; margin-bottom:16px;">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </p>

                @if($produk->stok > 0)
                    <div style="display:inline-flex; align-items:center; gap:6px; background:#FEF9EC; border:1px solid #E8C87B; padding:7px 16px; border-radius:100px; margin-bottom:24px;">
                        <span style="width:7px; height:7px; background:#7C4C2A; border-radius:50%;"></span>
                        <span style="font-size:13px; color:#7C4C2A; font-weight:600;">Tersedia · {{ $produk->stok }} porsi</span>
                    </div>
                @else
                    <div style="display:inline-flex; align-items:center; gap:6px; background:#FEF2F2; border:1px solid #FECACA; padding:7px 16px; border-radius:100px; margin-bottom:24px;">
                        <span style="font-size:13px; color:#B91C1C; font-weight:600;">Habis</span>
                    </div>
                @endif

                <p style="font-size:15px; color:#5A3920; line-height:1.8; margin-bottom:36px;">
                    {{ $produk->deskripsi }}
                </p>

                <div style="display:flex; flex-direction:column; gap:12px;">
                    @if($produk->stok > 0)
                        <a href="{{ route('tenant.checkout', [$tenant, $produk]) }}"
                           style="display:block; text-align:center; background:#7C4C2A; color:#E8C87B; padding:17px 28px; border-radius:12px; font-size:16px; font-weight:600; text-decoration:none; font-family:'Lora',serif; font-style:italic;">
                            Pesan Sekarang ✦
                        </a>
                    @else
                        <button disabled style="display:block; width:100%; background:#E8D5B7; color:#8B6A52; padding:17px 28px; border-radius:12px; font-size:16px; font-weight:600; border:none; cursor:not-allowed;">
                            Habis
                        </button>
                    @endif
                    <a href="{{ route('tenant.show', $tenant) }}"
                       style="display:block; text-align:center; border:1.5px solid #E8D5B7; color:#8B6A52; padding:15px 28px; border-radius:12px; font-size:14px; font-weight:500; text-decoration:none;">
                        ← Kembali ke Menu
                    </a>
                </div>
            </div>
        </div>
    </main>

    <footer style="background:#3D2B1F; padding:32px 28px; text-align:center; margin-top:60px;">
        <p style="font-size:13px; color:#5A3920;">
            Dibuat dengan <a href="{{ route('landing') }}" style="color:#E8C87B; text-decoration:none; font-weight:600;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
