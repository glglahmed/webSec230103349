<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'changePassword']);


Route::get('/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password.form')->middleware('auth');
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'update'])->name('password.update');

Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password.form');

Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

