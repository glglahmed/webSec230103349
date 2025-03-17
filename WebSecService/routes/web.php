<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdminController;

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
Route::get('/calculator', function () {
    return view('calculator');
});
Route::get('/gpa-calculator', function () {
    $courses = [
        ['code' => 'CS101', 'title' => 'Introduction to CS', 'credits' => 3],
        ['code' => 'CS202', 'title' => 'Data Structures', 'credits' => 4],
        ['code' => 'CS303', 'title' => 'Operating Systems', 'credits' => 3],
        ['code' => 'CS404', 'title' => 'Web Security', 'credits' => 3],
    ];
    return view('gpa-calculator', compact('courses'));
});


Route::resource('grades', GradeController::class);


Route::resource('questions', QuestionController::class);

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
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
});

    

// Rout::get(uri:'/test',function () {
//     return view(view:'test')

// });
