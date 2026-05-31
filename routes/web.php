<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('books', BookController::class);

    // Admin Categories
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Admin Members
   // Admin Members
    Route::get('/members', [App\Http\Controllers\UserController::class, 'index'])->name('members.index');
    Route::post('/members/{id}/promote', [App\Http\Controllers\UserController::class, 'promote'])->name('members.promote');
    Route::delete('/members/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('members.destroy');
    // Peminjaman (MAHASISWA)
    Route::post('/borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/riwayat-pinjam', [BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Peminjaman (ADMIN)
    Route::get('/laporan-pinjam', [BorrowingController::class, 'adminIndex'])->name('borrowings.admin');
    Route::post('/borrowings/{id}/approve-borrow', [BorrowingController::class, 'approveBorrow'])->name('borrowings.approve_borrow');
    Route::post('/borrowings/{id}/approve-return', [BorrowingController::class, 'approveReturn'])->name('borrowings.approve_return');
    Route::post('/borrowings/{id}/reject-borrow', [BorrowingController::class, 'rejectBorrow'])->name('borrowings.reject_borrow');
    Route::get('/laporan-pinjam/export', [BorrowingController::class, 'exportCSV'])->name('borrowings.export'); 
    
    // Admin Books
    Route::delete('/books/{id}', [BookController::class, 'destroy'])
        ->name('books.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';