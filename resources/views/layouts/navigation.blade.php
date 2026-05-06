<div class="bg-red-500 text-white p-2">
    Role Anda Saat Ini: {{ Auth::user()->role }}
</div>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Menu -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(Auth::user()->role == 'admin')
                        <x-nav-link :href="route('equipments.index')" :active="request()->routeIs('equipments.*')">
                            Kelola Alat (Admin)
                        </x-nav-link>

                        <x-nav-link :href="route('equipments.index')">
                            Laporan Pinjam
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('equipments.index')" :active="request()->routeIs('equipments.*')">
                            Daftar Alat (Mahasiswa)
                        </x-nav-link>

                        <x-nav-link :href="route('equipments.index')">
                            Riwayat Pinjam
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Dropdown User -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 bg-white rounded-md hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

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

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-500">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'admin')
                <x-responsive-nav-link :href="route('equipments.index')">
                    Kelola Alat (Admin)
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('equipments.index')">
                    Laporan Pinjam
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('equipments.index')">
                    Daftar Alat (Mahasiswa)
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('equipments.index')">
                    Riwayat Pinjam
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t">
            <div class="px-4">
                <div>{{ Auth::user()->name }}</div>
                <div>{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>