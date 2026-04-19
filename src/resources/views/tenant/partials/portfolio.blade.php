<section>
    <h2 class="text-2xl font-serif text-[var(--text-main)] mb-6">Portofolio</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($portofolios as $item)
            <div class="group bg-[var(--card-bg)] rounded-2xl overflow-hidden border border-[var(--border-color)] shadow-sm">
                @if($item->gambar)
                    <div class="aspect-video overflow-hidden bg-[var(--input-bg)]">
                        <img src="{{ asset('storage/' . $item->gambar) }}"
                             alt="{{ $item->judul }}"
                             class="h-full w-full object-cover transition-transform duration-700">
                    </div>
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-[var(--text-main)]">{{ $item->judul }}</h3>
                    @if($item->deskripsi)
                        <p class="mt-2 text-sm text-[var(--text-muted)] leading-relaxed">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
