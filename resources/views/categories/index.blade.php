<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola Kategori Buku</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                @if(session('success')) <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div> @endif
                @if(session('error')) <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div> @endif
                @if($errors->any()) <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div> @endif

                <form action="{{ route('categories.store') }}" method="POST" class="mb-8 flex gap-4 items-end bg-gray-50 p-4 rounded border">
                    @csrf
                    <div class="w-1/2">
                        <label class="block text-gray-700 font-bold mb-2">Nama Kategori Baru</label>
                        <input type="text" name="nama_kategori" placeholder="Contoh: Fiksi, Sains, Sejarah..." class="w-full border-gray-300 rounded shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition">
                        + Tambah Kategori
                    </button>
                </form>

                <table class="min-w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Nama Kategori</th>
                        <th class="border px-4 py-2 text-center w-32">Jumlah Buku</th>
                        <th class="border px-4 py-2 text-center w-32">Aksi</th>
                    </tr>
                    @foreach($categories as $cat)
                    <tr>
                        <td class="border px-4 py-2 font-semibold">{{ $cat->nama_kategori }}</td>
                        <td class="border px-4 py-2 text-center">{{ $cat->books_count }}</td>
                        <td class="border px-4 py-2 text-center">
                            <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf 
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($categories->isEmpty())
                    <tr>
                        <td colspan="3" class="border px-4 py-4 text-center text-gray-500">Belum ada kategori. Silakan tambahkan di atas.</td>
                    </tr>
                    @endif
                </table>

            </div>
        </div>
    </div>
</x-app-layout>