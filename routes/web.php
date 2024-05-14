<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
    return Inertia::render('Welcome');
})->name('home');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->middleware('guest')->name('admin.login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->middleware('guest');
    Route::delete('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:admin')->name('admin.logout');
});

Route::get('/admin/logout-test', function () {
    Auth::guard('user')->logout(); // Or session()->forget('login_web_admin');
    return redirect('/admin/login'); // Redirect to admin login
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});