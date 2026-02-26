<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            {{-- Welcome Card --}}
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold">
                        Selamat datang, {{ Auth::user()->nama }}!
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Role: <span class="font-medium">{{ Auth::user()->role }}</span>
                    </p>
                </div>
            </div>

            {{-- Tenant Admin Section --}}
            @if(Auth::user()->isTenantAdmin() && Auth::user()->tenant)
                <div class="mt-6 grid gap-6 md:grid-cols-3">

                    {{-- Tenant Info --}}
                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Nama Toko</p>
                        <p class="mt-1 text-lg font-semibold text-gray-900">
                            {{ Auth::user()->tenant->nama_tenant }}
                        </p>
                        <a href="{{ route('tenant.show', Auth::user()->tenant) }}"
                           target="_blank"
                           class="mt-3 inline-block text-sm text-green-700 hover:underline">
                            Lihat Halaman Publik &rarr;
                        </a>
                    </div>

                    {{-- Product Count --}}
                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ Auth::user()->tenant->produks()->count() }}
                        </p>
                    </div>

                    {{-- Order Count --}}
                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Pesanan</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ Auth::user()->tenant->orders()->count() }}
                        </p>
                    </div>

                </div>
            @endif

            {{-- Super Admin Section --}}
            @if(Auth::user()->isSuperAdmin())
                <div class="mt-6 grid gap-6 md:grid-cols-3">

                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total Tenant</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ \App\Models\Tenant::count() }}
                        </p>
                    </div>

                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Total User</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ \App\Models\User::count() }}
                        </p>
                    </div>

                    <div class="overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <p class="text-sm font-medium text-gray-500">Template Aktif</p>
                        <p class="mt-1 text-3xl font-bold text-gray-900">
                            {{ \App\Models\Template::where('is_active', true)->count() }}
                        </p>
                    </div>

                </div>
            @endif

        </div>
    </div>
</x-app-layout>
