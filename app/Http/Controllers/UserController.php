<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users except admins
        $members = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('members.index', compact('members'));
    }
    public function promote($id)
    {
        // 🛡️ THE BOUNCER CHECK
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Hanya Admin yang dapat mengubah hak akses.');
        }

        $user = User::findOrFail($id);
        $user->update(['role' => 'admin']);

        return back()->with('success', $user->name . ' berhasil diangkat menjadi Admin!');
    }
    public function destroy($id)
    {
        // 🛡️ THE BOUNCER CHECK
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses Ditolak.');
        }

        $user = User::findOrFail($id);

        // 🛡️ PROTEKSI 1: Jangan hapus jika masih pinjam buku (Aktif)
        $activeBorrowings = \App\Models\Borrowing::where('user_id', $id)
            ->whereIn('status', ['Menunggu Persetujuan Pinjam', 'Dipinjam', 'Menunggu Persetujuan Kembali'])
            ->count();

        if ($activeBorrowings > 0) {
            return back()->with('error', '⚠️ Gagal: Akun tidak dapat dihapus karena anggota ini masih meminjam buku!');
        }

        // 🧹 FIX: Bersihkan riwayat peminjaman lama (Dikembalikan/Ditolak) agar MySQL mengizinkan penghapusan akun
        \App\Models\Borrowing::where('user_id', $id)->delete();

        // Sekarang aman untuk menghapus user
        $user->delete();

        return back()->with('success', 'Akun anggota dan riwayat peminjamannya berhasil dihapus dari sistem.');
    }
}