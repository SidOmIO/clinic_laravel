<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAddUserController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin_add', [AdminAddUserController::class, 'index'])
->middleware(['auth', 'verified'])
->name('admin_add');

Route::get('/appointment', [AppointmentsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('appointment');

Route::get('/consultation', [ConsultationsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('consultation');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
