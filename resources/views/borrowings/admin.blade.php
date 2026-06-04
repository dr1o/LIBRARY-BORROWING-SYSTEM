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

                <div class="hidden md:block overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
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

                <!-- Mobile Cards -->
                <div class="grid grid-cols-1 gap-4 md:hidden">
                    @foreach ($borrowings as $borrowing)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col gap-2">
                        <div class="border-b pb-2 mb-1 flex justify-between items-start">
                            <div>
                                <span class="font-bold text-gray-900 block">{{ $borrowing->user->name }}</span>
                                <span class="text-gray-600 text-sm block mt-1">{{ $borrowing->book->judul_buku }} (x{{ $borrowing->jumlah }})</span>
                            </div>
                            <span class="text-xs font-bold px-2 py-1 bg-gray-100 rounded-full text-center">{{ $borrowing->status }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Tenggat:</span>
                            <span class="font-semibold">{{ $borrowing->tenggat_waktu ? \Carbon\Carbon::parse($borrowing->tenggat_waktu)->format('d M Y') : '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Denda:</span>
                            <span class="font-bold text-red-600">Rp {{ number_format($borrowing->denda, 0, ',', '.') }}</span>
                        </div>
                        <div class="mt-3 flex gap-2">
                            @if ($borrowing->status == 'Menunggu Persetujuan Pinjam')
                                <form action="{{ route('borrowings.approve_borrow', $borrowing->id) }}" method="POST" class="flex-1">
                                    @csrf <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold shadow">Setujui</button>
                                </form>
                                <form action="{{ route('borrowings.reject_borrow', $borrowing->id) }}" method="POST" class="flex-1">
                                    @csrf <button class="w-full bg-red-600 text-white py-2 rounded-lg text-sm font-semibold shadow">Tolak</button>
                                </form>
                            @elseif($borrowing->status == 'Dipinjam' || $borrowing->status == 'Menunggu Persetujuan Kembali')
                                <form action="{{ route('borrowings.approve_return', $borrowing->id) }}" method="POST" class="w-full">
                                    @csrf <button class="w-full bg-green-600 text-white py-2 rounded-lg text-sm font-semibold shadow">Terima Pengembalian</button>
                                </form>
                            @else
                                <div class="w-full text-center text-gray-400 py-2 bg-gray-50 rounded-lg text-sm border border-gray-100">Selesai</div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    @if($borrowings->isEmpty())
                        <div class="text-center text-gray-500 p-4 border border-gray-200 rounded-xl">Belum ada peminjaman.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>