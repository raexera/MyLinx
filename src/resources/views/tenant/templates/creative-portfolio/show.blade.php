<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    <meta name="description" content="{{ $profil?->deskripsi ? Str::limit($profil->deskripsi, 150) : 'Kunjungi portfolio kami' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'DM Sans', sans-serif; }
        .font-serif { font-family: 'DM Serif Display', serif; }
        .glass { backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); }
        .card-hover { transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94); }
        .card-hover:hover { transform: translateY(-8px) scale(1.01); }
        .gradient-text { background: linear-gradient(135deg, #E879F9, #818CF8, #38BDF8); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip:text; }
    </style>
</head>
<body style="background:#0A0A15; color:white; min-height:100vh; overflow-x:hidden;">

    {{-- Background gradient orbs --}}
    <div style="position:fixed; top:-20%; left:-10%; width:600px; height:600px; background:radial-gradient(circle, rgba(129,140,248,0.12) 0%, transparent 70%); pointer-events:none; z-index:0;"></div>
    <div style="position:fixed; bottom:-20%; right:-10%; width:500px; height:500px; background:radial-gradient(circle, rgba(232,121,249,0.1) 0%, transparent 70%); pointer-events:none; z-index:0;"></div>

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <header class="glass" style="background:rgba(10,10,21,0.8); border-bottom:1px solid rgba(255,255,255,0.08); position:sticky; top:0; z-index:100;">
        <div style="max-width:1200px; margin:0 auto; padding:0 32px; height:72px; display:flex; align-items:center; justify-content:space-between; position:relative;">
            <div style="display:flex; align-items:center; gap:14px;">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid rgba(129,140,248,0.5);">
                @else
                    <div style="width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#818CF8,#E879F9);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:white;">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <span class="font-serif" style="font-size:19px; color:white;">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </span>
            </div>
            @if($profil?->no_hp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}"
                   target="_blank"
                   style="background:linear-gradient(135deg,#818CF8,#E879F9); color:white; padding:10px 22px; border-radius:100px; font-size:13px; font-weight:500; text-decoration:none;">
                    Hubungi ↗
                </a>
            @endif
        </div>
    </header>

    {{-- ── Hero ─────────────────────────────────────────────────── --}}
    <section style="padding:100px 32px 80px; text-align:center; position:relative;">
        <div style="max-width:800px; margin:0 auto;">
            <p style="color:rgba(232,121,249,0.8); font-size:11px; font-weight:500; letter-spacing:0.25em; text-transform:uppercase; margin-bottom:20px;">
                — Creative Studio —
            </p>
            <h1 class="font-serif gradient-text" style="font-size:clamp(40px,6vw,72px); line-height:1.1; margin-bottom:20px;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </h1>
            @if($profil?->deskripsi)
                <p style="color:rgba(255,255,255,0.55); font-size:17px; line-height:1.75; max-width:540px; margin:0 auto 32px; font-weight:300;">
                    {{ Str::limit($profil->deskripsi, 200) }}
                </p>
            @endif
            @if($profil?->alamat)
                <p style="color:rgba(255,255,255,0.3); font-size:13px; font-weight:400;">📍 {{ $profil->alamat }}</p>
            @endif
        </div>
    </section>

    @if(session('success'))
        <div style="background:rgba(74,222,128,0.1); border:1px solid rgba(74,222,128,0.3); padding:14px 32px; text-align:center; font-size:14px; color:#4ADE80; font-weight:500; margin-bottom:8px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- ── Products ─────────────────────────────────────────────── --}}
    <main style="max-width:1200px; margin:0 auto; padding:0 32px 80px; position:relative;">

        @if($produks->isEmpty())
            <div style="text-align:center; padding:80px 32px; border:1px dashed rgba(255,255,255,0.1); border-radius:20px;">
                <p style="font-size:48px; margin-bottom:16px;">✨</p>
                <p style="color:rgba(255,255,255,0.3); font-size:16px; font-weight:300;">Belum ada produk yang tersedia.</p>
            </div>
        @else
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:40px; padding-bottom:24px; border-bottom:1px solid rgba(255,255,255,0.06);">
                <h2 class="font-serif" style="font-size:32px; color:white;">Produk & Layanan</h2>
                <span style="color:rgba(255,255,255,0.3); font-size:13px; font-weight:300;">{{ $produks->count() }} item</span>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(300px,1fr)); gap:24px;">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="text-decoration:none; color:inherit;">
                        <div class="card-hover glass" style="background:rgba(255,255,255,0.04); border-radius:20px; overflow:hidden; border:1px solid rgba(255,255,255,0.08); cursor:pointer;">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:220px; object-fit:cover; opacity:0.9;">
                            @else
                                <div style="height:220px; background:linear-gradient(135deg,rgba(129,140,248,0.15),rgba(232,121,249,0.1)); display:flex; align-items:center; justify-content:center; font-size:56px; color:rgba(255,255,255,0.2);">✨</div>
                            @endif
                            <div style="padding:22px;">
                                <h3 class="font-serif" style="font-size:20px; color:white; margin-bottom:8px;">{{ $produk->nama_produk }}</h3>
                                <p style="font-size:13px; color:rgba(255,255,255,0.45); margin-bottom:16px; line-height:1.6; font-weight:300;">
                                    {{ Str::limit($produk->deskripsi, 80) }}
                                </p>
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span class="gradient-text font-serif" style="font-size:20px; font-weight:400;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size:11px; color:rgba(129,140,248,0.7); background:rgba(129,140,248,0.1); border:1px solid rgba(129,140,248,0.2); padding:4px 12px; border-radius:100px; font-weight:500;">
                                        {{ $produk->stok }} tersisa
                                    </span>
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
                <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:40px; padding-bottom:24px; border-bottom:1px solid rgba(255,255,255,0.06);">
                    <h2 class="font-serif" style="font-size:32px; color:white;">Portfolio</h2>
                </div>
                <div style="columns:2; gap:20px;">
                    @foreach($portofolios as $porto)
                        <div class="glass" style="background:rgba(255,255,255,0.04); border-radius:16px; overflow:hidden; border:1px solid rgba(255,255,255,0.08); margin-bottom:20px; break-inside:avoid;">
                            @if($porto->gambar)
                                <img src="{{ asset('storage/' . $porto->gambar) }}" alt="{{ $porto->judul }}" style="width:100%; object-fit:cover;">
                            @endif
                            <div style="padding:20px;">
                                <h3 class="font-serif" style="font-size:18px; color:white; margin-bottom:6px;">{{ $porto->judul }}</h3>
                                <p style="font-size:13px; color:rgba(255,255,255,0.4); line-height:1.6; font-weight:300;">{{ Str::limit($porto->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer class="glass" style="border-top:1px solid rgba(255,255,255,0.06); padding:32px; text-align:center;">
        <p style="font-size:13px; color:rgba(255,255,255,0.25); font-weight:300;">
            &copy; {{ date('Y') }} {{ $profil?->nama_usaha ?? $tenant->nama_tenant }} · Dibuat dengan
            <a href="{{ route('landing') }}" style="color:rgba(129,140,248,0.8); text-decoration:none; font-weight:500;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
