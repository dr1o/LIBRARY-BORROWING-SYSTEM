<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex flex-1 justify-start">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo UNDIP" class="h-10 w-auto">
                        <span class="font-bold text-xl text-blue-600 hidden sm:block">Sistem Perpustakaan</span>
                    </a>
                </div>
            </div>

            <div class="hidden space-x-8 sm:flex justify-center flex-1">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>

                @if(Auth::user()?->role == 'admin')
                    <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">Kategori</x-nav-link>
                    <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.index')">Kelola Anggota</x-nav-link>
                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">Kelola Buku</x-nav-link>
                    <x-nav-link :href="route('borrowings.admin')" :active="request()->routeIs('borrowings.admin')">Sirkulasi & Persetujuan</x-nav-link>
                @else
                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">Katalog Buku</x-nav-link>
                    <x-nav-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.index')">Riwayat Pinjam</x-nav-link>
                @endif
            </div>

            <div class="hidden sm:flex sm:items-center justify-end flex-1">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 bg-white hover:text-gray-700">
                            <div>{{ Auth::user()?->name }} ({{ Auth::user()?->role }})</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Edit Profile</x-dropdown-link>

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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden absolute top-16 left-0 w-full bg-white border-b border-gray-100 shadow-lg z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>

            @if(Auth::user()?->role == 'admin')
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">Kategori</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.index')">Kelola Anggota</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">Kelola Buku</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('borrowings.admin')" :active="request()->routeIs('borrowings.admin')">Sirkulasi & Persetujuan</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.*')">Katalog Buku</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('borrowings.index')" :active="request()->routeIs('borrowings.index')">Riwayat Pinjam</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()?->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">Edit Profile</x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>