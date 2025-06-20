{{-- layouts/footer-navigation.blade.php --}}
<div class="fixed inset-x-0 bottom-0 z-50 pointer-events-none sm:hidden">
    <div
        class="flex items-center justify-between px-4 py-2 bg-white border-t border-gray-200 shadow-lg pointer-events-auto rounded-t-2xl">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
            </svg>
            Dashboard
        </a>

        {{-- Kelas (hanya Murid) --}}
        @role('Murid')
            <a href="{{ route('kelas.index') }}"
                class="flex flex-col items-center flex-1 py-2 text-xs {{ request()->routeIs('kelas.index') ? 'text-indigo-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10" />
                </svg>
                Daftar Kelas
            </a>

            <a href="{{ route('kelas.saya') }}"
                class="flex flex-col items-center flex-1 py-2 text-xs {{ request()->routeIs('kelas.saya') ? 'text-indigo-600' : 'text-gray-500' }}">
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z" />
                </svg>
                Kelas Saya
            </a>
        @endrole

        {{-- Profil --}}
        <a href="{{ route('profile.edit') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs {{ request()->routeIs('profile.edit') ? 'text-indigo-600' : 'text-gray-500' }}">
            <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5.121 17.804A9.005 9.005 0 0112 15c2.21 0 4.209.805 5.879 2.137M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            Profil
        </a>
    </div>
</div>
