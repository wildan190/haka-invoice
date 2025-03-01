<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/{id}', [CustomerController::class, 'show'])->name('customers.show');
        Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::put('/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::delete('/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    });

    Route::prefix('mobils')->group(function () {
        Route::get('/', [MobilController::class, 'index'])->name('mobils.index');
        Route::get('/create', [MobilController::class, 'create'])->name('mobils.create');
        Route::post('/', [MobilController::class, 'store'])->name('mobils.store');
        Route::get('/{id}', [MobilController::class, 'show'])->name('mobils.show');
        Route::get('/{id}/edit', [MobilController::class, 'edit'])->name('mobils.edit');
        Route::put('/{id}', [MobilController::class, 'update'])->name('mobils.update');
        Route::delete('/{id}', [MobilController::class, 'destroy'])->name('mobils.destroy');
    });

    Route::prefix('rentals')->group(function () {
        Route::get('/', [RentalController::class, 'index'])->name('rentals.index');
        Route::get('/create', [RentalController::class, 'create'])->name('rentals.create');
        Route::post('/', [RentalController::class, 'store'])->name('rentals.store');
        Route::get('/{id}', [RentalController::class, 'show'])->name('rentals.show');
        Route::get('/{id}/edit', [RentalController::class, 'edit'])->name('rentals.edit');
        Route::put('/{id}', [RentalController::class, 'update'])->name('rentals.update');
        Route::delete('/{id}', [RentalController::class, 'destroy'])->name('rentals.destroy');
        Route::post('/{id}/pay', [RentalController::class, 'markAsPaid'])->name('rentals.pay');
        Route::get('/rentals/{id}/receipt', [RentalController::class, 'printReceipt'])->name('rentals.receipt');
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/create', [InvoiceController::class, 'create'])->name('invoices.create');
        Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
        Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/{id}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
        Route::get('/{id}/pdf', [InvoiceController::class, 'generatePDF'])->name('invoices.pdf');
    });
});
