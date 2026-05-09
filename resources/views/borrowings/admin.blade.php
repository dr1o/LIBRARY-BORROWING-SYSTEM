<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Sirkulasi & Persetujuan Peminjaman</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">{{ session('error') }}</div>
                @endif

                <table class="min-w-full border border-gray-300">
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Peminjam</th>
                        <th class="border px-4 py-2">Buku</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Tenggat Waktu</th>
                        <th class="border px-4 py-2 text-red-600">Denda</th>
                        <th class="border px-4 py-2 text-center">Aksi (Admin)</th>
                    </tr>
                    @foreach ($borrowings as $borrowing)
                    <tr>
                        <td class="border px-4 py-2">{{ $borrowing->user->name }}</td>
                        <td class="border px-4 py-2">{{ $borrowing->book->judul_buku }} (x{{ $borrowing->jumlah }})</td>
                        <td class="border px-4 py-2 font-bold">{{ $borrowing->status }}</td>
                        <td class="border px-4 py-2">
                            @if($borrowing->tenggat_waktu)
                                {{ \Carbon\Carbon::parse($borrowing->tenggat_waktu)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-right">
                            Rp {{ number_format($borrowing->denda, 0, ',', '.') }}
                        </td>
                        <td class="border px-4 py-2 text-center">
                            @if ($borrowing->status == 'Menunggu Persetujuan Pinjam')
                            <form action="{{ route('borrowings.approve_borrow', $borrowing->id) }}" method="POST" class="inline">
                                @csrf <button class="bg-blue-600 text-white py-1 px-3 rounded">Setujui Pinjam</button>
                            </form>
                            <form action="{{ route('borrowings.reject_borrow', $borrowing->id) }}" method="POST" class="inline">
                                @csrf <button class="bg-red-600 text-white py-1 px-3 rounded ml-2">Tolak</button>
                            </form>

                            @elseif($borrowing->status == 'Dipinjam' || $borrowing->status == 'Menunggu Persetujuan Kembali')
                            <form action="{{ route('borrowings.approve_return', $borrowing->id) }}" method="POST" class="inline">
                                @csrf <button class="bg-green-600 text-white py-1 px-3 rounded">Terima Pengembalian</button>
                            </form>
                            @else
                            <span class="text-gray-400">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</x-app-layout>