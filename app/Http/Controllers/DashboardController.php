<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

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

            return view('dashboard', compact(
                'totalUsers',
                'totalBooks',
                'totalBorrowings',
                'pendingBorrowings',
                'activeBorrowings'
            ));
        } else {
            $activeBorrowings = Borrowing::where('user_id', $user->id)
                ->whereIn('status', ['Dipinjam', 'Menunggu Persetujuan Kembali'])->count();
            $returnedBorrowings = Borrowing::where('user_id', $user->id)
                ->where('status', 'Dikembalikan')->count();
            $availableBooks = Book::where('stok', '>', 0)->count();

            return view('dashboard', compact(
                'activeBorrowings',
                'returnedBorrowings',
                'availableBooks'
            ));
        }
    }
}