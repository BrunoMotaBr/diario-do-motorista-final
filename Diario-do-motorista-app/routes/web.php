<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroDeGastosController;
use App\Http\Controllers\RegistroTrabalhoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/registro', [RegistroTrabalhoController::class, 'create'])
        ->name('registro.create');

    Route::post('/registro', [RegistroTrabalhoController::class, 'store'])
        ->name('registro.store');

    Route::get('/registro/detalhe/{data?}', [RegistroTrabalhoController::class, 'show'])
        ->name('registro.show');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/registro-gastos', [RegistroDeGastosController ::class, 'create'])
        ->name('registro-gastos.create');

    Route::post('/registro-gastos', [RegistroDeGastosController::class, 'store'])
        ->name('registro-gastos.store');
});


require __DIR__.'/auth.php';
