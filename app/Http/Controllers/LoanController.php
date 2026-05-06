<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    // --- FITUR MAHASISWA ---
    public function index() {
        $loans = Loan::where('user_id', Auth::id())->with('equipment')->get();
        return view('loans.index', compact('loans'));
    }

    public function store(Request $request) {
        $equipment = Equipment::findOrFail($request->equipment_id);

        // Tidak kurangi stok di sini
        Loan::create([
            'user_id' => Auth::id(),
            'equipment_id' => $equipment->id,
            'tanggal_pinjam' => now(),
            'status' => 'Menunggu Persetujuan Pinjam',
        ]);

        return back()->with('success', 'Permintaan pinjam terkirim! Tunggu persetujuan Admin.');
    }

    public function returnEquipment($id) {
        $loan = Loan::findOrFail($id);

        // Update status, stok belum berubah
        $loan->update(['status' => 'Menunggu Persetujuan Kembali']);
        return back()->with('success', 'Permintaan kembali terkirim! Tunggu pengecekan Admin.');
    }

    // --- FITUR ADMIN ---
    public function adminIndex() {
        $loans = Loan::with(['user', 'equipment'])->orderBy('created_at', 'desc')->get();
        return view('loans.admin', compact('loans'));
    }

    public function approveBorrow($id) {
    $loan = Loan::findOrFail($id);
    $equipment = $loan->equipment;
    if ($equipment->stok <= 0) {
        return back()->with('error','Stok alat habis! Tidak bisa menyetujui peminjaman.');
    }
    $loan->update([
        'status' => 'Dipinjam',
        'approved_at' => now()
    ]);
    $equipment->decrement('stok');
    return back()->with('success', 'Peminjaman disetujui! Stok alat telah berkurang.');
    }

    public function approveReturn($id) {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'Dikembalikan']);
        $loan->equipment->increment('stok'); // Tambahkan stok saat pengembalian disetujui
        return back()->with('success', 'Pengembalian disetujui. Stok telah ditambahkan kembali!');
    }

    public function rejectBorrow($id) {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'Ditolak']);
        return back()->with('success', 'Peminjaman ditolak oleh admin.');
    }

    public function rejectReturn($id) {
        $loan = Loan::findOrFail($id);
        $loan->update(['status' => 'Pengembalian Ditolak']);
        return back()->with('success', 'Pengembalian ditolak oleh admin.');
    }
}