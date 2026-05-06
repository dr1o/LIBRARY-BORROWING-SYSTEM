<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Alat Laboratorium
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('equipments.create') }}"
                       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        + Tambah Alat
                    </a>
                </div>

                <table class="min-w-full border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2">Nama</th>
                            <th class="border px-4 py-2">Kategori</th>
                            <th class="border px-4 py-2">Stok</th>
                            <th class="border px-4 py-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($all_equipment as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->nama_alat }}</td>
                            <td class="border px-4 py-2">{{ $item->category->nama_kategori }}</td>

                            <td class="border px-4 py-2">
                                @if($item->stok == 0)
                                    <span class="text-red-600 font-bold">Habis</span>
                                @else
                                    {{ $item->stok }}
                                @endif
                            </td>

                            <td class="border px-4 py-2">
                                <div class="flex gap-2 flex-wrap">

                                    <!-- Edit -->
                                    <a href="{{ route('equipments.edit', $item->id) }}"
                                       class="text-blue-600 font-semibold">
                                        Edit
                                    </a>

                                    <!-- Tambah stok -->
                                    <form action="{{ route('equipments.increase', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-green-600 font-semibold">
                                            Tambah Stok
                                        </button>
                                    </form>

                                    <!-- Kurangi stok -->
                                    @if($item->stok > 0)
                                    <form action="{{ route('equipments.decrease', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-yellow-600 font-semibold">
                                            Kurangi Stok
                                        </button>
                                    </form>
                                    @else
                                        <span class="text-gray-400">Kurangi Stok</span>
                                    @endif

                                    <!-- Kosongkan stok -->
                                    <form action="{{ route('equipments.clear', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="text-red-600 font-semibold"
                                            onclick="return confirm('Kosongkan stok?')">
                                            Kosongkan
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