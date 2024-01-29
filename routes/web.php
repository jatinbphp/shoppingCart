<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
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

    /*IMAGE UPLOAD IN SUMMER NOTE*/
    Route::post('image/upload', [ImageController::class,'upload_image']);
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Users*/
    Route::post('users/assign', [UserController::class,'assign'])->name('users.assign');
    Route::post('users/unassign', [UserController::class,'unassign'])->name('users.unassign');
    Route::resource('users', UserController::class);

    /*Categories*/
    Route::post('category/assign', [CategoryController::class,'assign'])->name('category.assign');
    Route::post('category/unassign', [CategoryController::class,'unassign'])->name('category.unassign');
    
    Route::resource('category', CategoryController::class);
});
