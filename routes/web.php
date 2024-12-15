<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;

Route::get('/', function () {
  return redirect('/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Resource route for profile management
    Route::resource('manageProfile', ProfileController::class)->only(['index', 'edit', 'update', 'destroy']);
    
    // Resource route for user management
    Route::resource('manageLogin', UserController::class);
    
    // Resource route for user's complaint
    Route::resource('manageComplaint', ComplaintController::class)->except(['show']);
    
    //Admin Complaint View
    Route::get('manageComplaint/adminIndex', [ComplaintController::class, 'adminIndex'])->name('manageComplaint.adminIndex');
    
    //Admin Complaint Delete
    Route::delete('manageComplaint/adminDestroy/{manageComplaint}', [ComplaintController::class, 'adminDestroy'])->name('manageComplaint.adminDestroy');

    // Stock Management Routes
    Route::prefix('manageStock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('manageStock.index');
        Route::get('/create', [StockController::class, 'create'])->name('manageStock.create');
        Route::post('/', [StockController::class, 'store'])->name('manageStock.store');
        Route::get('/{id}/edit', [StockController::class, 'edit'])->name('manageStock.edit');
        Route::put('/{id}', [StockController::class, 'update'])->name('manageStock.update');
        Route::delete('/{id}', [StockController::class, 'destroy'])->name('manageStock.destroy');
    });
    
    // Booking Routes
    Route::prefix('manageBooking')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('manageBooking.index');
        Route::get('/create', [BookingController::class, 'create'])->name('manageBooking.create');
        Route::post('/store', [BookingController::class, 'store'])->name('manageBook
ing.store');
        Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('manageBooking.edit');
        Route::put('/{id}', [BookingController::class, 'update'])->name('manageBooking.update');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('manageBooking.destroy');
        Route::get('/display/{id}', [BookingController::class, 'display'])->name('manageBooking.display');
    });
});