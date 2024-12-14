<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
// use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
  return redirect('/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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

  
  
// Display a list of bookings (index page)
Route::get('/manageBooking', [BookingController::class, 'index'])->name('manageBooking.index');

// Show a form to create a new booking
Route::get('manageBooking/create', [BookingController::class, 'create'])->name('manageBooking.create');

// Show a form to edit an existing booking by ID
Route::get('manageBooking/{id}/edit', [BookingController::class, 'edit'])->name('manageBooking.edit');

// Update an existing booking by ID (PUT request for data submission)
Route::put('manageBooking/{id}', [BookingController::class, 'update'])->name('manageBooking.update');

// Delete an existing booking by ID
Route::delete('manageBooking/{id}', [BookingController::class, 'destroy'])->name('manageBooking.destroy');

// Store a new booking (POST request to save data)
Route::post('manageBooking/store', [BookingController::class, 'store'])->name('manageBooking.store');

// Display the details of a specific booking by ID
Route::get('/manageBooking/display/{id}', [BookingController::class, 'display'])->name('manageBooking.display');



});


