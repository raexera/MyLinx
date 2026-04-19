<section>
    <div class="flex items-center gap-3 mb-6">
        <h2 class="text-2xl font-serif text-gray-900">Portofolio</h2>
        <div class="h-px flex-1 bg-gray-200"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @foreach($portofolios as $item)
            <div class="group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:border-[var(--accent)] hover:ring-1 hover:ring-[var(--accent)] transition-all cursor-default">
                @if($item->gambar)
                    <div class="aspect-video overflow-hidden bg-gray-50">
                        <img src="{{ asset('storage/' . $item->gambar) }}"
                             alt="{{ $item->judul }}"
                             class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
                    </div>
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 group-hover:text-[var(--accent)] transition-colors">{{ $item->judul }}</h3>
                    @if($item->deskripsi)
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
