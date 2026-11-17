<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PhotoSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    // Дашбоард
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Профіль користувача
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Маршрути для клієнтів
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', [ClientController::class, 'index'])->name('clients.index');
        Route::get('/create', [ClientController::class, 'create'])->middleware('role:admin')->name('clients.create');
        Route::post('/', [ClientController::class, 'store'])->middleware('role:admin')->name('clients.store');
        Route::get('/{client}', [ClientController::class, 'show'])->name('clients.show');
        Route::get('/{client}/edit', [ClientController::class, 'edit'])->middleware('role:admin')->name('clients.edit');
        Route::patch('/{client}', [ClientController::class, 'update'])->middleware('role:admin')->name('clients.update');
        Route::delete('/{client}', [ClientController::class, 'destroy'])->middleware('role:admin')->name('clients.destroy');
    });

    // Маршрути для фотоссесій
    Route::group(['prefix' => 'photo-sessions'], function () {
        Route::get('/', [PhotoSessionController::class, 'index'])->name('photo-sessions.index');
        Route::get('/create', [PhotoSessionController::class, 'create'])->middleware('role:admin')->name('photo-sessions.create');
        Route::post('/', [PhotoSessionController::class, 'store'])->middleware('role:admin')->name('photo-sessions.store');
        Route::get('/{photoSession}', [PhotoSessionController::class, 'show'])->name('photo-sessions.show');
        Route::get('/{photoSession}/edit', [PhotoSessionController::class, 'edit'])->middleware('role:admin')->name('photo-sessions.edit');
        Route::patch('/{photoSession}', [PhotoSessionController::class, 'update'])->middleware('role:admin')->name('photo-sessions.update');
        Route::delete('/{photoSession}', [PhotoSessionController::class, 'destroy'])->middleware('role:admin')->name('photo-sessions.destroy');
    });
});

require __DIR__.'/auth.php';

