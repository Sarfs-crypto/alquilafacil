<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Zona cliente (requiere autenticación)
Route::middleware(['auth'])->group(function () {
    Route::get('/catalogo', [EquipmentController::class, 'index'])->name('catalogo');
    Route::get('/equipo/{id}', [EquipmentController::class, 'show'])->name('equipo.show');
    Route::get('/rental/crear', [RentalController::class, 'create'])->name('rental.create');
    Route::post('/rental/solicitar', [RentalController::class, 'store'])->name('rental.store');
    Route::get('/mis-alquileres', [RentalController::class, 'index'])->name('rentals.index');
    Route::patch('/rental/{id}/cancelar', [RentalController::class, 'cancel'])->name('rental.cancel');
});

// Zona admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::resource('equipos', EquipmentController::class);
    Route::resource('categorias', CategoryController::class);
    Route::get('/solicitudes', [RentalController::class, 'adminIndex'])->name('admin.rentals');
    Route::patch('/rental/{id}/aprobar', [RentalController::class, 'approve'])->name('rental.approve');
    Route::patch('/rental/{id}/devolver', [RentalController::class, 'return'])->name('rental.return');
    Route::patch('/equipo/{id}/mantenimiento', [EquipmentController::class, 'setMaintenance'])->name('equipo.maintenance');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

require __DIR__.'/auth.php';