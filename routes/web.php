<?php

use App\Http\Controllers\AimlController;
use App\Http\Controllers\authController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\userController;
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
    return redirect('/dashboard');
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', userController::class)->middleware('auth');
    Route::post('/user/reset-password', [userController::class, 'resetPasswordAdmin'])->name('user.password')->middleware('auth');
    Route::resource('/aiml', AimlController::class)->middleware('auth');
    Route::resource('/mahasiswa', MahasiswaController::class)->middleware('auth');
});
Route::controller(authController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout');
});

Route::resource('/register', RegisterController::class)->middleware('guest');
