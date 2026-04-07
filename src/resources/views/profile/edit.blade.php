<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-1.5">
                <span class="w-2 h-2 rounded-full bg-[#2E5136]"></span>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.15em]">AKUN — PENGATURAN</span>
            </div>
            <h1 class="text-4xl sm:text-5xl font-serif text-[#1A1C19] tracking-tight">Pengaturan Akun</h1>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-2xl space-y-6">

            {{-- Update Profile Information --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                <div class="p-6">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
