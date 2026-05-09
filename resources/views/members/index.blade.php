<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Anggota Perpustakaan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                @if(session('success')) 
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div> 
                @endif

                @if(session('error'))
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 font-bold border border-red-300 shadow-sm">
                        {{ session('error') }}
                    </div>
                @endif
                
                <table class="min-w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2 text-left">Nama</th>
                        <th class="border px-4 py-2 text-left">ID Anggota / NIM</th>
                        <th class="border px-4 py-2 text-left">Email</th>
                        <th class="border px-4 py-2 text-left">Kontak / HP</th>
                        <th class="border px-4 py-2 text-center">Tanggal Daftar</th>
                        <th class="border px-4 py-2 text-center">Aksi</th>
                    </tr>
                    @foreach($members as $member)
                    <tr>
                        <td class="border px-4 py-2 font-semibold">{{ $member->name }}</td>
                        <td class="border px-4 py-2">{{ $member->id_anggota ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $member->email }}</td>
                        <td class="border px-4 py-2">{{ $member->kontak ?? '-' }}</td>
                        <td class="border px-4 py-2 text-center">{{ $member->created_at->format('d M Y') }}</td>
                        <td class="border px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <form action="{{ route('members.promote', $member->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengangkat {{ $member->name }} menjadi Admin?');">
                                    @csrf
                                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white py-1 px-3 rounded text-sm shadow transition">
                                        Jadikan Admin
                                    </button>
                                </form>

                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Peringatan: Yakin ingin menghapus akun {{ $member->name }} secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-1 px-3 rounded text-sm shadow transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @if($members->isEmpty())
                    <tr>
                        <td colspan="6" class="border px-4 py-4 text-center text-gray-500">Belum ada anggota yang terdaftar.</td>
                    </tr>
                    @endif
                </table>

            </div>
        </div>
    </div>
</x-app-layout>