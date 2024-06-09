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

Route::get('/appointments', [AppointmentsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('appointments');

Route::get('/consultation', [ConsultationsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('consultation');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/appointments/add', [AppointmentsController::class, 'add'])->name('appointments.add')->middleware('auth');
    Route::post('/appointments', [AppointmentsController::class, 'store'])->name('appointments.store')->middleware('auth');
    Route::get('/appointments/edit/{id}', [AppointmentsController::class, 'edit'])->name('appointments.edit');
    Route::post('/appointments/update', [AppointmentsController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/consultations/{id}', [AppointmentsController::class, 'showConsultation'])->name('consultations.show');
});

require __DIR__.'/auth.php';
