@if($produks->isEmpty())
    <section class="py-12 text-center">
        <div class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-[var(--accent-soft)] text-4xl mb-4 text-[var(--accent)] opacity-70">📦</div>
        <p class="text-sm text-gray-500 font-medium">Belum ada produk tersedia.</p>
    </section>
@else
    <section>
        <div class="flex items-center gap-3 mb-6">
            <h2 class="text-2xl font-serif text-gray-900">Produk Kami</h2>
            <div class="h-px flex-1 bg-gray-200"></div>
        </div>

        @if(($custom['product_layout'] ?? 'grid') === 'grid')
            {{-- Grid layout --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       class="group block bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:border-[var(--accent)] hover:ring-1 hover:ring-[var(--accent)] transition-all">
                        @if($produk->gambar)
                            <div class="aspect-square overflow-hidden bg-gray-50">
                                <img src="{{ asset('storage/' . $produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @else
                            <div class="aspect-square flex items-center justify-center bg-[var(--accent-soft)] text-4xl text-[var(--accent)] opacity-50">📦</div>
                        @endif
                        <div class="p-4">
                            <h3 class="font-medium text-sm text-gray-900 line-clamp-2 group-hover:text-[var(--accent)] transition-colors">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1.5 text-[var(--accent)] font-bold text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            @if($produk->stok <= 5)
                                <p class="text-[10px] text-amber-600 font-medium mt-1">Stok terbatas: {{ $produk->stok }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            {{-- List layout --}}
            <div class="space-y-3">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       class="group flex gap-4 bg-white rounded-2xl p-3 border border-gray-200 shadow-sm hover:border-[var(--accent)] hover:ring-1 hover:ring-[var(--accent)] transition-all">
                        @if($produk->gambar)
                            <div class="h-24 w-24 rounded-xl overflow-hidden bg-gray-50 flex-shrink-0">
                                <img src="{{ asset('storage/' . $produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </div>
                        @else
                            <div class="h-24 w-24 rounded-xl bg-[var(--accent-soft)] flex items-center justify-center text-2xl text-[var(--accent)] opacity-50 flex-shrink-0">📦</div>
                        @endif
                        <div class="flex flex-col justify-center flex-1 min-w-0 pr-2">
                            <h3 class="font-medium text-gray-900 group-hover:text-[var(--accent)] transition-colors line-clamp-1">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ $produk->deskripsi }}</p>
                            <div class="mt-2.5 flex items-center justify-between">
                                <p class="text-[var(--accent)] font-bold text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                <span class="text-[11px] font-medium text-gray-400 bg-gray-50 px-2 py-0.5 rounded-md">Stok: {{ $produk->stok }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endif
