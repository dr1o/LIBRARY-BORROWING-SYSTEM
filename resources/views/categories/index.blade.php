<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">📂 Kelola Kategori Buku</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8 border border-gray-100">
                
                @if(session('success')) <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6">{{ session('success') }}</div> @endif
                @if(session('error')) <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6">{{ session('error') }}</div> @endif
                @if($errors->any()) <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6">{{ $errors->first() }}</div> @endif

                <form action="{{ route('categories.store') }}" method="POST" class="mb-10 flex flex-col sm:flex-row gap-4 items-end bg-indigo-50/50 p-6 rounded-2xl border border-indigo-100">
                    @csrf
                    <div class="w-full sm:w-2/3">
                        <label class="block text-indigo-900 font-bold mb-2">Tambah Kategori Baru</label>
                        <input type="text" name="nama_kategori" placeholder="Contoh: Fiksi, Sains, Sejarah..." class="w-full border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition" required>
                    </div>
                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md transition transform hover:-translate-y-1">
                        + Simpan
                    </button>
                </form>

                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-40">Jumlah Buku</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($categories as $cat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $cat->nama_kategori }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="bg-gray-100 text-gray-800 py-1 px-3 rounded-full text-sm font-bold">{{ $cat->books_count }}</span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-800 font-semibold transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>