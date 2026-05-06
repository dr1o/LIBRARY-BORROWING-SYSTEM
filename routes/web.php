<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipmentController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::resource('equipments', EquipmentController::class);

    // 🔥 fitur stok
    Route::post('/equipments/{id}/decrease', [EquipmentController::class, 'decreaseStock'])
        ->name('equipments.decrease');

    Route::post('/equipments/{id}/clear', [EquipmentController::class, 'clearStock'])
        ->name('equipments.clear');

    Route::post('/equipments/{id}/increase', [EquipmentController::class, 'increaseStock'])
    ->name('equipments.increase');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';