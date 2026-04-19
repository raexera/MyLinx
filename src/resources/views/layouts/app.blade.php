<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'MyLinx') }} - Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
        href="https://fonts.bunny.net/css?family=instrument-serif:400,400i|inter:400,500,600,700"
        rel="stylesheet"
    />
    @vite (['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .font-serif {
            font-family: "Instrument Serif", serif;
        }
        .font-sans {
            font-family: "Inter", sans-serif;
        }
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>
</head>
<body
    class="font-sans antialiased text-[#1A1C19] flex h-screen overflow-hidden selection:bg-[#2E5136] selection:text-white bg-[#F5F6F8]"
    x-data="{ sidebarOpen: false }"
>
    <div
        x-show="sidebarOpen"
        style="display: none"
        class="fixed inset-0 bg-black/60 z-40 lg:hidden backdrop-blur-sm"
        @click="sidebarOpen = false"
        x-transition.opacity
    ></div>
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed lg:relative w-[260px] bg-[#1A1C19] text-white flex flex-col h-full flex-shrink-0 z-50 transition-transform duration-300 transform lg:translate-x-0"
    >
        <div
            class="h-[96px] flex items-center justify-between px-8 border-b border-white/5 shrink-0"
        >
            <a href="/" class="flex items-center gap-3">
                <div
                    class="w-8 h-8 rounded-full bg-[#2E5136] flex items-center justify-center shadow-lg"
                >
                    <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                </div>
                <span class="font-serif text-[1.6rem] tracking-wide mt-1"
                    >MyLinx</span
                >
            </a>
            <button
                @click="sidebarOpen = false"
                class="lg:hidden text-gray-400 hover:text-white p-1 focus:outline-none"
            >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-1 hide-scroll">
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
            >
                <span>Dashboard</span>
            </a>
            @if (Auth::user()->isTenantAdmin())
                <a
                    href="{{ route('produk.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('produk.*') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
                >
                    <span>Produk</span>
                </a>
                <a
                    href="{{ route('order.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('order.*') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
                >
                    <span>Order</span>
                </a>
                <a
                    href="{{ route('portfolio.index') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('portfolio.*') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
                >
                    <span>Portfolio Builder</span>
                </a>
                <div class="pt-4 pb-1 px-4">
                    <span
                        class="text-[9px] font-bold text-white/20 uppercase tracking-widest"
                        >Settings</span
                    >
                </div>
                <a
                    href="{{ route('settings.website') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('settings.website') || request()->routeIs('settings.template') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
                >
                    <span>Website</span>
                </a>
                <a
                    href="{{ route('profil-usaha.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profil-usaha.*') ? 'bg-[#2E5136] text-white' : 'text-[#8b9196] hover:text-white hover:bg-white/5' }} rounded-xl text-sm font-semibold transition-colors"
                >
                    <span>Profil Usaha</span>
                </a>
            @endif
        </nav>
        <div
            class="p-4 border-t border-white/5 space-y-1 bg-[#1A1C19] shrink-0"
        >
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-xl hover:bg-white/5 transition-colors group"
            >
                <div
                    class="w-9 h-9 rounded-full bg-[#fcead8] uppercase flex items-center justify-center font-bold text-[13px] text-[#A6785D] shrink-0 group-hover:scale-105 transition-transform ring-2 ring-transparent group-hover:ring-white/20"
                >
                    {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name ?? '?', 0, 2)) }}
                </div>
                <div class="flex flex-col min-w-0">
                    <span
                        class="text-[13px] font-bold text-white leading-tight truncate group-hover:text-gray-200"
                        >{{ Auth::user()->nama }}</span
                    >
                    <span
                        class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-tight mt-1 truncate"
                    >
                        {{ Auth::user()->isSuperAdmin() ? 'Super Admin' : 'UMKM Owner' }}
                    </span>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 text-[#D73A27] hover:bg-red-500/10 rounded-xl text-sm font-semibold transition-colors text-left"
                >
                    <svg class="w-[18px] h-[18px] shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
    <main
        class="flex-1 flex flex-col min-w-0 {{ isset($whiteBg) && $whiteBg == 'true' ? 'bg-white' : 'bg-[#F5F6F8]' }} h-screen overflow-y-auto w-full relative"
    >
        <div
            class="lg:hidden sticky top-0 bg-white/95 backdrop-blur shadow-sm border-b border-[#E8EBED] px-4 py-3 flex items-center justify-between z-30"
        >
            <button
                @click="sidebarOpen = true"
                class="p-2 -ml-2 text-gray-600 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#2E5136]"
            >
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-2.5 hover:opacity-80 transition-opacity"
            >
                <div class="flex flex-col text-right">
                    <span
                        class="text-[12px] font-bold text-[#1A1C19] leading-tight"
                        >{{ Auth::user()->nama }}</span
                    >
                    <span
                        class="text-[9px] font-bold text-gray-400 uppercase tracking-widest"
                        >{{ Auth::user()->isSuperAdmin() ? 'Super Admin' : 'UMKM Owner' }}</span
                    >
                </div>
                <div
                    class="w-[34px] h-[34px] rounded-full bg-[#fcead8] uppercase flex items-center justify-center font-bold text-[12px] text-[#A6785D] ring-2 ring-white shrink-0 shadow-sm"
                >
                    {{ strtoupper(substr(Auth::user()->nama ?? Auth::user()->name ?? '?', 0, 2)) }}
                </div>
            </a>
        </div>
        <header
            class="min-h-[7rem] lg:h-28 px-4 lg:px-10 py-6 lg:py-0 flex flex-col lg:flex-row items-start lg:items-center justify-between flex-shrink-0 w-full max-w-[1400px] mx-auto gap-4 lg:gap-0"
        >
            <div class="flex-1 w-full min-w-0">
                @if (isset($header))
                    {{ $header }}
                @endif
            </div>
        </header>
        <div
            class="px-4 lg:px-10 pb-8 mt-2 w-full max-w-[1400px] mx-auto flex-1"
        >
            {{ $slot }}
        </div>
        <div
            class="px-4 lg:px-10 pb-10 w-full max-w-[1400px] mx-auto flex flex-col md:flex-row justify-between items-center gap-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest text-center md:text-left"
        >
            <p>&copy; 2026 MyLinx Inc. All rights reserved.</p>
            <div class="flex flex-wrap justify-center gap-4 md:gap-6">
                <a href="#" class="hover:text-gray-600 transition-colors"
                    >Privacy Policy</a
                >
                <a href="#" class="hover:text-gray-600 transition-colors"
                    >Terms of Service</a
                >
            </div>
        </div>
    </main>
</body>
</html>
