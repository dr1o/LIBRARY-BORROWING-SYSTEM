<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalBooks = Book::count();
            $totalBorrowings = Borrowing::count();
            $pendingBorrowings = Borrowing::where('status', 'Menunggu Persetujuan Pinjam')->count();
            $activeBorrowings = Borrowing::whereIn('status', ['Dipinjam', 'Menunggu Persetujuan Kembali'])->count();
            $overdueBorrowings = Borrowing::where('status', 'Dipinjam')
                ->where('tenggat_waktu', '<', Carbon::now())->count();
            $totalFines = Borrowing::where('denda', '>', 0)->sum('denda');
            $pendingReturns = Borrowing::where('status', 'Menunggu Persetujuan Kembali')->count();

            return view('dashboard', compact(
                'totalUsers',
                'totalBooks',
                'totalBorrowings',
                'pendingBorrowings',
                'activeBorrowings',
                'overdueBorrowings',
                'totalFines',
                'pendingReturns'
            ));
        } else {
            $activeBorrowings = Borrowing::where('user_id', $user->id)
                ->whereIn('status', ['Dipinjam', 'Menunggu Persetujuan Kembali'])->count();
            $returnedBorrowings = Borrowing::where('user_id', $user->id)
                ->where('status', 'Dikembalikan')->count();
            $availableBooks = Book::where('stok', '>', 0)->count();
            $userOverdueBorrowings = Borrowing::where('user_id', $user->id)
                ->where('status', 'Dipinjam')
                ->where('tenggat_waktu', '<', Carbon::now())->count();
            $userTotalFines = Borrowing::where('user_id', $user->id)
                ->where('denda', '>', 0)->sum('denda');

            return view('dashboard', compact(
                'activeBorrowings',
                'returnedBorrowings',
                'availableBooks',
                'userOverdueBorrowings',
                'userTotalFines'
            ));
        }
    }
}