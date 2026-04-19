@if($produks->isEmpty())
    <section class="py-12 text-center">
        <div class="text-4xl mb-2">📦</div>
        <p class="text-sm text-gray-500">Belum ada produk tersedia.</p>
    </section>
@else
    <section class="mb-12">
        <h2 class="text-2xl font-serif text-gray-900 mb-6">Produk Kami</h2>

        @if($custom['product_layout'] === 'grid')
            {{-- Grid layout --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach($produks as $produk)
                    <a href="{{ route('tenant.produk.detail', [$tenant, $produk]) }}"
                       class="block bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama_produk }}"
                                 class="aspect-square w-full object-cover">
                        @else
                            <div class="aspect-square flex items-center justify-center bg-gray-50 text-4xl text-gray-300">📦</div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-medium text-sm text-gray-900 line-clamp-2">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-accent font-bold text-sm">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
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
                       class="flex gap-4 bg-white rounded-2xl p-3 border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}"
                                 alt="{{ $produk->nama_produk }}"
                                 class="h-20 w-20 rounded-lg object-cover flex-shrink-0">
                        @else
                            <div class="h-20 w-20 rounded-lg bg-gray-50 flex items-center justify-center text-2xl text-gray-300 flex-shrink-0">📦</div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h3 class="font-medium text-gray-900">{{ $produk->nama_produk }}</h3>
                            <p class="mt-1 text-xs text-gray-500 line-clamp-2">{{ $produk->deskripsi }}</p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-accent font-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                <span class="text-xs text-gray-400">Stok: {{ $produk->stok }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endif
