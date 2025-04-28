<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductsController;
use App\Http\Controllers\Web\UsersController;

Route::get('register', [UsersController::class, 'register'])->name('register');
Route::post('register', [UsersController::class, 'doRegister'])->name('do_register');
Route::get('login', [UsersController::class, 'login'])->name('login');
Route::post('login', [UsersController::class, 'doLogin'])->name('do_login');
Route::get('logout', [UsersController::class, 'doLogout'])->name('do_logout');
Route::get('users', [UsersController::class, 'list'])->name('users_list');
Route::get('profile/{user?}', [UsersController::class, 'profile'])->name('profile');
Route::get('users/edit/{user?}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('users/save/{user}', [UsersController::class, 'save'])->name('users_save');
Route::delete('users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete')->middleware('auth:web');
Route::get('users/edit_password/{user?}', [UsersController::class, 'editPassword'])->name('edit_password');
Route::post('users/save_password/{user}', [UsersController::class, 'savePassword'])->name('save_password');
Route::get('users/create-employee', [UsersController::class, 'createEmployee'])->name('create_employee')->middleware('auth:web');
Route::post('users/store-employee', [UsersController::class, 'storeEmployee'])->name('store_employee')->middleware('auth:web');

Route::get('users/change-password/{id}', [UsersController::class, 'changePassword'])->name('users.change-password')->middleware('auth:web');
Route::post('users/update-password/{id}', [UsersController::class, 'updatePassword'])->name('users.update-password')->middleware('auth:web');
Route::post('/users/{user}/add-credit', [UsersController::class, 'addCredit'])->name('users_add_credit');
Route::get('/users', [UsersController::class, 'list'])->name('users_list');
Route::get('/users/edit/{id}', [UsersController::class, 'edit'])->name('users_edit');
Route::post('/users/save', [UsersController::class, 'save'])->name('users_save');
Route::delete('/users/delete/{user}', [UsersController::class, 'delete'])->name('users_delete');
Route::post('/users/add-credit/{user}', [UsersController::class, 'addCredit'])->name('users_add_credit'); 
Route::get('/customers', [UsersController::class, 'listCustomers'])->name('customers_list');
Route::post('/users/{user}/make-payment', [UsersController::class, 'makePayment'])->name('users_make_payment');
Route::post('/users/reset-credit/{user}', [UsersController::class, 'resetCredit'])->name('reset_credit');

Route::get('products', [ProductsController::class, 'list'])->name('products_list');
Route::get('products/edit/{product?}', [ProductsController::class, 'edit'])->name('products_edit');
Route::post('products/save/{product?}', [ProductsController::class, 'save'])->name('products_save');
Route::delete('/products/delete/{product}', [ProductsController::class, 'delete'])->name('products_delete');
Route::post('products/purchase/{product}', [ProductsController::class, 'purchase'])->name('products_purchase')->middleware('auth:web');


Route::get('password/request', [UsersController::class, 'showForgetPasswordForm'])->name('password.request');

Route::post('password/email', [UsersController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset', [UsersController::class, 'showResetPasswordForm'])->name('password.reset');

Route::post('password/reset', [UsersController::class, 'resetPassword'])->name('password.update');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/multable', function (Request $request) {
    $j = $request->number ?? 5;
    $msg = $request->msg;
    return view('multable', compact("j", "msg"));
})->name('multable');
Route::get('/even', function () {
    return view('even');
});

Route::get('/prime', function () {
    return view('prime');
});

// Route::get('/test', function () {
//     return view('test');
// });
Route::get('/test', [UsersController::class, 'test'])->name('test');