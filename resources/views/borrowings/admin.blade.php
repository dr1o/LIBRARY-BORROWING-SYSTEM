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

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Peminjaman</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('borrowings.export') }}" class="bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg flex items-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ekspor CSV
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <form action="{{ route('borrowings.admin') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peminjam..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="w-full md:w-48">
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua Status</option>
                                <option value="Menunggu Persetujuan Pinjam" {{ request('status') == 'Menunggu Persetujuan Pinjam' ? 'selected' : '' }}>Menunggu Persetujuan Pinjam</option>
                                <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                <option value="Menunggu Persetujuan Kembali" {{ request('status') == 'Menunggu Persetujuan Kembali' ? 'selected' : '' }}>Menunggu Persetujuan Kembali</option>
                                <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                        <div class="w-full md:w-48">
                            <select name="overdue" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Semua</option>
                                <option value="yes" {{ request('overdue') == 'yes' ? 'selected' : '' }}>Hanya Terlambat</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Filter
                        </button>
                        <a href="{{ route('borrowings.admin') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition-colors text-center">
                            Reset
                        </a>
                    </form>
                </div>

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
                    <tr class="{{ $borrowing->is_overdue && $borrowing->status == 'Dipinjam' ? 'bg-red-50' : '' }}">
                        <td class="border px-4 py-2">
                            {{ $borrowing->user->name }}
                            @if($borrowing->is_overdue && $borrowing->status == 'Dipinjam')
                                <span class="ml-2 inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                                    ⚠️ Terlambat
                                </span>
                            @endif
                        </td>
                        <td class="border px-4 py-2">{{ $borrowing->book->judul_buku }} (x{{ $borrowing->jumlah }})</td>
                        <td class="border px-4 py-2 font-bold">{{ $borrowing->status }}</td>
                        <td class="border px-4 py-2">
                            @if($borrowing->tenggat_waktu)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($borrowing->tenggat_waktu);
                                @endphp
                                @if($borrowing->is_overdue && $borrowing->status == 'Dipinjam')
                                    <span class="text-red-600 font-bold">{{ $dueDate->format('d M Y') }}</span>
                                @else
                                    {{ $dueDate->format('d M Y') }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="border px-4 py-2 text-right">
                            @if($borrowing->estimated_fine > 0 && $borrowing->status == 'Dipinjam')
                                <span class="text-red-600 font-bold">Rp {{ number_format($borrowing->estimated_fine, 0, ',', '.') }} (est)</span>
                            @else
                                Rp {{ number_format($borrowing->denda, 0, ',', '.') }}
                            @endif
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