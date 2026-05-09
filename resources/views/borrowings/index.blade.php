<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800">Riwayat Peminjaman Anda</h2></x-slot>

    <div class="py-12"><div class="max-w-7xl mx-auto sm:px-6 lg:px-8"><div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if(session('success')) <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div> @endif
        
        <table class="min-w-full border border-gray-300">
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Judul Buku</th>
                <th class="border px-4 py-2">Tanggal Pinjam</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Tenggat Waktu</th>
            </tr>
            @foreach($borrowings as $borrowing)
            <tr>
                <td class="border px-4 py-2">{{ $borrowing->book->judul_buku }} (x{{ $borrowing->jumlah }})</td>
                <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                <td class="border px-4 py-2 font-bold">{{ $borrowing->status }}</td>
                <td class="border px-4 py-2">
                    @if($borrowing->tenggat_waktu)
                        @php
                            $dueDate = \Carbon\Carbon::parse($borrowing->tenggat_waktu);
                            $isOverdue = $dueDate->isPast() && in_array($borrowing->status, ['Dipinjam', 'Menunggu Persetujuan Kembali']);
                        @endphp

                        @if($isOverdue)
                            <span class="text-red-600 font-bold">{{ $dueDate->format('d M Y') }} (Terlambat!)</span>
                        @else
                            {{ $dueDate->format('d M Y') }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
    </div></div></div>
</x-app-layout>