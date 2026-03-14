<x-app-layout>
    <x-slot name="hideProfile">true</x-slot>
    <x-slot name="header">
        <div class="flex items-center pt-2 sm:pt-4 w-full text-[13.5px] font-bold text-gray-500 max-w-[900px] mx-auto">
            <a href="{{ route('order.index') }}" class="flex items-center gap-2 hover:text-[#1A1C19] transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Orders
            </a>
            <span class="mx-3 text-gray-300">/</span>
            <span class="text-[#1A1C19]">Order #MLX-8920</span>
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
                        <span class="bg-[#ecfdf3] text-[#059669] text-[11px] font-bold px-3 py-[5px] rounded-full tracking-[0.1em]">PAID</span>
                        <span class="text-[14px] font-medium text-[#8b9196] tracking-wide">Februari 16, 2026</span>
                    </div>
                    <!-- Print invoice button -->
                    <button class="flex items-center gap-2.5 text-[13px] font-medium text-[#8b9196] hover:text-[#1A1C19] transition-colors">
                        <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Print Invoice
                    </button>
                </div>
                
                <h1 class="text-5xl sm:text-[3.8rem] font-serif text-[#1A1C19] tracking-tight leading-none mb-3">Order <span class="text-[#8b9196]">#MLX-8920</span></h1>
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
                                  <div class="text-[15px] font-serif text-[#1A1C19] mb-1">Budi Santoso</div>
                                  <div class="text-[13px] font-medium text-[#8b9196]">Member since 2021</div>
                              </div>
                          </div>
                          
                          <!-- Shipping Address -->
                          <div class="flex gap-4">
                              <div class="w-10 h-10 rounded-full bg-[#f9fafb] border border-[#E8EBED] flex items-center justify-center shrink-0 text-[#8b9196]">
                                  <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                              </div>
                              <div>
                                  <div class="text-[13.5px] font-bold text-[#1A1C19] mb-1.5">Shipping Address</div>
                                  <div class="text-[13px] font-medium text-[#8b9196] leading-[1.6]">Jalan Jenderal Sudirman<br>No. 45,<br>Jakarta Selatan, 12190</div>
                              </div>
                          </div>
                          
                          <!-- WhatsApp Contact -->
                          <div class="flex gap-4">
                              <div class="w-10 h-10 rounded-full bg-[#ecfdf3] border border-[#d1fae5] flex items-center justify-center shrink-0 text-[#059669]">
                                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.488-1.761-1.662-2.06-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                              </div>
                              <div>
                                  <div class="text-[13.5px] font-bold text-[#1A1C19] mb-1.5">WhatsApp Contact</div>
                                  <div class="text-[13px] font-medium text-[#059669]">+62 812-3456-7890</div>
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
                               
                               <!-- Item 1 -->
                               <tr>
                                   <td class="py-5">
                                        <div class="flex items-center gap-4">
                                             <div class="w-[46px] h-[46px] rounded-[0.8rem] bg-[#E5B887] relative flex items-center justify-center border border-[#d6a575]/30 overflow-hidden shadow-inner shrink-0">
                                                 <div class="w-8 h-8 rounded bg-white/20 absolute bottom-1 blur-[6px]"></div>
                                                 <img src="https://images.unsplash.com/photo-1610889556528-9a370e51537a?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover relative z-10 mix-blend-multiply opacity-90" alt="">
                                             </div>
                                             <div>
                                                  <div class="text-[14.5px] font-medium text-[#1A1C19] mb-0.5">Kopi Susu Gula Aren (1L)</div>
                                                  <div class="text-[12px] font-medium text-[#8b9196]">Variant: Less Sugar</div>
                                             </div>
                                        </div>
                                   </td>
                                   <td class="py-5 text-center text-[14.5px] text-gray-500 font-medium">2</td>
                                   <td class="py-5 text-right text-[14.5px] text-[#1A1C19] font-medium">Rp 180.000</td>
                               </tr>

                               <!-- Item 2 -->
                               <tr>
                                   <td class="py-5">
                                        <div class="flex items-center gap-4">
                                             <div class="w-[46px] h-[46px] rounded-[0.8rem] bg-[#2A3032] relative flex items-center justify-center border border-[#1b1f20]/30 overflow-hidden shadow-inner shrink-0">
                                                 <div class="w-8 h-8 rounded bg-white/10 absolute bottom-1 blur-[6px]"></div>
                                                 <img src="https://images.unsplash.com/photo-1549931319-a545dcf3bc73?auto=format&fit=crop&w=150&q=80" class="w-full h-full object-cover relative z-10 mix-blend-lighten opacity-80" alt="">
                                             </div>
                                             <div>
                                                  <div class="text-[14.5px] font-medium text-[#1A1C19] mb-0.5">Croissant Butter</div>
                                                  <div class="text-[12px] font-medium text-[#8b9196]">Freshly Baked</div>
                                             </div>
                                        </div>
                                   </td>
                                   <td class="py-5 text-center text-[14.5px] text-gray-500 font-medium">3</td>
                                   <td class="py-5 text-right text-[14.5px] text-[#1A1C19] font-medium">Rp 75.000</td>
                               </tr>

                          </tbody>
                      </table>
                      
                      <!-- Gap pushing table bottom -->
                      <div class="mt-auto">
                          <div class="w-full h-px bg-[#E8EBED] my-3"></div>
                          
                          <table class="w-full max-w-[280px] ml-auto">
                              <tr>
                                  <td class="text-[13px] font-medium text-[#8b9196] py-1.5 text-left">Subtotal</td>
                                  <td class="text-[13.5px] font-medium text-[#1A1C19] py-1.5 text-right">Rp 255.000</td>
                              </tr>
                              <tr>
                                  <td class="text-[13px] font-medium text-[#8b9196] py-1.5 text-left pb-4">Shipping</td>
                                  <td class="text-[13.5px] font-medium text-[#1A1C19] py-1.5 pb-4 text-right">Rp 15.000</td>
                              </tr>
                              <tr class="border-t border-[#E8EBED]">
                                  <td class="text-[14px] font-medium text-[#1A1C19] pt-5 text-left">Total</td>
                                  <td class="text-[1.75rem] font-serif text-[#2E5136] pt-5 text-right leading-none">Rp 270.000</td>
                              </tr>
                          </table>
                      </div>
                      
                 </div>
            </div>
            
            <div class="w-full h-px bg-[#E8EBED]"></div>
            
            <!-- Bottom Actions -->
            <div class="px-8 sm:px-12 py-[22px] bg-[#fcfcfd] flex flex-col sm:flex-row justify-between items-center gap-4">
                 <button class="flex items-center justify-center gap-2 border border-[#E8EBED] text-[#1A1C19] font-bold text-[13.5px] py-3.5 px-6 rounded-full w-full sm:w-auto hover:bg-white shadow-[0_2px_10px_rgb(0,0,0,0.015)] transition-colors">
                     <svg class="w-[18px] h-[18px] text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                     Update Status
                 </button>
                 
                 <button class="flex items-center justify-center gap-2.5 bg-[#2E5136] hover:bg-[#1f3824] text-white font-bold text-[13.5px] py-3.5 px-8 rounded-full shadow-[0_4px_16px_rgb(46,81,54,0.25)] w-full sm:w-auto transition-all transform hover:-translate-y-0.5">
                     <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                     Kirim Invoice
                 </button>
            </div>
        </div>
        
        <!-- Document Footer -->
        <div class="text-center mt-8 text-[11.5px] font-medium text-[#8b9196] pb-8">
            Invoice generated on Feb 16, 2026 at 14:30 PM • MyLinx Order System
        </div>

    </div>
</x-app-layout>
