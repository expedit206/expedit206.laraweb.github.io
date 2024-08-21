<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/**
 * admin
 */
Route::middleware('admin')->prefix('admin')->group(function () {
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::prefix('admin')->group(function () {
Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/login-submit', [AdminController::class, 'login_submit'])->name('admin.login.submit');

Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::get('/forget-password', [AdminController::class, 'forget_password'])->name('admin.forget.password');
Route::post('/forget-password-submit', [AdminController::class, 'forget_password_submit'])->name('admin.forget.password.submit');

Route::get('/reset-password/{token}/{email}', [AdminController::class, 'reset_password']);
Route::post('/reset.password.submit', [AdminController::class, 'reset_password_submit'])->name('admin.reset.password.submit');
}); 