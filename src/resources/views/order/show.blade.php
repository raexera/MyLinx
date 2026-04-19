<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center pt-2 sm:pt-4 w-full text-[13.5px] font-bold text-gray-500 max-w-[900px] mx-auto">
            <a href="{{ route('order.index') }}" class="flex items-center gap-2 hover:text-[#1A1C19] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Orders
            </a>
            <span class="mx-3 text-gray-300">/</span>
            <span class="text-[#1A1C19]">{{ $order->kode_order }}</span>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="w-full max-w-[900px] mx-auto pb-16 pt-5">

        <!-- White Card -->
        <div class="bg-white rounded-[2rem] shadow-[0_4px_24px_rgb(0,0,0,0.02)] border border-[#E8EBED] overflow-hidden flex flex-col">

            <!-- Top Section -->
            <div class="px-8 sm:px-12 py-10">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <div class="flex items-center gap-4">
                        @php
                            $payStatus = $order->invoice?->status_pembayaran ?? 'unpaid';
                            $payBadge = match($payStatus) {
                                'paid'      => 'bg-[#ecfdf3] text-[#059669]',
                                'cancelled' => 'bg-red-50 text-red-600',
                                default     => 'bg-orange-50 text-orange-600',
                            };
                        @endphp
                        <span class="{{ $payBadge }} text-[11px] font-bold px-3 py-[5px] rounded-full tracking-[0.1em] uppercase">
                            {{ $payStatus }}
                        </span>
                        <span class="text-[14px] font-medium text-[#8b9196] tracking-wide">
                            {{ $order->created_at->translatedFormat('d F Y') }}
                        </span>
                    </div>
                </div>

                <h1 class="text-5xl sm:text-[3.8rem] font-serif text-[#1A1C19] tracking-tight leading-none mb-3">
                    Order <span class="text-[#8b9196]">{{ $order->kode_order }}</span>
                </h1>
                <p class="text-[14px] font-medium text-[#8b9196]">Processed via MyLinx Checkout</p>
            </div>

            <div class="w-full h-px bg-[#E8EBED]"></div>

            <!-- Main details section -->
            <div class="flex flex-col md:flex-row divide-y md:divide-y-0 md:divide-x divide-[#E8EBED]">

                 <!-- Left Column: Customer Details -->
                 <div class="w-full md:w-[45%] px-8 sm:px-12 py-10">
                      <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-7">CUSTOMER DETAILS</h3>
                      <div class="space-y-8">
                          <!-- Customer -->
                          <div class="flex gap-4">
                              <div class="w-10 h-10 rounded-full bg-[#f9fafb] border border-[#E8EBED] flex items-center justify-center shrink-0 text-[#8b9196]">
                                  <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                              </div>
                              <div>
                                  <div class="text-[15px] font-serif text-[#1A1C19] mb-1">{{ $order->nama_pembeli }}</div>
                                  <div class="text-[13px] font-medium text-[#8b9196]">{{ $order->email_pembeli }}</div>
                              </div>
                          </div>
                          <!-- Invoice Number -->
                          <div class="flex gap-4">
                              <div class="w-10 h-10 rounded-full bg-[#f9fafb] border border-[#E8EBED] flex items-center justify-center shrink-0 text-[#8b9196]">
                                  <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                              </div>
                              <div>
                                  <div class="text-[13.5px] font-bold text-[#1A1C19] mb-1.5">Nomor Invoice</div>
                                  <div class="text-[13px] font-medium text-[#8b9196]">{{ $order->invoice?->nomor_invoice ?? '-' }}</div>
                              </div>
                          </div>
                          <!-- Order Date -->
                          <div class="flex gap-4">
                              <div class="w-10 h-10 rounded-full bg-[#f9fafb] border border-[#E8EBED] flex items-center justify-center shrink-0 text-[#8b9196]">
                                  <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                              </div>
                              <div>
                                  <div class="text-[13.5px] font-bold text-[#1A1C19] mb-1.5">Tanggal Order</div>
                                  <div class="text-[13px] font-medium text-[#8b9196]">{{ $order->created_at->format('d M Y, H:i') }} WIB</div>
                              </div>
                          </div>
                      </div>
                 </div>

                 <!-- Right Column: Item List -->
                 <div class="w-full md:w-[55%] px-8 sm:px-10 py-10 flex flex-col h-full">
                      <h3 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em] mb-7">ITEM LIST</h3>
                      <table class="w-full text-left">
                          <thead>
                               <tr>
                                   <th class="font-medium text-[13px] text-[#8b9196] pb-4 tracking-wide font-normal">Product Name</th>
                                   <th class="font-medium text-[13px] text-[#8b9196] pb-4 text-center tracking-wide font-normal">Qty</th>
                                   <th class="font-medium text-[13px] text-[#8b9196] pb-4 text-right tracking-wide font-normal">Price</th>
                               </tr>
                          </thead>
                          <tbody class="divide-y divide-[#E8EBED] border-t border-[#E8EBED]">
                               @foreach($order->orderItems as $item)
                               <tr>
                                   <td class="py-5">
                                        <div class="flex items-center gap-4">
                                             <div class="w-[46px] h-[46px] rounded-[0.8rem] overflow-hidden shrink-0 bg-gray-100 border border-[#E8EBED]">
                                                 @if($item->produk->gambar)
                                                     <img src="{{ asset('storage/' . $item->produk->gambar) }}" class="w-full h-full object-cover" alt="">
                                                 @else
                                                     <div class="w-full h-full flex items-center justify-center text-xl text-gray-300">📦</div>
                                                 @endif
                                             </div>
                                             <div>
                                                  <div class="text-[14.5px] font-medium text-[#1A1C19] mb-0.5">{{ $item->produk->nama_produk }}</div>
                                             </div>
                                        </div>
                                   </td>
                                   <td class="py-5 text-center text-[14.5px] text-gray-500 font-medium">{{ $item->jumlah }}</td>
                                   <td class="py-5 text-right text-[14.5px] text-[#1A1C19] font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                               </tr>
                               @endforeach
                          </tbody>
                      </table>
                      <div class="mt-auto">
                          <div class="w-full h-px bg-[#E8EBED] my-3"></div>
                          <table class="w-full max-w-[280px] ml-auto">
                              <tr class="border-t border-[#E8EBED]">
                                  <td class="text-[14px] font-medium text-[#1A1C19] pt-5 text-left">Total</td>
                                  <td class="text-[1.75rem] font-serif text-[#2E5136] pt-5 text-right leading-none">
                                      Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                  </td>
                              </tr>
                          </table>
                      </div>
                 </div>
            </div>

            <div class="w-full h-px bg-[#E8EBED]"></div>

            <!-- Bottom Actions: Status Update Form -->
            @php
                $invoiceUrl = route('public.invoice', $order->public_token);

                // WA message templates (pre-filled, seller will review in WA)
                $messageBayar = "Halo kak {$order->nama_pembeli},\n\n"
                    . "Pesanan *{$order->kode_order}* sudah kami konfirmasi ✓\n"
                    . "Invoice lengkap: {$invoiceUrl}\n\n"
                    . "Untuk pengiriman, mau pakai kurir apa (JNE/J&T/GoSend/Instant/Sameday)?";

                $messageResi = $order->nomor_resi
                    ? "Halo kak {$order->nama_pembeli},\n\n"
                        . "Pesanan *{$order->kode_order}* sudah dikirim 📦\n\n"
                        . "Ekspedisi: *{$order->ekspedisi}*\n"
                        . "No. Resi: *{$order->nomor_resi}*\n\n"
                        . "Invoice: {$invoiceUrl}"
                    : null;

                $waBayarLink = \App\Support\WaHelper::link($order->no_hp_pembeli, $messageBayar);
                $waResiLink  = $messageResi ? \App\Support\WaHelper::link($order->no_hp_pembeli, $messageResi) : null;
            @endphp

            {{-- Action bar --}}
            <div class="px-8 sm:px-12 py-6 bg-[#fcfcfd] space-y-4">

                @if(session('success'))
                    <div class="rounded-xl bg-green-50 border border-green-100 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Contextual actions based on current status --}}
                @switch($order->status)

                    @case('pending')
                        {{-- Pending: waiting for buyer to pay --}}
                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                            <form action="{{ route('order.mark-paid', $order) }}" method="POST" class="flex-1">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Konfirmasi: pembeli sudah mentransfer pembayaran?\n\nPastikan kamu sudah cek bukti transfer di WhatsApp sebelum menandai Lunas.')"
                                        class="w-full bg-[#2E5136] hover:bg-[#1f3824] text-white font-bold text-[13.5px] py-3.5 px-6 rounded-full shadow-sm transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    Tandai Lunas
                                </button>
                            </form>

                            <form action="{{ route('order.cancel', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Batalkan pesanan ini?\n\nStok produk akan dikembalikan.')"
                                        class="w-full sm:w-auto bg-white border border-gray-200 text-gray-500 hover:text-red-600 hover:border-red-200 font-bold text-[13.5px] py-3.5 px-6 rounded-full transition-colors">
                                    Batalkan
                                </button>
                            </form>
                        </div>
                        @break

                    @case('paid')
                    @case('processing')
                        {{-- Paid / Processing: seller should contact buyer via WA, then pack, then ship --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @if($waBayarLink)
                                <a href="{{ $waBayarLink }}" target="_blank"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold text-[13.5px] py-3.5 px-6 rounded-full shadow-sm transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                                    WA Pembeli (Kirim Invoice)
                                </a>
                            @endif

                            <button type="button"
                                    onclick="document.getElementById('ship-modal').classList.remove('hidden')"
                                    class="bg-[#1A1C19] hover:bg-black text-white font-bold text-[13.5px] py-3.5 px-6 rounded-full shadow-sm transition-colors flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6 0a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                                Kirim Pesanan
                            </button>
                        </div>
                        @break

                    @case('shipped')
                        {{-- Shipped: seller can share resi via WA, or mark completed --}}
                        <div class="rounded-xl bg-blue-50 border border-blue-100 p-4 mb-2">
                            <div class="flex items-center gap-2 text-[12px] font-bold text-blue-700 uppercase tracking-widest mb-1">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Sudah Dikirim
                            </div>
                            <div class="text-[13px] text-blue-900">
                                <strong>{{ $order->ekspedisi }}</strong> — Resi: <span class="font-mono">{{ $order->nomor_resi }}</span>
                                @if($order->shipped_at)
                                    <span class="text-blue-600 text-[11px] ml-2">{{ $order->shipped_at->diffForHumans() }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @if($waResiLink)
                                <a href="{{ $waResiLink }}" target="_blank"
                                class="bg-green-600 hover:bg-green-700 text-white font-bold text-[13.5px] py-3.5 px-6 rounded-full shadow-sm transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771z"/></svg>
                                    Bagikan Resi via WA
                                </a>
                            @endif

                            <form action="{{ route('order.complete', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <button type="submit"
                                        onclick="return confirm('Tandai pesanan sudah selesai?\n\n(Biasanya setelah pembeli konfirmasi barang diterima.)')"
                                        class="w-full bg-white border border-[#E8EBED] hover:bg-gray-50 text-[#1A1C19] font-bold text-[13.5px] py-3.5 px-6 rounded-full transition-colors">
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        </div>
                        @break

                    @case('completed')
                        <div class="rounded-xl bg-green-50 border border-green-100 p-4 text-center">
                            <div class="text-[12px] font-bold text-green-700 uppercase tracking-widest">✓ Pesanan Selesai</div>
                            <div class="text-[12px] text-green-600 mt-1">{{ $order->updated_at->diffForHumans() }}</div>
                        </div>
                        @break

                    @case('cancelled')
                        <div class="rounded-xl bg-red-50 border border-red-100 p-4 text-center">
                            <div class="text-[12px] font-bold text-red-700 uppercase tracking-widest">✕ Pesanan Dibatalkan</div>
                        </div>
                        @break
                @endswitch

                {{-- Public invoice link (always visible) --}}
                <div class="pt-4 border-t border-[#E8EBED] flex items-center justify-between gap-3 flex-wrap">
                    <div class="text-[11px] text-gray-400">
                        Link invoice publik (bisa dibagikan ke pembeli):
                    </div>
                    <a href="{{ route('public.invoice', $order->public_token) }}" target="_blank"
                    class="text-[12px] font-bold text-[#2E5136] hover:underline flex items-center gap-1">
                        Lihat PDF
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            </div>

            {{-- Ship modal --}}
            <div id="ship-modal" class="fixed inset-0 z-50 hidden bg-black/50 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl max-w-md w-full p-8">
                    <h3 class="text-xl font-serif text-[#1A1C19] mb-2">Kirim Pesanan</h3>
                    <p class="text-[13px] text-gray-500 mb-6">Masukkan ekspedisi dan nomor resi.</p>

                    <form action="{{ route('order.ship', $order) }}" method="POST" class="space-y-4">
                        @csrf @method('PATCH')

                        <div>
                            <label class="block text-[12px] font-bold text-[#1A1C19] uppercase tracking-widest mb-2">Ekspedisi</label>
                            <select name="ekspedisi" required class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[14px] focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none">
                                <option value="">Pilih ekspedisi...</option>
                                <option value="JNE">JNE</option>
                                <option value="J&T">J&T Express</option>
                                <option value="SiCepat">SiCepat</option>
                                <option value="Pos Indonesia">Pos Indonesia</option>
                                <option value="TIKI">TIKI</option>
                                <option value="Anteraja">Anteraja</option>
                                <option value="GoSend">GoSend</option>
                                <option value="GrabExpress">GrabExpress</option>
                                <option value="Lalamove">Lalamove</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[12px] font-bold text-[#1A1C19] uppercase tracking-widest mb-2">Nomor Resi</label>
                            <input type="text" name="nomor_resi" required placeholder="ABCD1234567890"
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-[14px] font-mono focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none">
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <button type="button" onclick="document.getElementById('ship-modal').classList.add('hidden')"
                                    class="text-[13px] font-bold text-gray-500 hover:text-gray-700 px-4 py-2">
                                Batal
                            </button>
                            <button type="submit"
                                    class="bg-[#2E5136] hover:bg-[#1f3824] text-white text-[13px] font-bold py-2.5 px-5 rounded-full">
                                Tandai Dikirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Document Footer -->
        <div class="text-center mt-8 text-[11.5px] font-medium text-[#8b9196] pb-8">
            Invoice generated on Feb 16, 2026 at 14:30 PM • MyLinx Order System
        </div>

    </div>
</x-app-layout>
