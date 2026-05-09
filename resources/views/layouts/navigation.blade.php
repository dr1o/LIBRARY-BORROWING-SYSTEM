<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo UNDIP" class="h-10 w-auto">
                        <span class="font-bold text-xl text-blue-600 hidden sm:block">Sistem Perpustakaan</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
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
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
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
        </div>
    </div>
</nav>