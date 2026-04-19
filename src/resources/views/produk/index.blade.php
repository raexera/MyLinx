<x-app-layout>
    <x-slot name="whiteBg">true</x-slot>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-5 mt-2 lg:mt-0 w-full lg:pr-4 xl:pr-8 mb-2">
            <div class="flex flex-col">
                <h1 class="text-[2.5rem] sm:text-5xl lg:text-[3.25rem] font-serif text-[#1A1C19] tracking-tight leading-[1.1] mb-2.5">Daftar Produk</h1>
                <p class="text-[14px] sm:text-[14.5px] font-medium text-[#6A7B8C]">Kelola inventaris dan katalog produk Anda dengan gaya majalah yang elegan.</p>
            </div>
            <div>
                 <a href="{{ route('produk.create') }}" class="bg-[#2E5136] hover:bg-[#1f3824] text-white flex items-center justify-center gap-2 px-6 py-[12px] rounded-full text-[13.5px] font-bold transition-all shadow-[0_4px_12px_rgb(46,81,54,0.2)] w-full sm:w-auto">
                     <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                     Tambah Produk Baru
                 </a>
            </div>
        </div>
    </x-slot>

    <div class="w-full lg:pr-4 xl:pr-8 pb-12 flex flex-col h-full mt-6">

        {{-- Flash success message --}}
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-5 py-3.5 rounded-2xl mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Empty state --}}
        @if($produks->isEmpty())
            <div class="bg-white border border-[#E8EBED] rounded-3xl shadow-[0_2px_12px_rgb(0,0,0,0.02)] flex flex-col items-center justify-center py-20">
                <div class="text-5xl mb-4">📦</div>
                <h3 class="text-lg font-bold text-[#1A1C19] mb-2">Belum ada produk</h3>
                <p class="text-sm text-gray-500 mb-6">Mulai tambah produk pertama Anda sekarang.</p>
                <a href="{{ route('produk.create') }}" class="bg-[#2E5136] hover:bg-[#1f3824] text-white px-6 py-3 rounded-full text-sm font-bold transition-colors">
                    Tambah Produk Baru
                </a>
            </div>
        @else
            {{-- Product Table --}}
            <div class="bg-white border border-[#E8EBED] rounded-3xl shadow-[0_2px_12px_rgb(0,0,0,0.02)] flex flex-col flex-1 overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#E8EBED]">
                                <th class="py-5 px-6 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[90px]">Image</th>
                                <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap min-w-[200px]">Nama Produk</th>
                                <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[140px]">Harga</th>
                                <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[100px]">Stock</th>
                                <th class="py-5 px-4 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap w-[100px]">Status</th>
                                <th class="py-5 px-6 font-bold text-[10.5px] tracking-widest text-[#aab2bf] uppercase whitespace-nowrap text-right w-[120px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E8EBED]/60">
                            @foreach($produks as $produk)
                                <tr class="hover:bg-gray-50/50 transition-colors group">
                                    {{-- Image --}}
                                    <td class="px-6 py-4">
                                        @if($produk->gambar)
                                            <div class="w-12 h-12 rounded-full overflow-hidden border border-[#E8EBED]">
                                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                                            </div>
                                        @else
                                            <div class="w-12 h-12 rounded-full bg-[#f0f0f0] flex items-center justify-center text-gray-400 border border-[#E8EBED]">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Name --}}
                                    <td class="px-4 py-4">
                                        <div class="font-serif text-[17px] text-[#1A1C19] leading-tight mb-1">{{ $produk->nama_produk }}</div>
                                        <div class="text-[11px] font-bold text-gray-400">{{ Str::limit($produk->deskripsi, 40) }}</div>
                                    </td>

                                    {{-- Price --}}
                                    <td class="px-4 py-4">
                                        <div class="font-bold text-[13.5px] text-[#1A1C19]">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                                    </td>

                                    {{-- Stock --}}
                                    <td class="px-4 py-4">
                                        @if($produk->stok > 10)
                                            <span class="bg-[#e4faeb] text-[#1fad55] text-[11px] font-bold px-2 py-0.5 rounded border border-[#bef0d1]">{{ $produk->stok }}</span>
                                        @elseif($produk->stok > 0)
                                            <span class="bg-[#fefce8] text-[#eab308] text-[11px] font-bold px-2.5 py-0.5 rounded border border-[#fef08a]">{{ $produk->stok }}</span>
                                        @else
                                            <span class="bg-[#fef2f2] text-[#ef4444] text-[11px] font-bold px-2.5 py-0.5 rounded border border-[#fecaca]">0</span>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="px-4 py-4">
                                        @if($produk->status)
                                            <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                                <span class="w-[5px] h-[5px] rounded-full bg-[#059669]"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-500 text-[11px] font-bold px-2.5 py-[5px] rounded-full flex items-center gap-1.5 w-max">
                                                <span class="w-[5px] h-[5px] rounded-full bg-gray-400"></span>
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('produk.edit', $produk) }}" class="p-2 text-gray-400 hover:text-[#2E5136] transition-colors rounded-full hover:bg-green-50" title="Edit">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('produk.destroy', $produk) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors rounded-full hover:bg-red-50" title="Hapus">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($produks->hasPages())
                    <div class="px-6 py-5 border-t border-[#E8EBED]">
                        {{ $produks->links() }}
                    </div>
                @endif

            </div>
        @endif

    </div>
</x-app-layout>
