<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAddUserController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/admin/add', [AdminAddUserController::class, 'index'])
->middleware(['auth', 'verified'])
->name('admin/add');

Route::get('/appointments', [AppointmentsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('appointments');

Route::get('/consultations', [ConsultationsController::class, 'index'])
->middleware(['auth', 'verified'])
->name('consultations');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/appointments/add', [AppointmentsController::class, 'add'])->name('appointments.add')->middleware('auth');
    Route::post('/appointments', [AppointmentsController::class, 'store'])->name('appointments.store')->middleware('auth');
    Route::get('/appointments/edit/{id}', [AppointmentsController::class, 'edit'])->name('appointments.edit');
    Route::post('/appointments/update', [AppointmentsController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{id}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');

    Route::get('/consultations/remark', [ConsultationsController::class, 'remark'])->name('consultations.remark');
    Route::post('/consultations/storeRemark', [ConsultationsController::class, 'storeRemark'])->name('consultations.storeRemark')->middleware('auth');
    Route::get('/consultations/details', [ConsultationsController::class, 'details'])->name('consultations.details');

    Route::post('/consultations/checkout', [StripePaymentController::class, 'checkout'])->name('consultations.checkout');
    Route::get('/payment/completed', [StripePaymentController::class, 'completed'])->name('payment.completed');

    Route::post('/consultations/invoice', [InvoiceController::class, 'generateInvoice'])->name('invoice.generate');

});

require __DIR__.'/auth.php';
