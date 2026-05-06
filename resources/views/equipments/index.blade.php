<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Katalog Alat Laboratorium</h2>
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
                        <a href="{{ route('equipments.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Alat Baru</a>
                    </div>
                @endif

                <table class="min-w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Stok</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                    @foreach($all_equipment as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->nama_alat }}</td>
                            <td class="border px-4 py-2 text-center">{{ $item->stok == 0 ? 'Habis' : $item->stok }}</td>
                            <td class="border px-4 py-2">
                                <div class="flex gap-4 justify-center">

                                    {{-- ADMIN ACTIONS --}}
                                    @if(auth()->user()?->role == 'admin')
                                        <a href="{{ route('equipments.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <form action="{{ route('equipments.increase', $item->id) }}" method="POST">@csrf <button class="text-green-600">+ Stok</button></form>
                                        @if($item->stok > 0)
                                            <form action="{{ route('equipments.decrease', $item->id) }}" method="POST">@csrf <button class="text-yellow-600">- Stok</button></form>
                                        @endif
                                        <form action="{{ route('equipments.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus alat ini secara permanen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600">Hapus Permanen</button>
                                        </form>
                                    @endif

                                    {{-- USER ACTIONS --}}
                                    @if(auth()->user()?->role == 'user')
                                        @php
                                            // Cek apakah user sudah meminjam alat ini dan belum dikembalikan
                                            $alreadyBorrowed = \App\Models\Loan::where('user_id', auth()->id())
                                                ->where('equipment_id', $item->id)
                                                ->whereIn('status',['Menunggu Persetujuan Pinjam','Dipinjam'])
                                                ->exists();
                                        @endphp

                                        @if($alreadyBorrowed)
                                            <button class="bg-gray-400 text-white py-1 px-3 rounded cursor-not-allowed" disabled>Sudah Dipinjam</button>
                                        @elseif($item->stok > 0)
                                            <form action="{{ route('loans.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="equipment_id" value="{{ $item->id }}">
                                                <button class="bg-blue-600 text-white py-1 px-3 rounded">Pinjam</button>
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