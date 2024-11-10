<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpKernel\Profiler\Profile;

Route::get('/', function () {
  return redirect('/login');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

 // Resource route for profile management
 Route::resource('manageProfile', ProfileController::class)->only(['index', 'edit', 'update', 'destroy']);

 // Resource route for user management
 Route::resource('manageLogin', UserController::class);

// Route::get('manageLogin',[UserController::class,'index'])->name('manageLogin.index');