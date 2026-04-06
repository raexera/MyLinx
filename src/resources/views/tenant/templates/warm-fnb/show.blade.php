<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }}</title>
    <meta name="description" content="{{ $profil?->deskripsi ? Str::limit($profil->deskripsi, 150) : 'Kunjungi toko kami' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Source+Sans+3:wght@300;400;500;600&display=swap');
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Source Sans 3', sans-serif; }
        .font-lora { font-family: 'Lora', serif; }
        .card { transition: all 0.3s ease; }
        .card:hover { transform: translateY(-6px); box-shadow: 0 24px 48px rgba(139,90,43,0.14); }
    </style>
</head>
<body style="background:#FBF7F0; color:#3D2B1F; min-height:100vh;">

    {{-- ── Topbar ─────────────────────────────────────────────── --}}
    <div style="background:#3D2B1F; padding:10px 28px; text-align:center;">
        <p style="color:#E8C87B; font-size:12px; font-weight:500; letter-spacing:0.08em;">
            🕒 Buka setiap hari · Hubungi kami untuk reservasi
            @if($profil?->no_hp)
                · <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}" style="color:#E8C87B; font-weight:600; text-decoration:none;">{{ $profil->no_hp }}</a>
            @endif
        </p>
    </div>

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <header style="background:#FBF7F0; border-bottom:2px solid #E8D5B7; position:sticky; top:0; z-index:100;">
        <div style="max-width:1100px; margin:0 auto; padding:0 28px; height:76px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:16px;">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}" alt="{{ $profil->nama_usaha }}" style="width:46px;height:46px;border-radius:50%;object-fit:cover;border:2px solid #E8C87B;">
                @else
                    <div style="width:46px;height:46px;border-radius:50%;background:#7C4C2A;display:flex;align-items:center;justify-content:center;font-family:'Lora',serif;font-size:18px;font-weight:700;color:#E8C87B;">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="font-lora" style="font-size:20px; font-weight:700; color:#3D2B1F; line-height:1;">
                        {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                    </h1>
                    @if($profil?->alamat)
                        <p style="font-size:11px; color:#8B6A52; margin-top:2px;">{{ Str::limit($profil->alamat, 50) }}</p>
                    @endif
                </div>
            </div>
            @if($profil?->no_hp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}"
                   target="_blank"
                   style="background:#7C4C2A; color:#E8C87B; padding:11px 22px; border-radius:100px; font-size:13px; font-weight:600; text-decoration:none;">
                    📞 Pesan Sekarang
                </a>
            @endif
        </div>
    </header>

    {{-- ── Hero ─────────────────────────────────────────────────── --}}
    <section style="background:linear-gradient(135deg, #3D2B1F 0%, #5A3920 50%, #7C4C2A 100%); padding:80px 28px; text-align:center; position:relative; overflow:hidden;">
        <div style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><text y=\".9em\" font-size=\"90\" opacity=\"0.03\">☕</text></svg>') repeat;opacity:0.04;"></div>
        <div style="max-width:700px; margin:0 auto; position:relative;">
            <p style="color:#E8C87B; font-size:11px; font-weight:600; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:20px;">
                ✦ Warung & Toko Kami ✦
            </p>
            <h2 class="font-lora" style="color:white; font-size:clamp(36px,5vw,60px); font-weight:700; line-height:1.15; margin-bottom:16px; font-style:italic;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </h2>
            @if($profil?->deskripsi)
                <p style="color:#C4A882; font-size:16px; line-height:1.75; max-width:520px; margin:0 auto 28px;">
                    {{ Str::limit($profil->deskripsi, 200) }}
                </p>
            @endif
            <div style="width:60px; height:2px; background:#E8C87B; margin:0 auto;"></div>
        </div>
    </section>

    @if(session('success'))
        <div style="background:#F0FDF4;border-bottom:1px solid #BBF7D0;padding:14px 28px;text-align:center;font-size:14px;color:#166534;font-weight:600;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- ── Products ─────────────────────────────────────────────── --}}
    <main style="max-width:1100px; margin:0 auto; padding:64px 28px;">

        @if($produks->isEmpty())
            <div style="text-align:center; padding:80px 24px; border:2px dashed #E8D5B7; border-radius:16px; background:white;">
                <p style="font-size:48px; margin-bottom:16px;">☕</p>
                <p class="font-lora" style="color:#8B6A52; font-size:16px; font-style:italic;">Belum ada menu yang tersedia saat ini.</p>
            </div>
        @else
            <div style="text-align:center; margin-bottom:48px;">
                <p style="color:#8B6A52; font-size:11px; font-weight:600; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:12px;">— Menu Kami —</p>
                <h2 class="font-lora" style="font-size:36px; font-weight:700; color:#3D2B1F;">Pilihan Produk</h2>
            </div>
            <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:28px;">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}" style="text-decoration:none; color:inherit;">
                        <div class="card" style="background:white; border-radius:20px; overflow:hidden; border:1px solid #E8D5B7; box-shadow:0 4px 16px rgba(139,90,43,0.06);">
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" style="width:100%; height:220px; object-fit:cover;">
                            @else
                                <div style="height:220px; background:linear-gradient(135deg,#F5EDDF,#EAD9C4); display:flex; align-items:center; justify-content:center; font-size:56px; color:#C4A882;">☕</div>
                            @endif
                            <div style="padding:20px;">
                                <h3 class="font-lora" style="font-size:18px; font-weight:600; color:#3D2B1F; margin-bottom:8px;">{{ $produk->nama_produk }}</h3>
                                <p style="font-size:13px; color:#8B6A52; margin-bottom:16px; line-height:1.6;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                                <div style="display:flex; align-items:center; justify-content:space-between;">
                                    <span class="font-lora" style="font-size:20px; font-weight:700; color:#7C4C2A;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size:11px; color:#8B6A52; background:#FBF7F0; border:1px solid #E8D5B7; padding:4px 12px; border-radius:100px; font-weight:600;">
                                        Stok {{ $produk->stok }}
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
                <div style="text-align:center; margin-bottom:40px;">
                    <p style="color:#8B6A52; font-size:11px; font-weight:600; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:12px;">— Galeri Kami —</p>
                    <h2 class="font-lora" style="font-size:32px; font-weight:700; color:#3D2B1F;">Portofolio</h2>
                </div>
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:24px;">
                    @foreach($portofolios as $porto)
                        <div style="background:white; border-radius:16px; overflow:hidden; border:1px solid #E8D5B7; box-shadow:0 4px 16px rgba(139,90,43,0.06);">
                            @if($porto->gambar)
                                <img src="{{ asset('storage/' . $porto->gambar) }}" alt="{{ $porto->judul }}" style="width:100%; height:200px; object-fit:cover;">
                            @endif
                            <div style="padding:20px;">
                                <h3 class="font-lora" style="font-size:17px; font-weight:600; color:#3D2B1F; margin-bottom:8px;">{{ $porto->judul }}</h3>
                                <p style="font-size:13px; color:#8B6A52; line-height:1.6;">{{ Str::limit($porto->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    {{-- ── Footer ─────────────────────────────────────────────── --}}
    <footer style="background:#3D2B1F; padding:40px 28px; text-align:center; margin-top:48px;">
        <p class="font-lora" style="font-size:18px; font-weight:600; color:#E8C87B; margin-bottom:8px; font-style:italic;">
            {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
        </p>
        @if($profil?->alamat)
            <p style="font-size:13px; color:#8B6A52; margin-bottom:16px;">{{ $profil->alamat }}</p>
        @endif
        <p style="font-size:12px; color:#5A3920;">
            &copy; {{ date('Y') }} · Dibuat dengan <a href="{{ route('landing') }}" style="color:#E8C87B; text-decoration:none; font-weight:600;">MyLinx</a>
        </p>
    </footer>
</body>
</html>
