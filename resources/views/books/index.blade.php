<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">📚 Katalog Buku Perpustakaan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8 border border-gray-100">

                @if(session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    @if(auth()->user()?->role == 'admin')
                    <a href="{{ route('books.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-md transition-all duration-300 transform hover:-translate-y-1">
                        + Tambah Buku Baru
                    </a>
                    @else
                    <div></div> @endif

                    <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau penulis..." class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm min-w-[250px] transition duration-200">
                        <select name="category_id" class="border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 rounded-xl shadow-sm transition duration-200">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-gray-800 text-white px-5 py-2.5 rounded-xl shadow-md hover:bg-gray-900 transition-all duration-300">Filter</button>
                        @if(request('search') || request('category_id'))
                            <a href="{{ route('books.index') }}" class="text-gray-500 hover:text-red-600 underline self-center px-2 transition">Reset</a>
                        @endif
                    </form>
                </div>
                
                <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Penulis</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stok</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($all_books as $item)
                            <tr class="hover:bg-indigo-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $item->judul_buku }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $item->penulis ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($item->stok == 0)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-green-100 text-green-800">{{ $item->stok }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex gap-3 justify-center items-center">
                                        @if(auth()->user()?->role == 'admin')
                                            <a href="{{ route('books.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold transition">Edit</a>
                                            <form action="{{ route('books.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini secara permanen?');">
                                                @csrf @method('DELETE')
                                                <button class="text-red-600 hover:text-red-900 font-semibold transition">Hapus</button>
                                            </form>
                                        @endif

                                        @if(auth()->user()?->role == 'user')
                                            @php
                                                $alreadyBorrowed = \App\Models\Borrowing::where('user_id', auth()->id())
                                                    ->where('book_id', $item->id)
                                                    ->whereIn('status',['Menunggu Persetujuan Pinjam','Dipinjam'])
                                                    ->exists();
                                            @endphp

                                            @if($alreadyBorrowed)
                                                <button class="bg-gray-300 text-gray-500 font-semibold py-1.5 px-4 rounded-lg cursor-not-allowed text-sm">Sedang Dipinjam</button>
                                            @elseif($item->stok > 0)
                                                <form action="{{ route('borrowings.store') }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="book_id" value="{{ $item->id }}">
                                                    <input type="number" name="jumlah" min="1" max="{{ $item->stok }}" value="1" class="w-16 border-gray-300 rounded-lg text-sm py-1 px-2 focus:ring-indigo-500" required>
                                                    <button class="bg-blue-600 text-white font-semibold py-1.5 px-4 rounded-lg hover:bg-blue-700 shadow-sm transition transform hover:-translate-y-0.5 text-sm">Pinjam</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400 italic text-sm">Tidak Tersedia</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($all_books->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">Tidak ada buku yang ditemukan.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="grid grid-cols-1 gap-4 md:hidden">
                    @foreach($all_books as $item)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col gap-3">
                        <div class="border-b pb-2">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $item->judul_buku }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->penulis ?? '-' }}</p>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Stok:</span>
                            @if($item->stok == 0)
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Habis</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-green-100 text-green-800">{{ $item->stok }} Tersedia</span>
                            @endif
                        </div>
                        <div class="mt-2">
                            @if(auth()->user()?->role == 'admin')
                                <div class="flex gap-2">
                                    <a href="{{ route('books.edit', $item->id) }}" class="flex-1 text-center bg-indigo-50 text-indigo-700 py-2 rounded-lg font-semibold border border-indigo-100 hover:bg-indigo-100 transition">Edit</a>
                                    <form action="{{ route('books.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus buku ini secara permanen?');">
                                        @csrf @method('DELETE')
                                        <button class="w-full text-center bg-red-50 text-red-700 py-2 rounded-lg font-semibold border border-red-100 hover:bg-red-100 transition">Hapus</button>
                                    </form>
                                </div>
                            @endif

                            @if(auth()->user()?->role == 'user')
                                @php
                                    $alreadyBorrowed = \App\Models\Borrowing::where('user_id', auth()->id())
                                        ->where('book_id', $item->id)
                                        ->whereIn('status',['Menunggu Persetujuan Pinjam','Dipinjam'])
                                        ->exists();
                                @endphp

                                @if($alreadyBorrowed)
                                    <button class="w-full bg-gray-200 text-gray-500 font-semibold py-2 rounded-lg cursor-not-allowed text-sm">Sedang Dipinjam</button>
                                @elseif($item->stok > 0)
                                    <form action="{{ route('borrowings.store') }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $item->id }}">
                                        <input type="number" name="jumlah" min="1" max="{{ $item->stok }}" value="1" class="w-20 border-gray-300 rounded-lg text-sm py-2 px-3 focus:ring-indigo-500" required>
                                        <button class="flex-1 bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 shadow-sm transition text-sm">Pinjam Buku</button>
                                    </form>
                                @else
                                    <button class="w-full bg-red-50 text-red-400 font-semibold py-2 rounded-lg cursor-not-allowed text-sm border border-red-100">Tidak Tersedia</button>
                                @endif
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @if($all_books->isEmpty())
                        <div class="text-center text-gray-500 p-4 border border-gray-200 rounded-xl">Tidak ada buku yang ditemukan.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>