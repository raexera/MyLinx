<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
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
            <div class="px-8 sm:px-12 py-[22px] bg-[#fcfcfd] flex flex-col sm:flex-row justify-between items-center gap-4">
                 @if(session('success'))
                     <div class="text-sm font-medium text-green-600">{{ session('success') }}</div>
                 @endif
                 <form action="{{ route('order.update', $order) }}" method="POST" class="flex items-center gap-3 w-full sm:w-auto">
                     @csrf @method('PATCH')
                     <select name="status" class="flex-1 sm:flex-none border border-[#E8EBED] rounded-full px-5 py-3 text-[13.5px] font-bold text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-1 focus:ring-[#2E5136] outline-none">
                         @foreach(['pending','confirmed','processing','completed','cancelled'] as $s)
                             <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                         @endforeach
                     </select>
                     <button type="submit" class="flex items-center justify-center gap-2 border border-[#E8EBED] text-[#1A1C19] font-bold text-[13.5px] py-3.5 px-6 rounded-full w-full sm:w-auto hover:bg-white shadow-[0_2px_10px_rgb(0,0,0,0.015)] transition-colors">
                         <svg class="w-[18px] h-[18px] text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                         Update Status
                     </button>
                 </form>
            </div>
        </div>
        
        <!-- Document Footer -->
        <div class="text-center mt-8 text-[11.5px] font-medium text-[#8b9196] pb-8">
            Invoice generated on Feb 16, 2026 at 14:30 PM • MyLinx Order System
        </div>

    </div>
</x-app-layout>
