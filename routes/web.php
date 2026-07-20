<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Cliente
Route::get('/catalogo', [App\Http\Controllers\EquipmentController::class, 'index'])->name('catalogo');
Route::get('/equipo/{id}', [App\Http\Controllers\EquipmentController::class, 'show'])->name('equipo.show');
Route::resource('rentals', App\Http\Controllers\RentalController::class)->middleware('auth');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('equipos', App\Http\Controllers\EquipmentController::class);
    Route::resource('categorias', App\Http\Controllers\CategoryController::class);
    Route::get('/solicitudes', [App\Http\Controllers\RentalController::class, 'adminIndex'])->name('admin.rentals');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';