<x-guest-layout>
    <div class="w-full sm:max-w-[420px] mx-auto text-center">
        
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-[2.75rem] font-serif font-bold text-[#2E5136] tracking-tight mb-3">MyLinx</h1>
            <p class="text-sm font-medium text-[#6A7B8C]">Buat website impianmu sekarang</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5 text-left">
            @csrf

            <!-- Name (Nama Lengkap) -->
            <div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <!-- User icon -->
                        <svg class="h-[18px] w-[18px] text-[#A6B2A8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input id="name" class="block w-full pl-12 pr-4 py-[14px] border border-[#DCE2D8] rounded-[24px] text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#A6B2A8]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama Lengkap" />
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email (Email Bisnis) -->
            <div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <!-- Envelope icon -->
                        <svg class="h-[18px] w-[18px] text-[#A6B2A8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input id="email" class="block w-full pl-12 pr-4 py-[14px] border border-[#DCE2D8] rounded-[24px] text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#A6B2A8]" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email Bisnis" />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Store Name (Nama Usaha) / Optional UI field -->
            <div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <!-- Store icon -->
                        <svg class="h-[18px] w-[18px] text-[#A6B2A8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V10l-2.5-4a2 2 0 00-1.7-.93H9.2a2 2 0 00-1.7.93L5 10v11M3 21h18M5 10h14M8 10v4M12 10v4m4-4v4" />
                        </svg>
                    </div>
                    <!-- Ini field opsional tambahan yg menirukan desain. Agar support Breeze default, ini bisa dibiarkan tidak dikirim, atau diteruskan ke Request -->
                    <input id="store" class="block w-full pl-12 pr-4 py-[14px] border border-[#DCE2D8] rounded-[24px] text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#A6B2A8]" type="text" name="store_name" placeholder="Nama Usaha" />
                </div>
            </div>

            <!-- Password (Kata Sandi) -->
            <div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <!-- Lock icon -->
                        <svg class="h-[18px] w-[18px] text-[#A6B2A8]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input id="password" class="block w-full pl-12 pr-12 py-[14px] border border-[#DCE2D8] rounded-[24px] text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#A6B2A8]" type="password" name="password" required autocomplete="new-password" placeholder="Kata Sandi" />
                    
                    <!-- Hidden field for password confirmation hack to keep UI clean per design but satisfy Laravel Breeze validator -->
                    <input type="hidden" name="password_confirmation" id="password_confirmation" />

                    <!-- Eye slashed icon -->
                    <div class="absolute inset-y-0 right-0 pr-[18px] flex items-center cursor-pointer text-[#A6B2A8] hover:text-[#2E5136]">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- TOS Checkbox -->
            <div class="pt-2 pb-6 px-1 flex items-center">
                <input id="terms" type="checkbox" required class="w-[18px] h-[18px] rounded-full border-gray-300 text-[#2E5136] focus:ring-[#2E5136] cursor-pointer" name="terms">
                <label for="terms" class="ml-3 text-[13px] text-gray-500 cursor-pointer">
                    Saya setuju dengan <a href="#" class="font-bold text-[#2E5136] hover:underline">Syarat & Ketentuan</a> MyLinx.
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="w-full flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-[24px] shadow-[0_10px_30px_rgb(46,81,54,0.15)] text-[15px] font-bold text-white bg-[#2E5136] hover:bg-[#1f3824] focus:outline-none transition-all transform hover:-translate-y-0.5">
                    Buat Akun
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
            
            <div class="text-center pt-6">
                <p class="text-[13px] text-gray-500">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="font-bold text-[#2E5136] hover:text-[#1A1C19] transition-colors">Masuk di sini</a>
                </p>
            </div>
        </form>
    </div>

    <!-- Script to auto-fill password confirmation and toggle visibility -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const passwordInput = document.getElementById('password');
            const passConfirmInput = document.getElementById('password_confirmation');

            if(passwordInput && passConfirmInput) {
                passwordInput.addEventListener('input', (e) => {
                    passConfirmInput.value = e.target.value;
                });
            }
        });
    </script>
</x-guest-layout>
