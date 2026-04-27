<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div
        class="w-full sm:max-w-[420px] bg-white rounded-[2.5rem] p-10 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100/50 relative overflow-hidden"
    >
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-[#1A1C19] mb-2">
                MyLinx
            </h1>
            <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-[#789D84]">Access Dashboard</p>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label
                    for="email"
                    class="block text-xs font-semibold text-gray-700 mb-1.5 ml-1"
                    >Email Address</label
                >
                <div class="relative">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <svg class="h-4 w-4 text-[#789D84]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input
                        id="email"
                        class="block w-full pl-11 pr-4 py-3 border border-gray-200 rounded-full text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#789D84]/60"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="name@example.com"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label
                        for="password"
                        class="block text-xs font-semibold text-gray-700"
                        >Password</label
                    >
                </div>
                <div class="relative" x-data="{ show: false }">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"
                    >
                        <svg class="h-4 w-4 text-[#789D84]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input
                        id="password"
                        class="block w-full pl-11 pr-11 py-3 border border-gray-200 rounded-full text-sm text-[#1A1C19] bg-white focus:border-[#2E5136] focus:ring-[#2E5136] transition-colors placeholder:text-[#789D84]/60"
                        :type="show ? 'text' : 'password'"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    />
                    <button
                        type="button"
                        @click="show = !show"
                        class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-[#789D84] hover:text-[#2E5136] focus:outline-none"
                    >
                        <svg x-show="
                                show
                            " class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <svg x-show="
                                !show
                            " class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
                <x-input-error
                    :messages="$errors->get('password')"
                    class="mt-2"
                />
            </div>
            <input type="hidden" name="remember" value="on" />
            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full flex justify-center items-center gap-2 py-3.5 px-4 border border-transparent rounded-full shadow-sm text-sm font-bold text-white bg-[#2E5136] hover:bg-[#1f3824] focus:outline-none transition-colors"
                >
                    Masuk
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
            <div class="text-center pt-2">
                <p class="text-xs text-gray-500">
                    Belum punya akun?
                    <a
                        href="{{ route('register') }}"
                        class="font-bold text-[#1A1C19] hover:text-[#2E5136] transition-colors"
                        >Daftar Sekarang</a
                    >
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>
