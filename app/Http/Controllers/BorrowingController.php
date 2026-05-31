<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index() {
        $borrowings = Borrowing::where('user_id', Auth::id())->with('book')->get();
        return view('borrowings.index', compact('borrowings'));
    }

    public function store(Request $request) {
        $request->validate([
            'book_id' => 'required',
            'jumlah' => 'required|integer|min:1'
        ]);

        $book = Book::findOrFail($request->book_id);

        if ($book->stok < $request->jumlah) {
            return back()->with('error', 'Stok buku tidak mencukupi!');
        }

        Borrowing::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => now(),
            // Set due date to 7 days from now
            'tenggat_waktu' => now()->addDays(7), 
            'status' => 'Menunggu Persetujuan Pinjam',
        ]);

        return back()->with('success', 'Permintaan pinjam terkirim!');
    }

    public function returnBook($id) {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->update(['status' => 'Menunggu Persetujuan Kembali']);
        return back()->with('success', 'Permintaan kembali terkirim!');
    }

    public function adminIndex(Request $request) {
        $query = Borrowing::with(['user', 'book']);
        
        // Search by user name
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter by overdue
        if ($request->has('overdue') && $request->overdue == 'yes') {
            $query->where('status', 'Dipinjam')
                  ->where('tenggat_waktu', '<', now());
        }
        
        $borrowings = $query->orderBy('created_at', 'desc')->get();
        
        return view('borrowings.admin', compact('borrowings'));
    }

    public function approveBorrow($id) {
        $borrowing = Borrowing::findOrFail($id);
        $book = $borrowing->book;

        if ($book->stok < $borrowing->jumlah) {
            return back()->with('error','Stok buku habis!');
        }

        $borrowing->update([
            'status' => 'Dipinjam',
            'approved_at' => now()
        ]);
        
        $book->decrement('stok', $borrowing->jumlah);
        return back()->with('success', 'Peminjaman disetujui!');
    }

    public function approveReturn($id) {
        $borrowing = Borrowing::findOrFail($id);
        
        // 💰 FINE (DENDA) CALCULATION LOGIC
        $dueDate = Carbon::parse($borrowing->tenggat_waktu);
        $returnDate = now();
        $denda = 0;

        if ($returnDate->gt($dueDate)) {
            $daysLate = $returnDate->diffInDays($dueDate);
            $denda = $daysLate * 5000; // Rp 5.000 per hari keterlambatan
        }

        $borrowing->update([
            'status' => 'Dikembalikan',
            'denda' => $denda
        ]);
        
        $borrowing->book->increment('stok', $borrowing->jumlah);
        
        if ($denda > 0) {
            return back()->with('success', 'Pengembalian disetujui. Terdapat denda sebesar Rp ' . number_format($denda, 0, ',', '.'));
        }

        return back()->with('success', 'Pengembalian disetujui tanpa denda!');
    }

    public function rejectBorrow($id) {
        Borrowing::findOrFail($id)->update(['status' => 'Ditolak']);
        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function exportCSV() {
        $borrowings = Borrowing::with(['user', 'book'])->orderBy('created_at', 'desc')->get();
        
        $filename = "laporan_peminjaman_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        // Add BOM for UTF-8
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        // CSV Header
        fputcsv($handle, [
            'ID',
            'Peminjam',
            'Buku',
            'Jumlah',
            'Tanggal Pinjam',
            'Tenggat Waktu',
            'Status',
            'Denda',
            'Tanggal Dibuat'
        ], ';');
        
        // CSV Data
        foreach ($borrowings as $borrowing) {
            fputcsv($handle, [
                $borrowing->id,
                $borrowing->user->name,
                $borrowing->book->judul_buku,
                $borrowing->jumlah,
                $borrowing->tanggal_pinjam ? Carbon::parse($borrowing->tanggal_pinjam)->format('d/m/Y') : '-',
                $borrowing->tenggat_waktu ? Carbon::parse($borrowing->tenggat_waktu)->format('d/m/Y') : '-',
                $borrowing->status,
                'Rp ' . number_format($borrowing->denda, 0, ',', '.'),
                $borrowing->created_at->format('d/m/Y H:i')
            ], ';');
        }
        
        fclose($handle);
        exit;
    }
}