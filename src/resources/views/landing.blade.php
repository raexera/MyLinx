<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyLinx - Bikin Website Semudah Update Status</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-serif:400,400i|inter:400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-serif {
            font-family: 'Instrument Serif', serif;
        }
        .font-sans {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="font-sans antialiased text-[#1A1C19] bg-[#FBFBF9] selection:bg-[#2E5136] selection:text-white">

    <!-- 1. Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#FBFBF9]/90 backdrop-blur-md border-b-2 border-transparent transition-all duration-300" id="navbar">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-[80px]">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('landing') }}" class="flex items-center gap-2 group">
                        <span class="font-bold text-2xl tracking-tighter text-[#2E5136]">MyLinx</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="#produk" class="text-[14px] font-medium text-gray-500 hover:text-[#1A1C19] transition-colors">Produk</a>
                    <a href="#harga" class="text-[14px] font-medium text-gray-500 hover:text-[#1A1C19] transition-colors">Harga</a>
                    <a href="#tentang" class="text-[14px] font-medium text-gray-500 hover:text-[#1A1C19] transition-colors">Tentang Kami</a>
                </div>

                <!-- Right Side Actions -->
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-[14px] font-medium text-[#1A1C19] hover:text-gray-500 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-[14px] font-medium text-[#1A1C19] hover:text-gray-500 transition-colors uppercase tracking-widest">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-full shadow-sm text-[12px] font-bold text-white bg-[#1A1C19] hover:bg-black transition-all duration-200 uppercase tracking-widest">
                            Buat Website
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- 2. Hero Section -->
    <section class="pt-[140px] pb-24 lg:pt-[180px] lg:pb-32 px-6 lg:px-8 relative overflow-hidden">
        <div class="max-w-[1240px] mx-auto grid lg:grid-cols-2 gap-16 lg:gap-8 items-center relative z-10">
            <!-- Left Text -->
            <div class="max-w-xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-[#DCE2D8] text-[#2E5136] text-xs font-semibold uppercase tracking-widest mb-6">
                    <div class="w-2 h-2 rounded-full bg-[#2E5136]"></div>
                    Penyelesaian Instan!
                </div>
                
                <h1 class="text-6xl md:text-7xl lg:text-[5.5rem] font-serif leading-[1.05] text-[#1A1C19] tracking-tight mb-6">
                    Bikin Website<br>
                    <span class="italic text-[#6A7B8C]">Semudah</span><br>
                    Update Status.
                </h1>
                
                <ul class="space-y-3 text-[#1A1C19] text-[15px] font-medium mb-10">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Jualan Cepat, Gak Pake Coding
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Custom Domain sesuai Brand Kamu
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-[#2E5136] mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Lengkap dengan Rekapitulasi Berbagai Integrasi
                    </li>
                </ul>

                <div class="relative max-w-md">
                    <form action="{{ route('register') }}" method="GET" class="flex items-center bg-white border border-[#DCE2D8] rounded-full p-2 pl-6 shadow-sm focus-within:ring-2 focus-within:ring-[#2E5136] transition-all">
                        <span class="text-gray-400 text-lg">mylinx.id/</span>
                        <input type="text" name="domain" placeholder="namatokomu" class="w-full bg-transparent border-none focus:ring-0 text-lg text-[#1A1C19] placeholder-gray-300 p-0 ml-1">
                        <button type="submit" class="bg-[#2E5136] hover:bg-[#1f3824] text-white p-3 rounded-full transition-colors flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                    <p class="text-xs text-gray-500 mt-3 ml-4">*Gratis coba 14 hari, tanpa kartu kredit.</p>
                </div>
            </div>

            <!-- Right Graphic (Phone Mockup) -->
            <div class="relative w-full aspect-square md:aspect-auto md:h-[600px] flex items-center justify-center">
                <!-- Big decorative circle behind -->
                <div class="absolute w-[400px] h-[400px] md:w-[500px] md:h-[500px] bg-[#EBE7DF] rounded-full -right-10 top-1/2 -translate-y-1/2"></div>
                
                <!-- Phone Frame -->
                <div class="relative w-[280px] h-[580px] bg-white border-[10px] border-[#1A1C19] rounded-[2.5rem] shadow-2xl overflow-hidden shadow-gray-900/10 rotate-2 hover:rotate-0 transition-transform duration-500">
                    <div class="absolute top-0 inset-x-0 h-6 bg-white z-20 flex justify-center rounded-t-3xl">
                        <div class="w-20 h-4 bg-[#1A1C19] rounded-b-xl"></div>
                    </div>
                    <!-- Phone Content -->
                    <div class="w-full h-full bg-[#FAFAFA] pt-12 p-4 pb-20 overflow-hidden relative">
                        <div class="w-full h-48 bg-[#E6CDBC] rounded-xl mb-4 relative overflow-hidden flex items-end justify-center pb-4 shadow-sm border border-gray-100">
                            <!-- abstract shape inside -->
                            <div class="w-24 h-24 bg-white/70 rounded-full backdrop-blur-md translate-y-8"></div>
                        </div>
                        <h3 class="font-serif text-2xl mb-1">HELLO KAK ✧</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-4">Discover our new collections for this summer and elevate your daily outfit.</p>
                        
                        <div class="space-y-3">
                            <div class="h-12 w-full bg-white rounded-xl border border-gray-100 shadow-sm flex items-center px-4">
                                <span class="text-xs font-semibold">T-Shirt List</span>
                                <div class="ml-auto w-16 h-6 bg-[#2E5136] rounded-full flex items-center justify-center text-[10px] text-white">SHOP</div>
                            </div>
                            <div class="h-12 w-full bg-white rounded-xl border border-gray-100 shadow-sm flex items-center px-4">
                                <span class="text-xs font-semibold">Mugs</span>
                            </div>
                        </div>

                        <!-- Floating WA button -->
                        <div class="absolute bottom-6 right-6 w-12 h-12 bg-[#25D366] rounded-full shadow-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.066.376-.05c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.418-.1.824z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Floating profile badge -->
                <div class="absolute bottom-12 -left-6 bg-white p-3 rounded-2xl shadow-xl flex items-center gap-3 border border-gray-100 animate-bounce" style="animation-duration: 3s;">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-xl">👤</div>
                    <div>
                        <div class="text-xs font-bold">120+ order harian</div>
                        <div class="text-[10px] text-gray-500">Omzet 50jt/bulan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. UMKM Terbaik -->
    <section class="py-20 bg-[#FBFBF9] overflow-hidden">
        <div class="max-w-[1240px] mx-auto px-6 lg:px-8 mb-16 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="max-w-xl">
                <h2 class="text-4xl md:text-[3.25rem] font-serif leading-[1.15] text-[#1A1C19]">
                    <span class="underline decoration-1 underline-offset-[12px] decoration-[#1A1C19]">UMKM Terbaik Menggunakan Platform</span><br />
                    <span class="underline decoration-1 underline-offset-[12px] decoration-[#1A1C19]">Ini</span>
                </h2>
                <p class="text-[#6A7B8C] mt-8 text-sm leading-relaxed max-w-sm">
                    Bergabung dengan ribuan pedagang lokal yang sudah Go Online dan<br>meningkatkan penjualan mereka.
                </p>
            </div>
            <div class="text-xl md:text-2xl font-serif italic text-gray-300 tracking-wide pb-2">
                Curated by Mylinx
            </div>
        </div>

        <!-- Horizontal scroll container / Grid -->
        <div class="flex xl:justify-center gap-6 px-6 lg:px-8 overflow-x-auto pb-12 snap-x hide-scroll">
            
            <!-- Card 1: Zara Hijab Collection -->
            <div class="min-w-[280px] md:min-w-[300px] flex flex-col snap-start">
                <div class="bg-[#EEEEEE] rounded-[2.5rem] p-3 mb-4 border border-white/50 shadow-sm relative group overflow-hidden">
                    <div class="w-full aspect-[1/1.6] bg-gray-200 rounded-3xl overflow-hidden relative">
                        <!-- Image placeholder matching the hijab portrait -->
                        <img src="https://images.unsplash.com/photo-1621252179027-9c60aa513682?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700" alt="Zara Hijab">
                        <!-- Bottom Bar Inner -->
                        <div class="absolute bottom-0 inset-x-0 h-16 bg-gradient-to-t from-white/90 to-white/40 flex items-end justify-center pb-4">
                            <span class="font-serif font-bold text-[#1A1C19] text-sm tracking-wide">Zara Hijab Collection</span>
                        </div>
                    </div>
                </div>
                <!-- Card 1 Label -->
                <div class="flex items-center justify-between pb-3 mt-1 border-b border-gray-200/80 mx-1">
                    <h3 class="font-serif italic text-lg text-[#1A1C19]">Zara Hijab</h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">Fashion</span>
                </div>
            </div>

            <!-- Card 2: Jaya Teknik -->
            <div class="min-w-[280px] md:min-w-[300px] flex flex-col snap-start">
                <div class="bg-[#EEEEEE] rounded-[2.5rem] p-3 mb-4 border border-white/50 shadow-sm relative group overflow-hidden">
                    <div class="w-full aspect-[1/1.6] bg-[#F2F7FC] rounded-3xl overflow-hidden relative flex flex-col items-center justify-center p-6">
                        <!-- Asterisk / Snowflake logo -->
                        <svg class="w-16 h-16 text-[#2E61DB] mb-6" fill="currentColor" viewBox="0 0 24 24"><path d="M13,2.03V8.85L18.91,5.43L19.91,7.16L14,10.58L19.91,14L18.91,15.73L13,12.31V21H11V12.31L5.09,15.73L4.09,14L10,10.58L4.09,7.16L5.09,5.43L11,8.85V2.03H13Z"/></svg>
                        
                        <h4 class="font-serif text-[#2E61DB] text-[1.35rem] mb-2 border-b border-[#2E61DB]/30 pb-1">Jaya Teknik</h4>
                        <span class="text-[8px] font-bold text-[#2E61DB] uppercase tracking-[0.2em] mb-12">Professional Service</span>
                        
                        <div class="mt-auto w-full max-w-[85%] bg-[#2E61DB] text-white py-3 rounded-full text-[11px] font-medium text-center shadow-lg shadow-blue-500/30 hover:bg-blue-800 transition-colors cursor-pointer">
                            Book Appointment
                        </div>
                    </div>
                </div>
                <!-- Card 2 Label -->
                <div class="flex items-center justify-between pb-3 mt-1 border-b border-gray-200/80 mx-1">
                    <h3 class="font-serif italic text-lg text-[#1A1C19]">Servis AC Jaya</h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">Service</span>
                </div>
            </div>

            <!-- Card 3: Burger Luber -->
            <div class="min-w-[280px] md:min-w-[300px] flex flex-col snap-start">
                <div class="bg-[#EEEEEE] rounded-[2.5rem] p-3 mb-4 border border-white/50 shadow-sm relative group overflow-hidden">
                    <div class="w-full aspect-[1/1.6] bg-gradient-to-br from-[#DCA479] via-[#8B6554] to-[#2B231F] rounded-3xl overflow-hidden relative p-6 flex flex-col justify-end">
                        <div class="absolute top-4 right-4 bg-[#D73A27] text-white text-[10px] font-bold w-10 h-10 rounded-full flex items-center justify-center shadow-md">
                            -20%
                        </div>
                        <h4 class="font-serif text-white text-[1.4rem] mb-0.5 tracking-wide">Burger Luber</h4>
                        <span class="text-[11px] text-white/70">Best in town</span>
                        <!-- faint bottom gradient overlay for text readability -->
                        <div class="absolute bottom-0 inset-x-0 h-1/3 bg-gradient-to-t from-black/60 to-transparent pointer-events-none -z-10"></div>
                    </div>
                </div>
                <!-- Card 3 Label -->
                <div class="flex items-center justify-between pb-3 mt-1 border-b border-gray-200/80 mx-1">
                    <h3 class="font-serif italic text-lg text-[#1A1C19]">Burger Luber</h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">Culinary</span>
                </div>
            </div>

            <!-- Card 4: Lens Capture -->
            <div class="min-w-[280px] md:min-w-[300px] flex flex-col snap-start">
                <div class="bg-[#EEEEEE] rounded-[2.5rem] p-3 mb-4 border border-white/50 shadow-sm relative group overflow-hidden">
                    <div class="w-full aspect-[1/1.6] bg-[#BEB0A2] rounded-3xl overflow-hidden relative p-5 flex flex-col items-center justify-center">
                         <div class="absolute inset-[8%] border border-white/60 pointer-events-none z-20"></div>
                         <div class="w-[85%] aspect-square shadow-xl border border-black/5 relative overflow-hidden group-hover:scale-105 transition-transform duration-700 bg-gray-300">
                             <img src="https://images.unsplash.com/photo-1517487881594-2787f0147fc1?q=80&w=600&auto=format&fit=crop" alt="Photography" class="w-full h-full object-cover">
                             <div class="absolute inset-0 flex items-center justify-center z-30">
                                 <span class="font-serif italic text-white text-2xl tracking-[0.15em] drop-shadow-md">LENS.</span>
                             </div>
                         </div>
                    </div>
                </div>
                <!-- Card 4 Label -->
                <div class="flex items-center justify-between pb-3 mt-1 border-b border-gray-200/80 mx-1">
                    <h3 class="font-serif italic text-lg text-[#1A1C19]">Lens Capture</h3>
                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.15em]">Photography</span>
                </div>
            </div>

            <!-- right padder -->
            <div class="min-w-4 snap-end"></div>
        </div>
    </section>

    <!-- 4. Features: Link in bio -->
    <section id="produk" class="py-24 lg:py-32 px-6 bg-[#FBFBF9]">
        <div class="max-w-[1240px] mx-auto">
            <div class="text-center mb-16 lg:mb-24">
                <div class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4">SELALU ADA FITURNYA</div>
                <h2 class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-4">Bukan Sekadar<br><span class="italic text-[#6A7B8C]">Link-in-Bio</span> Biasa</h2>
                <p class="text-gray-500 max-w-lg mx-auto">Fitur komprehensif yang bantu penjualan dan brand identity kamu lebih dari sekadar kumpulan link.</p>
            </div>

            <div class="relative flex flex-col lg:flex-row items-center justify-center gap-12 lg:gap-0 h-auto lg:h-[600px]">
                
                <!-- Left Details -->
                <div class="lg:absolute lg:left-0 lg:w-1/3 space-y-12 lg:pr-12 text-center lg:text-right z-10 w-full order-2 lg:order-1">
                    <div>
                        <h4 class="text-xl font-serif mb-2">Katalog Produk</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Tampilkan produk unggulanmu. Dilengkapi galeri, harga, varian, dan tombol beli langsung.</p>
                        <!-- decorative dashed line to center -->
                        <div class="hidden lg:block absolute h-px border-b border-dashed border-gray-300 w-24 right-[30%] mt-[-40px]"></div>
                    </div>
                    <div>
                        <h4 class="text-xl font-serif mb-2">Kelola Pesanan</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Semua pesanan masuk direkap secara otomatis, langsung notif ke WhatsApp dan Dashboardmu.</p>
                    </div>
                </div>

                <!-- Center Phone -->
                <div class="relative w-[280px] h-[580px] bg-white border-[8px] border-white ring-1 ring-gray-200 rounded-[2.5rem] shadow-xl overflow-hidden z-20 order-1 lg:order-2">
                    <!-- Phone top notch -->
                    <div class="absolute top-0 inset-x-0 h-6 flex justify-center z-10">
                        <div class="w-1/3 h-4 bg-gray-100 rounded-b-xl border border-gray-200 border-t-0"></div>
                    </div>
                    <div class="w-full h-full bg-gradient-to-b from-[#F2DFCD] to-white pt-16 px-4">
                        <div class="w-20 h-20 bg-[#6CC5B3] rounded-full mx-auto mb-4 border-4 border-white shadow-sm flex items-center justify-center text-white text-2xl">M</div>
                        <h3 class="text-center font-serif text-xl mb-1">Toko Hebat</h3>
                        <p class="text-center text-[10px] text-gray-500 mb-6">Pusat kebutuhan aksesoris harianmu.</p>
                        
                        <!-- Grid items dummy -->
                        <div class="flex gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[10px] text-gray-400 bg-white">IG</div>
                            <div class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[10px] text-gray-400 bg-white">WA</div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="h-32 bg-white rounded-xl border border-gray-100 shadow-sm p-2 flex flex-col justify-end">
                                <div class="w-1/2 h-2 bg-gray-100 rounded mb-1"></div>
                                <div class="w-3/4 h-2 bg-gray-100 rounded"></div>
                            </div>
                            <div class="h-32 bg-white rounded-xl border border-gray-100 shadow-sm p-2 flex flex-col justify-end">
                                <div class="w-1/2 h-2 bg-gray-100 rounded mb-1"></div>
                                <div class="w-3/4 h-2 bg-gray-100 rounded"></div>
                            </div>
                            <div class="h-32 bg-white rounded-xl border border-gray-100 shadow-sm p-2"></div>
                            <div class="h-32 bg-white rounded-xl border border-gray-100 shadow-sm p-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Right Details -->
                <div class="lg:absolute lg:right-0 lg:w-1/3 space-y-12 lg:pl-12 text-center lg:text-left z-10 w-full order-3">
                    <div>
                        <h4 class="text-xl font-serif mb-2">Gratis Ongkir</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Cek ongkir otomatis ke seluruh penjuru Indonesia. Integrasi dengan berbagai kurir terpercaya.</p>
                        <div class="hidden lg:block absolute h-px border-b border-dashed border-gray-300 w-24 left-[30%] mt-[-40px]"></div>
                    </div>
                    <div>
                        <h4 class="text-xl font-serif mb-2">Multi Admin</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">Akses dashboard bisa dibagikan ke seluruh tim operasional dan admin secara terpisah tanpa berebut akun.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 5. Testimonial -->
    <section class="py-24 px-6 border-y border-[#DCE2D8] bg-[#FBFBF9]">
        <div class="max-w-4xl mx-auto text-center">
            <span class="text-[#DCE2D8] font-serif text-8xl leading-none inline-block mb-[-20px]">&ldquo;</span>
            <p class="text-2xl md:text-4xl font-serif leading-relaxed text-[#1A1C19] italic mb-10">
                Website jadi hitungan menit, orderan masuk ke WA sudah rapi. Gak pusing lagi rekap orderan manual dari chat.
            </p>
            <div class="flex items-center justify-center gap-3">
                <img src="https://i.pravatar.cc/100?img=33" alt="Avatar" class="w-12 h-12 rounded-full ring-2 ring-white">
                <div class="text-left">
                    <div class="font-bold text-sm text-[#1A1C19]">Tia Saphira</div>
                    <div class="text-xs text-gray-500">Owner, TheHijab</div>
                </div>
            </div>
            
            <!-- other testimonies placeholders underneath, faint -->
            <div class="mt-20 grid grid-cols-1 md:grid-cols-2 gap-8 text-left border-t border-[#DCE2D8] pt-12">
                 <div>
                    <span class="text-[#DCE2D8] font-serif text-4xl leading-none inline-block">&ldquo;</span>
                    <p class="text-sm text-gray-600 mb-4 mt-[-10px]">Fitur custom domainnya juara banget! Bikin bisnis skincare ku kelihatan 10x lebih pro walau cuma dihandle sendiri.</p>
                    <div class="text-xs font-bold font-serif">— Bunga Lestari, Glow ID</div>
                 </div>
                 <div>
                    <span class="text-[#DCE2D8] font-serif text-4xl leading-none inline-block">&ldquo;</span>
                    <p class="text-sm text-gray-600 mb-4 mt-[-10px]">Tadinya ragu pas pindah aplikasi, tapi data transaksi di mylinx sangat gampang dicek. Sangat mempermudah.</p>
                    <div class="text-xs font-bold font-serif">— Raka Permana, Kopikuy</div>
                 </div>
            </div>
        </div>
    </section>

    <!-- 6. Custom Domain Feature -->
    <section class="py-24 px-6 bg-white overflow-hidden">
        <div class="max-w-[1240px] mx-auto grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Graphics left -->
            <div class="relative w-full aspect-[4/3] bg-[#F3F4ED] rounded-[2rem] p-8 md:p-12 flex items-center justify-center">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white rounded-bl-full opacity-50"></div>
                <!-- Browser Mockup -->
                <div class="w-full max-w-sm bg-white rounded-xl shadow-xl overflow-hidden border border-[#DCE2D8] z-10">
                    <div class="h-10 bg-[#FBFBF9] border-b border-[#DCE2D8] flex items-center px-4 gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <div class="ml-4 flex-1 h-6 bg-white rounded mx-2 border border-[#DCE2D8] text-center text-[10px] text-gray-500 flex items-center justify-center px-2 truncate">
                            🔒 mylinx.id/namatokomu
                        </div>
                    </div>
                    <div class="p-8 pb-12 flex flex-col items-center justify-center h-48 relative">
                        <!-- Transition Arrow -->
                        <div class="w-8 h-8 bg-[#2E5136] text-white rounded-full flex items-center justify-center text-xs absolute right-8 top-1/2 -translate-y-1/2 hidden md:flex shadow-md">
                            &rarr;
                        </div>
                        <div class="text-center">
                            <div class="font-serif text-2xl text-gray-300 line-through decoration-1 decoration-gray-400 mb-2">mylinx.id/...</div>
                            <div class="font-serif text-3xl font-bold text-[#1A1C19]">namatokomu.com</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Text Right -->
            <div>
                <div class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4">PERSONALISASI SEPENUHNYA</div>
                <h2 class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-6">Pakai Nama<br>Domain Sendiri</h2>
                <p class="text-gray-500 text-sm leading-relaxed mb-8">Tingkatkan tingkat kepercayaan pelanggan dengan nama bisnismu sendiri. Kami bantu setup dari awal langganan sampai website go online 100%.</p>
                
                <ul class="space-y-4 text-sm text-[#1A1C19] font-medium">
                    <li class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded bg-[#F3F4ED] flex items-center justify-center text-[#2E5136] text-[10px]">✓</div>
                        Bisa pilih ekstensi .com / .id / .co.id
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded bg-[#F3F4ED] flex items-center justify-center text-[#2E5136] text-[10px]">✓</div>
                        Meningkatkan SEO dan Ranking Google
                    </li>
                    <li class="flex items-center gap-3">
                        <div class="w-5 h-5 rounded bg-[#F3F4ED] flex items-center justify-center text-[#2E5136] text-[10px]">✓</div>
                        Gratis SSL Maintenance (Aman)
                    </li>
                </ul>

                <a href="{{ route('register') }}" class="inline-flex items-center gap-2 mt-10 text-[13px] font-bold uppercase tracking-widest text-[#2E5136] hover:text-[#1A1C19] transition-colors border-b border-[#2E5136] hover:border-[#1A1C19] pb-1">
                    Hubungkan Domainmu Sekarang
                </a>
            </div>

        </div>
    </section>

    <!-- 7. Dashboard / Analytics (Dark Section) -->
    <section class="py-24 px-6 bg-[#18191C] text-white relative border-b border-gray-800">
        <div class="max-w-[1240px] mx-auto grid lg:grid-cols-2 gap-16 items-center">
            
            <!-- Text Left -->
            <div>
                <div class="text-[#DCE2D8] opacity-70 text-[11px] font-bold uppercase tracking-[0.2em] mb-4">REAL-TIME REPORT</div>
                <h2 class="text-4xl md:text-5xl font-serif leading-tight mb-6">Pantau Performa<br>Tokomu</h2>
                <p class="text-gray-400 text-sm leading-relaxed mb-8 max-w-sm">Jualan stabil karena bisa diukur. Pantau datanya mengenai total kunjungan hingga konversi penjualan langsung di satu dashboard yang terpusat.</p>
                
                <div class="flex gap-12 mt-8 border-t border-gray-800 pt-8">
                    <div>
                        <div class="text-2xl font-serif mb-1">Real-time</div>
                        <div class="text-[11px] text-gray-500 uppercase tracking-widest">Update Data</div>
                    </div>
                    <div>
                        <div class="text-2xl font-serif mb-1">Harian</div>
                        <div class="text-[11px] text-gray-500 uppercase tracking-widest">Report Ringkasan</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Graphic Right -->
            <div class="w-full bg-[#1F2124] border border-gray-700 rounded-2xl p-6 shadow-2xl relative">
                <!-- Top header mock -->
                <div class="flex justify-between items-center mb-10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-gray-700"></div>
                        <div class="h-4 w-24 bg-gray-700 rounded"></div>
                    </div>
                    <div class="w-8 h-8 rounded-full border border-gray-600 flex justify-center items-center text-xs text-gray-400">?</div>
                </div>

                <div class="mb-8">
                    <div class="text-xs text-gray-400 uppercase tracking-widest mb-1">Pendapatan Hari Ini</div>
                    <div class="text-4xl font-serif">Rp 17.500.000</div>
                    <div class="text-xs text-green-400 mt-2 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        + 12% dari kemarin
                    </div>
                </div>

                <!-- Bar chart mock -->
                <div class="h-48 flex items-end gap-3 px-2 border-b border-gray-700 pb-2">
                    <div class="w-full bg-gray-700 rounded-t-sm h-[30%] opacity-50"></div>
                    <div class="w-full bg-gray-700 rounded-t-sm h-[50%] opacity-50"></div>
                    <div class="w-full bg-gray-700 rounded-t-sm h-[40%] opacity-50"></div>
                    <div class="w-full bg-[#E5B54A] rounded-t-sm h-[80%] relative group">
                        <!-- tooltip mock -->
                        <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-white text-black text-[10px] font-bold py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">7.5Jt</div>
                    </div>
                    <div class="w-full bg-gray-700 rounded-t-sm h-[60%] opacity-50"></div>
                    <div class="w-full bg-gray-700 rounded-t-sm h-[45%] opacity-50"></div>
                    <div class="w-full bg-gray-700 rounded-t-sm h-[70%] opacity-50"></div>
                </div>
            </div>

        </div>
    </section>

    <!-- 8. Integrations -->
    <section class="py-24 px-6 bg-[#FBFBF9] text-center">
        <div class="max-w-3xl mx-auto">
            <div class="text-[#2E5136] text-[11px] font-bold uppercase tracking-[0.2em] mb-4">EKOSISTEM</div>
            <h2 class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-4">Optimalkan<br>Pemasaran Digital</h2>
            <p class="text-gray-500 text-sm leading-relaxed max-w-lg mx-auto mb-16">Hubungkan event tracking dan pixel ke dalam link kamu dengan sangat mudah. Cocok untuk kebutuhan iklan berbayarmu (Meta Ads, TikTok Ads).</p>
            
            <!-- Graphic Connection -->
            <div class="relative w-full max-w-lg mx-auto h-[300px] flex items-center justify-center">
                <!-- circles line -->
                <div class="absolute inset-0 border border-dashed border-[#DCE2D8] rounded-full w-[300px] h-[300px] m-auto animate-spin-slow" style="animation-duration: 40s;">
                    <!-- nodes -->
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 w-10 h-10 bg-purple-500 rounded-full shadow-lg flex items-center justify-center text-white text-xs font-bold border-2 border-white">P</div>
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 w-10 h-10 bg-green-500 rounded-full shadow-lg flex items-center justify-center text-white text-xs font-bold border-2 border-white">WA</div>
                    <div class="absolute top-1/2 -left-4 -translate-y-1/2 w-10 h-10 bg-blue-500 rounded-full shadow-lg flex items-center justify-center text-white text-xs font-bold border-2 border-white">f</div>
                    <div class="absolute top-1/2 -right-4 -translate-y-1/2 w-10 h-10 bg-black rounded-full shadow-lg flex items-center justify-center text-white text-xs font-bold border-2 border-white">T</div>
                </div>

                <!-- center hub -->
                <div class="relative z-10 w-24 h-24 bg-[#1A1C19] text-white rounded-full flex items-center justify-center font-bold tracking-tight text-xl shadow-2xl">
                    MyLinx
                </div>
            </div>
        </div>
    </section>

    <!-- 9. Partner / Supported By -->
    <section class="py-12 border-y border-[#DCE2D8] bg-white text-center">
        <p class="text-[10px] text-gray-400 uppercase tracking-[0.2em] mb-6">SUPPORTED PAYMENT METHOD</p>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-300">
            <div class="text-sm font-bold text-blue-900">BANK BCA</div>
            <div class="text-sm font-bold text-orange-500">ShopeePay</div>
            <div class="text-sm font-bold text-blue-500">DANA</div>
            <div class="text-sm font-bold text-green-500">GoPay</div>
            <div class="text-sm font-bold text-red-500">QRIS</div>
        </div>
    </section>

    <!-- 10. CTA Go Online -->
    <section class="py-24 px-6 bg-[#FBFBF9] text-center">
        <div class="max-w-xl mx-auto">
            <h2 class="text-4xl md:text-5xl font-serif leading-tight text-[#1A1C19] mb-4">Siap untuk <span class="italic text-[#2E5136]">Go Online?</span></h2>
            <p class="text-gray-500 text-sm leading-relaxed mb-10">Tinggalkan cara lama saatnya beralih ke MyLinx. Mulai bangun identitas online bisnismu sekarang, semuanya dari nol rupiah.</p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-full text-white bg-[#1A1C19] hover:bg-black text-[12px] font-bold uppercase tracking-widest shadow-xl transition-transform hover:-translate-y-1 duration-200">
                    Buat Website Gratis
                </a>
                <a href="#harga" class="w-full sm:w-auto px-8 py-3.5 rounded-full text-[#1A1C19] bg-transparent border border-[#1A1C19] hover:bg-gray-100 text-[12px] font-bold uppercase tracking-widest transition-colors">
                    Lihat Paket Harga
                </a>
            </div>
        </div>
    </section>

    <!-- 11. Footer -->
    <footer class="pt-20 pb-10 px-6 border-t border-[#DCE2D8] bg-[#1A1C19] text-[#FBFBF9]">
        <div class="max-w-[1240px] mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
            <div class="col-span-1 md:col-span-1">
                <div class="font-bold text-2xl tracking-tighter text-[#DCE2D8] mb-4">MyLinx</div>
                <p class="text-gray-400 text-xs leading-relaxed max-w-xs">
                    Platform website generator andalan untuk ribuan UMKM di Indonesia. 
                    Kelola produk, link bio, & pesanan tanpa ribet.
                </p>
                <div class="flex gap-4 mt-6">
                    <!-- social icons dummy -->
                    <div class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white cursor-pointer transition-colors text-xs">IG</div>
                    <div class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white cursor-pointer transition-colors text-xs">FB</div>
                    <div class="w-8 h-8 rounded-full border border-gray-700 flex items-center justify-center text-gray-400 hover:text-white cursor-pointer transition-colors text-xs">IN</div>
                </div>
            </div>
            
            <div>
                <h4 class="font-serif text-lg mb-4">Layanan & Produk</h4>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Daftar Fitur</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Harga & Paket</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Galeri Tema</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Custom Domain</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-serif text-lg mb-4">Perusahaan</h4>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-serif text-lg mb-4">Hubungi Kami</h4>
                <ul class="space-y-3 text-xs text-gray-400">
                    <li><a href="#" class="hover:text-white transition-colors">Bantuan & FAQ</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">WhatsApp CS</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Grup Komunitas</a></li>
                </ul>
            </div>
        </div>

        <div class="max-w-[1240px] mx-auto border-t border-gray-800 pt-8 flex flex-col md:flex-row items-center justify-between text-[11px] text-gray-500">
            <p>&copy; {{ date('Y') }} PT Solusi MyLinx Indonesia. Hak Cipta Dilindungi.</p>
            <p class="mt-2 md:mt-0">Dibuat dengan ❤️ dari Indonesia.</p>
        </div>
    </footer>

    <!-- Hide scrollbar for horizontal lists -->
    <style>
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
        .hide-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</body>
</html>
