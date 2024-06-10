<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAddUserController;
use App\Http\Controllers\AppointmentsController;
use App\Http\Controllers\ConsultationsController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckAdminAndPatient;
use App\Http\Middleware\CheckDoctor;
use App\Http\Middleware\CheckPatient;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/consultations', [ConsultationsController::class, 'index'])->name('consultations');
    Route::get('/consultations/details', [ConsultationsController::class, 'details'])->name('consultations.details');

    Route::middleware(CheckAdmin::class)->group(function () {
        Route::get('/admin/add', [AdminAddUserController::class, 'index'])->name('admin/add');
    });

    Route::middleware(CheckDoctor::class)->group(function () {
        Route::get('/consultations/remark', [ConsultationsController::class, 'remark'])->name('consultations.remark');
        Route::post('/consultations/storeRemark', [ConsultationsController::class, 'storeRemark'])->name('consultations.storeRemark');
    });

    Route::middleware(CheckPatient::class)->group(function () {
        Route::get('/appointments/add', [AppointmentsController::class, 'add'])->name('appointments.add');
        Route::post('/appointments', [AppointmentsController::class, 'store'])->name('appointments.store');
        Route::post('/consultations/checkout', [StripePaymentController::class, 'checkout'])->name('consultations.checkout');
        Route::get('/payment/completed', [StripePaymentController::class, 'completed'])->name('payment.completed');
        Route::post('/consultations/invoice', [InvoiceController::class, 'generateInvoice'])->name('invoice.generate');
    });

    Route::middleware([CheckAdminAndPatient::class])->group(function () {
        Route::get('/appointments', [AppointmentsController::class, 'index'])->name('appointments');
        Route::get('/appointments/edit/{id}', [AppointmentsController::class, 'edit'])->name('appointments.edit');
        Route::post('/appointments/update', [AppointmentsController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{id}', [AppointmentsController::class, 'destroy'])->name('appointments.destroy');
    });
});

require __DIR__.'/auth.php';
