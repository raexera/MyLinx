<section class="mb-12">
    <h2 class="text-2xl font-serif text-gray-900 mb-6">Portofolio</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($portofolios as $item)
            <div class="bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm">
                @if($item->gambar)
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         alt="{{ $item->judul }}"
                         class="aspect-video w-full object-cover">
                @endif
                <div class="p-5">
                    <h3 class="font-bold text-gray-900">{{ $item->judul }}</h3>
                    @if($item->deskripsi)
                        <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $item->deskripsi }}</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</section>
