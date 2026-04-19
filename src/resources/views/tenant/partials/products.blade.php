@if($produks->isEmpty())
    <section class="py-12 text-center">
        <div class="text-4xl mb-2">📦</div>
        <p class="text-sm text-[var(--text-muted)]">Belum ada produk tersedia.</p>
    </section>
@else
    <section>
        <h2 class="text-2xl font-serif text-[var(--text-main)] mb-6">Produk Kami</h2>

        @if($custom['product_layout'] === 'grid')
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       class="block bg-[var(--card-bg)] rounded-2xl overflow-hidden border border-[var(--border-color)] shadow-sm hover:border-[var(--accent)] hover:ring-1 hover:ring-[var(--accent)] transition-all">
                        @if($produk->gambar)
                            <div class="aspect-square overflow-hidden bg-[var(--input-bg)]">
                                <img src="{{ asset('storage/' . $produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @else
                            <div class="aspect-square flex items-center justify-center bg-[var(--input-bg)] text-4xl text-[var(--text-muted)] opacity-50">📦</div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-[var(--text-main)] line-clamp-2 hover:text-[var(--accent)] transition-colors">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-[var(--accent)] font-bold text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            @if($produk->stok <= 5)
                                <p class="text-[10px] text-amber-600 font-bold mt-1 bg-amber-50 inline-block px-1.5 py-0.5 rounded">Stok terbatas: {{ $produk->stok }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            
            <div class="space-y-3">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       class="flex gap-4 bg-[var(--card-bg)] rounded-2xl p-3 border border-[var(--border-color)] shadow-sm hover:border-[var(--accent)] hover:ring-1 hover:ring-[var(--accent)] transition-all">
                        @if($produk->gambar)
                            <div class="h-20 w-20 rounded-lg overflow-hidden bg-[var(--input-bg)] flex-shrink-0">
                                <img src="{{ asset('storage/' . $produk->gambar) }}"
                                     alt="{{ $produk->nama_produk }}"
                                     class="h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @else
                            <div class="h-20 w-20 rounded-lg bg-[var(--input-bg)] flex items-center justify-center text-2xl text-[var(--text-muted)] opacity-50 flex-shrink-0">📦</div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-[var(--text-main)] hover:text-[var(--accent)] transition-colors">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-xs text-[var(--text-muted)] line-clamp-2">{{ $produk->deskripsi }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-[var(--accent)] font-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                <span class="text-[11px] text-[var(--text-muted)] font-medium bg-[var(--input-bg)] px-2 py-0.5 rounded">Stok: {{ $produk->stok }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endif
