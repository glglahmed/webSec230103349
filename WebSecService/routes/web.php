<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::view('/calculator', 'calculator');
Route::view('/gpa-calculator', 'gpa-calculator');

Route::get('/minitest', function () {
    $bill = [
        ['item' => 'Apples', 'quantity' => 2, 'price' => 1.50],
        ['item' => 'Bread', 'quantity' => 1, 'price' => 2.00],
        ['item' => 'Milk', 'quantity' => 1, 'price' => 3.00],
    ];
    return view('minitest', compact('bill'));
});

Route::get('/transcript', function () {
    $transcript = [
        ['course' => 'Web Security', 'grade' => 'A', 'credits' => 3],
        ['course' => 'Network Security', 'grade' => 'B+', 'credits' => 3],
        ['course' => 'Cryptography', 'grade' => 'A-', 'credits' => 3],
        ['course' => 'Ethical Hacking', 'grade' => 'B', 'credits' => 2],
        ['course' => 'Digital Forensics', 'grade' => 'A+', 'credits' => 3],
    ];
    return view('transcript', compact('transcript'));
});

// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Route::post('reset-password', [ResetPasswordController::class, 'update'])->name('password.update');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

//     Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
//     Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change-password.form');
//     Route::post('/change-password', [AuthController::class, 'changePassword'])->name('change-password');

//     Route::resource('tasks', TaskController::class)->except(['create', 'edit']);
// });

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/users', AdminController::class)->except(['create', 'show']);
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');