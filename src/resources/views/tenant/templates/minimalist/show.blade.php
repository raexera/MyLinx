<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profil?->nama_usaha ?? $tenant->nama_tenant }} — MyLinx</title>
    <meta name="description" content="{{ $profil?->deskripsi ? Str::limit($profil->deskripsi, 150) : 'Kunjungi toko kami di MyLinx' }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap');
        * { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
        .product-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        .btn-primary { transition: background 0.2s, transform 0.15s; }
        .btn-primary:hover { transform: scale(1.02); }
    </style>
</head>
<body class="min-h-screen antialiased" style="background:#F9F9F7; color:#1A1A18;">

    {{-- ── Navbar ─────────────────────────────────────────────── --}}
    <header style="background:white; border-bottom:1px solid #E8E8E4;">
        <div style="max-width:1100px; margin:0 auto; padding:0 24px; height:72px; display:flex; align-items:center; justify-content:space-between;">
            <div style="display:flex; align-items:center; gap:14px;">
                @if($profil?->logo)
                    <img src="{{ asset('storage/' . $profil->logo) }}"
                         alt="{{ $profil->nama_usaha }}"
                         style="width:42px;height:42px;border-radius:50%;object-fit:cover;">
                @else
                    <div style="width:42px;height:42px;border-radius:50%;background:#1A1A18;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:16px;color:white;">
                        {{ strtoupper(substr($tenant->nama_tenant, 0, 1)) }}
                    </div>
                @endif
                <span style="font-weight:700;font-size:18px;color:#1A1A18;">
                    {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
                </span>
            </div>
            @if($profil?->no_hp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $profil->no_hp) }}"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:#25D366;color:white;border-radius:100px;font-size:13px;font-weight:600;text-decoration:none;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Hubungi Kami
                </a>
            @endif
        </div>
    </header>

    {{-- ── Hero Banner ──────────────────────────────────────────── --}}
    <section style="background:#1A1A18;padding:64px 24px;text-align:center;">
        <div style="max-width:700px;margin:0 auto;">
            <p style="color:#9E9E8A;font-size:11px;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:16px;">
                🌿 Toko Online
            </p>
            <h1 class="font-display" style="color:white;font-size:clamp(32px,5vw,56px);font-weight:700;line-height:1.15;margin-bottom:16px;">
                {{ $profil?->nama_usaha ?? $tenant->nama_tenant }}
            </h1>
            @if($profil?->deskripsi)
                <p style="color:#B0B09A;font-size:16px;line-height:1.7;max-width:520px;margin:0 auto 28px;">
                    {{ Str::limit($profil->deskripsi, 180) }}
                </p>
            @endif
            @if($profil?->alamat)
                <p style="color:#6E6E60;font-size:13px;">📍 {{ $profil->alamat }}</p>
            @endif
        </div>
    </section>

    {{-- ── Flash Messages ───────────────────────────────────────── --}}
    @if(session('success'))
        <div style="background:#ECFDF5;border-bottom:1px solid #A7F3D0;padding:12px 24px;text-align:center;font-size:14px;color:#065F46;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- ── Product Catalog ──────────────────────────────────────── --}}
    <main style="max-width:1100px;margin:0 auto;padding:56px 24px;">
        @if($produks->isEmpty())
            <div style="text-align:center;padding:80px 24px;border:2px dashed #E0E0D8;border-radius:16px;background:white;">
                <p style="font-size:40px;margin-bottom:12px;">🛍️</p>
                <p style="color:#9E9E8A;font-size:15px;">Belum ada produk yang tersedia saat ini.</p>
            </div>
        @else
            <div style="display:flex;align-items:baseline;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
                <h2 class="font-display" style="font-size:28px;font-weight:700;color:#1A1A18;">Produk Kami</h2>
                <span style="font-size:13px;color:#9E9E8A;">{{ $produks->count() }} produk tersedia</span>
            </div>
            <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       style="text-decoration:none;color:inherit;">
                        <div class="product-card" style="background:white;border-radius:16px;overflow:hidden;border:1px solid #E8E8E4;">
                            {{-- Product Image --}}
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     style="width:100%;height:200px;object-fit:cover;">
                            @else
                                <div style="height:200px;background:#F0F0EC;display:flex;align-items:center;justify-content:center;font-size:48px;color:#C8C8BC;">
                                    📦
                                </div>
                            @endif
                            {{-- Info --}}
                            <div style="padding:18px;">
                                <h3 style="font-weight:600;font-size:15px;color:#1A1A18;margin-bottom:6px;">
                                    {{ $produk->nama_produk }}
                                </h3>
                                <p style="font-size:13px;color:#7A7A6A;margin-bottom:12px;line-height:1.5;">
                                    {{ Str::limit($produk->deskripsi, 75) }}
                                </p>
                                <div style="display:flex;align-items:center;justify-content:space-between;">
                                    <span style="font-weight:700;font-size:16px;color:#1A1A18;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span style="font-size:11px;color:#9E9E8A;background:#F5F5F0;padding:4px 10px;border-radius:100px;">
                                        Stok {{ $produk->stok }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- ── Portfolio Section ──────────────────────────────── --}}
        @if($portofolios->isNotEmpty())
            <section style="margin-top:80px;">
                <h2 class="font-display" style="font-size:28px;font-weight:700;color:#1A1A18;margin-bottom:32px;">Portofolio</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:20px;">
                    @foreach($portofolios as $porto)
                        <div style="background:white;border-radius:16px;overflow:hidden;border:1px solid #E8E8E4;">
                            @if($porto->gambar)
                                <img src="{{ asset('storage/' . $porto->gambar) }}"
                                     alt="{{ $porto->judul }}"
                                     style="width:100%;height:200px;object-fit:cover;">
                            @endif
                            <div style="padding:18px;">
                                <h3 style="font-weight:600;font-size:15px;color:#1A1A18;margin-bottom:6px;">{{ $porto->judul }}</h3>
                                <p style="font-size:13px;color:#7A7A6A;line-height:1.5;">{{ Str::limit($porto->deskripsi, 100) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    </main>

    {{-- ── Footer ───────────────────────────────────────────────── --}}
    <footer style="border-top:1px solid #E8E8E4;background:white;padding:28px 24px;text-align:center;margin-top:48px;">
        <p style="font-size:13px;color:#9E9E8A;">
            &copy; {{ date('Y') }} {{ $profil?->nama_usaha ?? $tenant->nama_tenant }} · Dibuat dengan
            <a href="{{ route('landing') }}" style="color:#1A1A18;font-weight:600;text-decoration:none;">MyLinx</a>
        </p>
    </footer>

</body>
</html>
