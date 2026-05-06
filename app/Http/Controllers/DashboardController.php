<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUsers = User::count();
            $totalEquipments = Equipment::count();
            $totalLoans = Loan::count();
            $pendingLoans = Loan::where('status', 'Menunggu Persetujuan Pinjam')->count();
            $borrowedLoans = Loan::where('status', 'Dipinjam')->count();

            return view('dashboard', compact(
                'totalUsers',
                'totalEquipments',
                'totalLoans',
                'pendingLoans',
                'borrowedLoans'
            ));
        } else {
            $activeLoans = Loan::where('user_id', $user->id)
                ->where('status', 'Dipinjam')->count();
            $returnedLoans = Loan::where('user_id', $user->id)
                ->where('status', 'Dikembalikan')->count();
            $availableEquipments = Equipment::where('stok', '>', 0)->count();

            return view('dashboard', compact(
                'activeLoans',
                'returnedLoans',
                'availableEquipments'
            ));
        }
    }
}
