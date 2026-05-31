<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">🕒 Riwayat Peminjaman Anda</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-2xl p-8 border border-gray-100">
                @if(session('success')) 
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6">{{ session('success') }}</div> 
                @endif
                
                <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tenggat Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Sisa Hari</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estimasi Denda</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($borrowings as $borrowing)
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $borrowing->book->judul_buku }} <span class="text-gray-400 text-sm font-normal">(x{{ $borrowing->jumlah }})</span></td>
                                <td class="px-6 py-4 text-gray-600">{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    @if(str_contains($borrowing->status, 'Menunggu'))
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $borrowing->status }}</span>
                                    @elseif($borrowing->status == 'Dipinjam')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $borrowing->status }}</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $borrowing->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($borrowing->tenggat_waktu)
                                        @php
                                            $dueDate = \Carbon\Carbon::parse($borrowing->tenggat_waktu);
                                        @endphp
                                        @if($borrowing->is_overdue)
                                            <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">{{ $dueDate->format('d M Y') }} (Terlambat)</span>
                                        @else
                                            <span class="text-gray-600">{{ $dueDate->format('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($borrowing->remaining_days !== null)
                                        @if($borrowing->remaining_days > 0)
                                            <span class="text-green-600 font-semibold bg-green-50 px-2 py-1 rounded">{{ $borrowing->remaining_days }} hari</span>
                                        @elseif($borrowing->remaining_days == 0)
                                            <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">{{ $borrowing->days_late }} hari terlambat</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($borrowing->estimated_fine > 0)
                                        <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">Rp {{ number_format($borrowing->estimated_fine, 0, ',', '.') }}</span>
                                    @elseif($borrowing->remaining_days !== null && $borrowing->remaining_days > 0)
                                        <span class="text-gray-500 text-sm">Rp 0</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($borrowings->isEmpty())
                                <tr><td colspan="6" class="px-6 py-12 text-center text-gray-500">Anda belum memiliki riwayat peminjaman.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>