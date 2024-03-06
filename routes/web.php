<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CommonController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\MyAccountController;
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

/*Landing Page*/
Route::get('/home', [HomeController::class, 'index'])->name('home');

/*About Us Page*/
Route::get('/about-us', [HomeController::class, 'about_us'])->name('about-us');

/*Contact Us Page*/
Route::get('/contact-us', [HomeController::class, 'contact_us'])->name('contact-us');
Route::post('contact-form-submit',[HomeController::class,'contactFormSubmit'])->name('contact.form.submit');

/*Subscriber*/
Route::post('subscriber-form',[HomeController::class,'subscriberFormSubmit'])->name('subscriber.form.submit');

/*Products*/
Route::get('/shop', [FrontProductController::class, 'index'])->name('products');

/*Product Details*/
Route::get('/shop/{id}/details', [FrontProductController::class, 'details'])->name('products.details');

/*Quick View*/
Route::get('/shop/quick-view/{product_id}', [FrontProductController::class, 'quickview'])->name('products.quickview');

/*Quick View*/
Route::post('shop/add-wishlist', [MyAccountController::class,'addProducttoWishlist'])->name('products.add.wishlist');

/*Wishlist View*/
Route::get('/shop/wishlist-view', [MyAccountController::class, 'wishlistview'])->name('products.wishlistview');

/*Wishlist View*/
Route::get('/my-account/shopping-cart', [MyAccountController::class, 'shoppingCart'])->name('my-account.shopping-cart');
Route::get('/my-account/checkout', [MyAccountController::class, 'checkout'])->name('my-account.checkout');
Route::get('/my-account/order-completed', [MyAccountController::class, 'orderCompleted'])->name('my-account.order.completed');
Route::get('/my-account/wishlist', [MyAccountController::class, 'myWishlist'])->name('my-account.wishlist');
Route::get('/my-account/orders', [MyAccountController::class, 'myOrders'])->name('my-account.orders');
Route::get('/my-account/profile-info', [MyAccountController::class, 'profileInfo'])->name('my-account.profile-info');
Route::get('/my-account/addresses', [MyAccountController::class, 'myAddresses'])->name('my-account.addresses');
Route::get('/my-account/edit-address', [MyAccountController::class, 'editAddresses'])->name('my-account.edit-address');

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
    Route::post('products/removeimage', [ProductController::class,'remcontact_usoveImage'])->name('products.removeimage');
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

    /* settings */
    Route::resource('settings', SettingController::class);

    /* banners */
    Route::resource('banner', BannerController::class);
});
