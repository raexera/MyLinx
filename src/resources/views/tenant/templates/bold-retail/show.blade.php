<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    <meta name="description" content="{{ $profil?->deskripsi ? Str::limit($profil->deskripsi, 150) : 'Kunjungi toko kami' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,600;0,700;0,800;0,900;1,400&display=swap');
        * { font-family: 'Barlow', sans-serif; margin:0; padding:0; box-sizing:border-box; }
        .hero-bg { background: linear-gradient(135deg, #0F0F0F 0%, #1C1C1C 100%); }
        .card-hover { transition: all 0.2s; }
        .card-hover:hover { transform: scale(1.02); }
        .tag { display:inline-block; background:#F59E0B; color:#1C1C1C; font-size:10px; font-weight:800; letter-spacing:0.12em; text-transform:uppercase; padding:4px 10px; border-radius:4px; }
    </style>
</head>
<body style="background:#111111; color:white; min-height:100vh;">

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <header style="background:#0A0A0A; border-bottom:2px solid #F59E0B; position:sticky; top:0; z-index:100;">
        <div style="max-width:1200px; margin:0 auto; padding:0 28px; height:70px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:14px;">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:38px;height:38px;border-radius:6px;object-fit:cover;border:2px solid #F59E0B;">
                @else
                    <div style="width:38px;height:38px;border-radius:6px;background:#F59E0B;display:flex;align-items:center;justify-content:center;font-weight:900;font-size:16px;color:#0A0A0A;">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <span style="font-weight:900; font-size:20px; letter-spacing:0.04em; text-transform:uppercase;">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </span>
            </div>
            @if($profil?->no_hp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}"
                   target="_blank"
                   style="background:#F59E0B;color:#0A0A0A;padding:10px 20px;border-radius:6px;font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:0.06em;text-decoration:none;">
                    WhatsApp ↗
                </a>
            @endif
        </div>
    </header>

    {{-- ── Hero ─────────────────────────────────────────────────── --}}
    <section class="hero-bg" style="padding:80px 28px; border-bottom:1px solid #2A2A2A;">
        <div style="max-width:800px; margin:0 auto;">
            <span class="tag" style="margin-bottom:20px; display:inline-block;">Toko Online 🛍️</span>
            <h1 style="font-size:clamp(40px,6vw,72px); font-weight:900; line-height:1.05; text-transform:uppercase; letter-spacing:-0.01em; margin-bottom:16px;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </h1>
            @if($profil?->deskripsi)
                <p style="color:#A0A0A0; font-size:17px; line-height:1.65; max-width:560px; margin-bottom:24px;">
                    {{ Str::limit($profil->deskripsi, 200) }}
                </p>
            @endif
            @if($profil?->alamat)
                <p style="color:#F59E0B; font-size:14px; font-weight:600;">📍 {{ $profil->alamat }}</p>
            @endif
        </div>
    </section>

    {{-- ── Flash ──────────────────────────────────────────────── --}}
    @if(session('success'))
        <div style="background:#166534;padding:14px 28px;text-align:center;font-size:14px;color:#BBF7D0;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- ── Products ─────────────────────────────────────────────── --}}
    <main style="max-width:1200px; margin:0 auto; padding:60px 28px;">
        @if($produks->isEmpty())
            <div style="text-align:center; padding:80px 24px; border:2px dashed #2A2A2A; border-radius:12px;">
                <p style="font-size:48px; margin-bottom:16px;">🛍️</p>
                <p style="color:#666; font-size:16px; font-weight:600; text-transform:uppercase; letter-spacing:0.08em;">Belum Ada Produk</p>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:36px; border-bottom:2px solid #F59E0B; padding-bottom:20px;">
                <h2 style="font-size:28px; font-weight:900; text-transform:uppercase; letter-spacing:0.04em;">Produk Kami</h2>
                <span style="color:#666; font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:0.1em;">{{ $produks->count() }} Items</span>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(270px,1fr)); gap:20px;">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="text-decoration:none; color:inherit;">
                        <div class="card-hover" style="background:#1A1A1A; border-radius:10px; overflow:hidden; border:1px solid #2A2A2A; cursor:pointer;">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:220px; object-fit:cover;">
                            @else
                                <div style="height:220px; background:#222; display:flex; align-items:center; justify-content:center; font-size:52px; color:#444;">📦</div>
                            @endif
                            <div style="padding:20px;">
                                <h3 style="font-size:16px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:8px; color:white;">
                                    {{ $produk->nama_produk }}
                                </h3>
                                <p style="font-size:13px; color:#888; margin-bottom:16px; line-height:1.5;">
                                    {{ Str::limit($produk->deskripsi, 70) }}
                                </p>
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span style="font-size:20px; font-weight:800; color:#F59E0B;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="tag">{{ $produk->stok }} tersisa</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Portfolio --}}
        @if($portofolios->isNotEmpty())
            <section style="margin-top:80px;">
                <div style="border-bottom:2px solid #F59E0B; padding-bottom:20px; margin-bottom:36px;">
                    <h2 style="font-size:28px; font-weight:900; text-transform:uppercase; letter-spacing:0.04em;">Portofolio</h2>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:20px;">
                    @foreach($portofolios as $porto)
                        <div style="background:#1A1A1A; border-radius:10px; overflow:hidden; border:1px solid #2A2A2A;">
                            @if($porto->gambar)
                                <img src="{{ asset('storage/' . $porto->gambar) }}" alt="{{ $porto->judul }}" style="width:100%; height:200px; object-fit:cover;">
                            @endif
                            <div style="padding:20px;">
                                <h3 style="font-size:15px; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; color:white; margin-bottom:8px;">{{ $porto->judul }}</h3>
                                <p style="font-size:13px; color:#888;">{{ Str::limit($porto->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer style="border-top:2px solid #F59E0B; background:#0A0A0A; padding:32px 28px; text-align:center; margin-top:48px;">
        <p style="font-size:13px; color:#666; font-weight:600; text-transform:uppercase; letter-spacing:0.08em;">
            &copy; {{ date('Y') }} {{ $profil?->nama_usaha ?? $tenant->nama_tenant }} · Powered by
            <a href="{{ route('landing') }}" style="color:#F59E0B; text-decoration:none;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
