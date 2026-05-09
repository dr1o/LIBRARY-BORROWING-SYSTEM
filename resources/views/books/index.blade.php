<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Katalog Buku Perpustakaan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                @if(auth()->user()?->role == 'admin')
                <div class="mb-4">
                    <a href="{{ route('books.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Buku Baru</a>
                </div>
                @endif
                <form method="GET" class="mb-4 flex flex-wrap gap-2">
                    <input type="text" name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari judul atau penulis..."
                        class="border p-2 rounded w-1/3">

                    <select name="category_id" class="border p-2 rounded">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition">Cari & Filter</button>

                    @if(request('search') || request('category_id'))
                    <a href="{{ route('books.index') }}" class="text-gray-600 underline self-center ml-2">Reset</a>
                    @endif
                </form>
                
                <table class="min-w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Judul Buku</th>
                        <th class="border px-4 py-2">Penulis</th>
                        <th class="border px-4 py-2">Stok</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                    @foreach($all_books as $item)
                    <tr>
                        <td class="border px-4 py-2 font-semibold">{{ $item->judul_buku }}</td>
                        <td class="border px-4 py-2 text-gray-600">{{ $item->penulis ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->stok == 0 ? 'Habis' : $item->stok }}</td>
                        <td class="border px-4 py-2">
                            <div class="flex gap-4 justify-center items-center">

                                {{-- ADMIN ACTIONS --}}
                                @if(auth()->user()?->role == 'admin')
                                <a href="{{ route('books.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                
                                <form action="{{ route('books.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus Permanen</button>
                                </form>
                                @endif

                                {{-- USER ACTIONS --}}
                                @if(auth()->user()?->role == 'user')
                                @php
                                $alreadyBorrowed = \App\Models\Borrowing::where('user_id', auth()->id())
                                ->where('book_id', $item->id)
                                ->whereIn('status',['Menunggu Persetujuan Pinjam','Dipinjam'])
                                ->exists();
                                @endphp

                                @if($alreadyBorrowed)
                                <button class="bg-gray-400 text-white py-1 px-3 rounded cursor-not-allowed" disabled>Sedang Dipinjam</button>
                                @elseif($item->stok > 0)
                                <form action="{{ route('borrowings.store') }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $item->id }}">
                                    <input type="number" name="jumlah" min="1" max="{{ $item->stok }}" value="1" class="w-16 border-gray-300 rounded text-sm py-1 px-2" required title="Jumlah Pinjam">
                                    <button class="bg-blue-600 text-white py-1 px-3 rounded hover:bg-blue-700">Pinjam</button>
                                </form>
                                @else
                                <span class="text-gray-400">Habis</span>
                                @endif
                                @endif

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>

            </div>
        </div>
    </div>
</x-app-layout>