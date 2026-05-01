<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Alat Laboratorium') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4">
                    <a href="{{ route('equipments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                        + Tambah Alat Baru
                    </a>
                </div>

                <table class="min-w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Nama Alat</th>
                            <th class="border border-gray-300 px-4 py-2">Kategori</th>
                            <th class="border border-gray-300 px-4 py-2">Stok</th>
                            <th class="border border-gray-300 px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif

                        @foreach($all_equipment as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->nama_alat }}</td>
                            <td class="border px-4 py-2">{{ $item->category->nama_kategori }}</td>
                            <td class="border px-4 py-2">{{ $item->stok }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('equipments.edit', $item->id) }}" class="text-blue-600 hover:underline font-semibold">
                                        Edit
                                    </a>

                                    <form action="{{ route('equipments.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-orange-600 hover:underline font-semibold" onclick="return confirm('Pindahkan ke sampah?')">
                                            Hapus (Soft)
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>