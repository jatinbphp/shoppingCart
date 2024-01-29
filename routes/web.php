<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ------------------main routes------------------------------------------


Route::get('/admin', [AuthorizationController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/adminLogin', [AuthorizationController::class, 'adminLogin'])->name('admin.signin');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [AuthorizationController::class, 'adminLogout'])->name('admin.logout');
    // Route::resource('user', [UserController::class, 'index'])->name('admin.user');
    Route::post('users/assign', [UserController::class,'assign'])->name('users.assign');
    Route::post('users/unassign', [UserController::class,'unassign'])->name('users.unassign');
    Route::resource('users', UserController::class);
});
