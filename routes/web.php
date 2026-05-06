<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoanController;

Route::get('/', function () { return redirect()->route('login'); });

Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('equipments', EquipmentController::class);

    // Fitur Stok
    Route::post('/equipments/{id}/decrease', [EquipmentController::class, 'decreaseStock'])->name('equipments.decrease');
    Route::post('/equipments/{id}/clear', [EquipmentController::class, 'clearStock'])->name('equipments.clear');
    Route::post('/equipments/{id}/increase', [EquipmentController::class, 'increaseStock'])->name('equipments.increase');

    // Peminjaman (MAHASISWA)
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
    Route::get('/riwayat-pinjam', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans/{id}/return', [LoanController::class, 'returnEquipment'])->name('loans.return');

    // Peminjaman (ADMIN - PERSETUJUAN)
    Route::get('/laporan-pinjam', [LoanController::class, 'adminIndex'])->name('loans.admin');
    Route::post('/loans/{id}/approve-borrow', [LoanController::class, 'approveBorrow'])->name('loans.approve_borrow');
    Route::post('/loans/{id}/approve-return', [LoanController::class, 'approveReturn'])->name('loans.approve_return');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';