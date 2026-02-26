<x-guest-layout>
    {{-- ================================================================
         MyLinx Landing Page — Placeholder for thesis demo
         Will be fully designed in a later phase.
         ================================================================ --}}

    <div class="min-h-screen bg-white">

        {{-- Navigation --}}
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
                <a href="{{ route('landing') }}" class="text-2xl font-bold text-gray-900">
                    MyLinx
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                           class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800">
                            Daftar Gratis
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

        {{-- Hero Section --}}
        <section class="px-6 py-24 text-center">
            <h1 class="mx-auto max-w-3xl text-5xl font-bold leading-tight tracking-tight text-gray-900">
                Bikin Website
                <span class="italic text-green-800">Semudah</span>
                Update Status.
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg text-gray-600">
                Platform web generator untuk UMKM Indonesia. Buat profil usaha, katalog produk,
                dan terima orderan — semua dalam hitungan menit.
            </p>
            <div class="mt-10 flex items-center justify-center gap-4">
                <a href="{{ route('register') }}"
                   class="rounded-lg bg-green-800 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                    Mulai Sekarang — Gratis
                </a>
                <a href="#features"
                   class="text-sm font-semibold text-gray-600 hover:text-gray-900">
                    Lihat Fitur &darr;
                </a>
            </div>
        </section>

        {{-- Features Section (placeholder) --}}
        <section id="features" class="border-t border-gray-100 bg-gray-50 px-6 py-20">
            <div class="mx-auto max-w-5xl">
                <h2 class="text-center text-3xl font-bold text-gray-900">
                    Bukan Sekadar Link-in-Bio Biasa
                </h2>
                <div class="mt-12 grid gap-8 md:grid-cols-3">
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <div class="text-2xl">🏪</div>
                        <h3 class="mt-3 font-semibold text-gray-900">Profil Usaha</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Tampilkan identitas brand, alamat, dan kontak bisnis Anda secara profesional.
                        </p>
                    </div>
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <div class="text-2xl">📦</div>
                        <h3 class="mt-3 font-semibold text-gray-900">Katalog Produk</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Upload produk, atur harga dan stok. Pelanggan bisa langsung order via WhatsApp.
                        </p>
                    </div>
                    <div class="rounded-xl bg-white p-6 shadow-sm">
                        <div class="text-2xl">📊</div>
                        <h3 class="mt-3 font-semibold text-gray-900">Kelola Pesanan</h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Terima dan pantau orderan masuk langsung dari dashboard Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-gray-100 bg-white px-6 py-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} MyLinx — Platform Web Generator UMKM Indonesia
        </footer>

    </div>
</x-guest-layout>
