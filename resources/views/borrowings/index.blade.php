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
                
                <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Judul Buku</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tenggat Waktu</th>
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
                                            $isOverdue = $dueDate->isPast() && in_array($borrowing->status, ['Dipinjam', 'Menunggu Persetujuan Kembali']);
                                        @endphp
                                        @if($isOverdue)
                                            <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">{{ $dueDate->format('d M Y') }} (Terlambat)</span>
                                        @else
                                            <span class="text-gray-600">{{ $dueDate->format('d M Y') }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if($borrowings->isEmpty())
                                <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">Anda belum memiliki riwayat peminjaman.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="grid grid-cols-1 gap-4 md:hidden">
                    @foreach($borrowings as $borrowing)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col gap-2">
                        <div class="font-bold text-gray-900 border-b pb-2">{{ $borrowing->book->judul_buku }} <span class="text-gray-400 text-sm font-normal">(x{{ $borrowing->jumlah }})</span></div>
                        <div class="flex justify-between items-center mt-2 text-sm">
                            <span class="text-gray-500">Tanggal Pinjam:</span>
                            <span class="text-gray-900 font-semibold">{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Tenggat Waktu:</span>
                            @if($borrowing->tenggat_waktu)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($borrowing->tenggat_waktu);
                                    $isOverdue = $dueDate->isPast() && in_array($borrowing->status, ['Dipinjam', 'Menunggu Persetujuan Kembali']);
                                @endphp
                                @if($isOverdue)
                                    <span class="text-red-600 font-bold bg-red-50 px-2 py-1 rounded">{{ $dueDate->format('d M Y') }} (Terlambat)</span>
                                @else
                                    <span class="text-gray-700 font-semibold">{{ $dueDate->format('d M Y') }}</span>
                                @endif
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </div>
                        <div class="mt-2 text-right">
                            @if(str_contains($borrowing->status, 'Menunggu'))
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">{{ $borrowing->status }}</span>
                            @elseif($borrowing->status == 'Dipinjam')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">{{ $borrowing->status }}</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $borrowing->status }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @if($borrowings->isEmpty())
                        <div class="text-center text-gray-500 p-4 border border-gray-200 rounded-xl">Anda belum memiliki riwayat peminjaman.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>