<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;

/*
|--------------------------------------------------------------------------
| Redirect awal → login
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Semua route yang butuh login
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ======================
    // PROFILE
    // ======================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // ======================
    // EQUIPMENTS (CRUD)
    // ======================
    Route::resource('equipments', EquipmentController::class);


    // ======================
    // FITUR STOK
    // ======================
    Route::post('/equipments/{id}/increase', [EquipmentController::class, 'increaseStock'])
        ->name('equipments.increase');

    Route::post('/equipments/{id}/decrease', [EquipmentController::class, 'decreaseStock'])
        ->name('equipments.decrease');

    Route::post('/equipments/{id}/clear', [EquipmentController::class, 'clearStock'])
        ->name('equipments.clear');
});

/*
|--------------------------------------------------------------------------
| Auth (Login, Register, dll)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';