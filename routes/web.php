<?php

use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as FrontProductController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [FrontProductController::class, 'index'])->name('products');
Route::get('/shop/details', [FrontProductController::class, 'details'])->name('products.details');
Route::get('/shop/quick-view/{product_id}', [FrontProductController::class, 'quickview'])->name('products.quickview');

// ------------------main routes------------------------------------------


Route::get('/admin', [AuthorizationController::class, 'adminLoginForm'])->name('admin.login');
Route::post('/adminLogin', [AuthorizationController::class, 'adminLogin'])->name('admin.signin');

Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('logout', [AuthorizationController::class, 'adminLogout'])->name('admin.logout');

    /*IMAGE UPLOAD IN SUMMER NOTE*/
    Route::post('image/upload', [ImageController::class,'upload_image']);
    Route::resource('profile_update', ProfileUpdateController::class);

    /*Common*/
    Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

    /*Users*/
    Route::resource('users', UserController::class);

    /*Categories*/
    Route::resource('category', CategoryController::class);

    /*Products*/
    Route::get('products/import-product', [ProductController::class,'importProduct'])->name('products.import.product');
    Route::post('products/import-product-store', [ProductController::class,'importProductStore'])->name('products.import.product.store');
    Route::post('products/removeimage', [ProductController::class,'removeImage'])->name('products.removeimage');
    Route::post('products/getoptions', [ProductController::class,'getOptions'])->name('products.getoptions');
    Route::post('products/editoption', [ProductController::class,'editOption'])->name('products.editoption');
    Route::resource('products', ProductController::class);

    /*Content Management*/
    Route::resource('content', ContentManagementController::class);

    /*Contact Us*/
    Route::resource('contactus', ContactUsController::class);

    /*Orders*/
    Route::post('orders/update_qty', [OrderController::class, 'updateQty'])->name('orders.update_qty');
    Route::delete('orders/delete_product/{cart_id}', [OrderController::class, 'deleteCart'])
    ->name('orders.delete_product');
    Route::get('/addresses/{userId}', [OrderController::class,'getAddressesByUser'])->name('addresses.by_user');
    Route::post('orders/update_status', [OrderController::class,'updateOrderStatus'])->name('orders.update_status');
    Route::post('orders/addproduct', [OrderController::class,'addProductToCart'])->name('orders.addproduct');
    Route::post('orders/editoption', [OrderController::class,'editProductOptionToCart'])->name('orders.editoption');
    Route::get('/index_product', [OrderController::class, 'index_product'])->name('orders.index_product');
    Route::get('/index_order_dashborad', [OrderController::class, 'index_order_dashborad'])->name('orders.index_dashboard');
    Route::resource('orders',OrderController::class);

    /*Reports*/
    Route::get('reports/user_orders', [ReportController::class, 'index_user_orders'])->name('reports.user_orders');
    Route::get('reports/purchase_product', [ReportController::class, 'index_purchase_product'])->name('reports.purchase_product');
    Route::get('reports/sales', [ReportController::class, 'index_sales'])->name('reports.sales');
});
