<nav x-data="{ open: false }" class="bg-white border-b border-gray-200">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="w-auto h-8 text-gray-800" />
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden space-x-6 text-sm font-medium text-gray-700 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    Dashboard
                </x-nav-link>

                @role('Murid')
                    <x-nav-link :href="route('kelas.index')" :active="request()->routeIs('kelas.index') || request()->is('kelas*')">
                        Kelas
                    </x-nav-link>
                @endrole

                @role('Guru')
                    <x-nav-link :href="route('guru.pilih-mapel')" :active="request()->routeIs('guru.pilih-mapel')">
                        Mata Pelajaran
                    </x-nav-link>

                    <x-nav-link :href="route('guru.kelas.wali-kelas')" :active="request()->routeIs('guru.kelas.wali-kelas')">
                        Wali Kelas
                    </x-nav-link>
                @endrole


            </div>

            <!-- User Menu -->
            <div class="items-center hidden space-x-4 sm:flex">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="text-sm text-gray-600 hover:text-gray-800 focus:outline-none">
                            {{ Auth::user()->name }}
                            <svg class="inline w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden">
                <button @click="open = !open"
                    class="p-2 text-gray-500 rounded-md hover:text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="px-4 pb-4 sm:hidden">

        <div class="pt-4 mt-4 border-t border-gray-200">
            <div class="text-sm text-gray-800">{{ Auth::user()->name }}</div>
            <div class="mb-3 text-sm text-gray-500">{{ Auth::user()->email }}</div>

            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
