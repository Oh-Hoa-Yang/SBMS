<?php

use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
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
  // Route::resource('manageComplaint',ComplaintController::class);
});

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


// Route::get('manageLogin',[UserController::class,'index'])->name('manageLogin.index');