<?php

use App\Http\Controllers\AimlController;
use App\Http\Controllers\authController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Http;
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

Route::post('/process_aiml', function (\Illuminate\Http\Request $request) {
    $response = Http::post('http://localhost:5000/process_aiml', [
        'user_input' => $request->input('user_input'),
    ]);

    return $response->json();
});

Route::middleware(['web'])->group(function () {
    Route::get('/chat', function () {
        return view('chat');
    });
});

Route::prefix('/dashboard')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/user', userController::class);
    Route::post('/user/reset-password', [userController::class, 'resetPasswordAdmin'])->name('user.password');
    Route::resource('/aiml', AimlController::class);
    Route::resource('/mahasiswa', MahasiswaController::class);
    Route::resource('/feedback', FeedbackController::class);
});
Route::controller(authController::class)->group(function () {
    Route::get('/login', 'index')->name('login')->middleware('guest');
    Route::post('/login', 'authenticate');
    Route::post('/logout', 'logout');
});

Route::resource('/register', RegisterController::class)->middleware('guest');
