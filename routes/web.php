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
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\AuthorizationController;
use App\Http\Controllers\Admin\ProfileUpdateController;
use App\Http\Controllers\Admin\ContentManagementController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SubscriberController as FrontSubscriberController;
use App\Http\Controllers\ContactUsController as FrontContactUsController;
use App\Http\Controllers\ProductController as FrontProductController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController as FrontOrderController;
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
   return redirect()->route('home');
})->middleware(['removePublic']);

Route::middleware('removePublic')->group(function () {
    Auth::routes();
});


/*Landing Page*/
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['removePublic']);

/*Information Page*/
Route::get('about-us', [InformationController::class, 'about_us'])->name('about-us')->middleware(['removePublic']);
Route::get('faq', [InformationController::class, 'faq'])->name('faq')->middleware(['removePublic']);
Route::get('privacy-policy', [InformationController::class, 'privacy_policy'])->name('privacy-policy')->middleware(['removePublic']);
Route::get('terms-&-conditions', [InformationController::class, 'terms_and_conditions'])->name('terms-conditions')->middleware(['removePublic']);

/*404 Page*/
Route::get('404', [HomeController::class, 'page_not_found'])->name('errors.404')->middleware(['removePublic']);

/*Contact Us Page*/
Route::resource('contact-us', FrontContactUsController::class)->middleware(['removePublic']);

/*Subscriber*/
Route::post('subscriber-form',[FrontSubscriberController::class,'store'])->name('subscriber.form.submit')->middleware(['removePublic']);

/*Products*/
Route::get('shop', [FrontProductController::class, 'index'])->name('products')->middleware(['removePublic']);

/*Caegory Products*/
Route::get('category/{category_id?}/{category_name?}/{sub_category_name?}', [FrontProductController::class, 'index'])->name('products.filter')->middleware(['removePublic']);

/*Product Details*/
Route::get('shop/{id}/details', [FrontProductController::class, 'details'])->name('products.details')->middleware(['removePublic']);

/*Quick View*/
Route::get('shop/quick-view/{product_id}', [FrontProductController::class, 'quickview'])->name('products.quickview')->middleware(['removePublic']);
Route::get('shop/quick-view-image/{product_id}', [FrontProductController::class, 'quickviewimage'])->name('products.quickviewimage')->middleware(['removePublic']);

/*Wishlist*/
Route::post('wishlist/add-wishlist', [WishlistController::class,'addProducttoWishlist'])->name('products.add.wishlist')->middleware(['removePublic']);
Route::get('wishlist/wishlist-view', [WishlistController::class, 'wishlistview'])->name('wishlist.view')->middleware(['removePublic']);
Route::get('wishlist/remove/{id}',[WishlistController::class,'wishlistRemove'])->name('wishlist.remove')->middleware(['removePublic']);
Route::get('wishlist', [WishlistController::class, 'myWishlist'])->name('wishlist')->middleware(['removePublic']);

/*Shopping Cart*/
Route::get('cart/cart-view', [ShoppingCartController::class, 'cartview'])->name('cart.view')->middleware(['removePublic']);
Route::post('cart/remove-cart', [ShoppingCartController::class,'removeProducttoCart'])->name('cart.remove')->middleware(['removePublic']);
Route::post('cart/add-product-to-cart', [ShoppingCartController::class,'addProductToCart'])->name('cart.add-product')->middleware(['removePublic']);
Route::get('cart', [ShoppingCartController::class, 'shoppingCart'])->name('shopping-cart')->middleware(['removePublic']);
Route::post('cart/update-quantity', [ShoppingCartController::class, 'updateQuantity'])->name('cart.update-quantity')->middleware(['removePublic']);
Route::post('cart/update-remaining-quantity', [ShoppingCartController::class, 'updateRemainingQuantity'])->name('cart.update-remaining-quantity')->middleware(['removePublic']);

/*Checkout*/
Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout')->middleware(['removePublic']);
Route::post('checkout-order-placed', [CheckoutController::class, 'placed'])->name('checkout-order-placed')->middleware(['removePublic']);
Route::get('checkout/order-completed', [CheckoutController::class, 'orderCompleted'])->name('checkout.order-completed')->middleware(['removePublic']);

/*My Account*/
Route::get('profile-info', [MyProfileController::class, 'index'])->name('profile-info')->middleware(['removePublic']);
Route::post('profile-info/update',[MyProfileController::class,'update'])->name('profile-info-update')->middleware(['removePublic']);

/*Change Password*/
Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change.password')->middleware(['removePublic']);
Route::post('change-password-update',[ChangePasswordController::class,'update'])->name('change.password.update')->middleware(['removePublic']);

/* My Orders */
Route::get('orders', [FrontOrderController::class, 'index'])->name('orders-list')->middleware(['removePublic']);
Route::get('orders/{id}/details', [FrontOrderController::class, 'orderDetails'])->name('order-details')->middleware(['removePublic']);

/* My Addresses */
Route::resource('addresses', AddressController::class)->middleware(['removePublic']);

/* Product Review */
Route::post('submit-review',[ReviewController::class,'productReview'])->name('add-product-review')->middleware(['removePublic']);
Route::get('product/{productId}/reviews-list',[ReviewController::class,'reviewsList'])->name('reviews-list')->middleware(['removePublic']);
Route::get('reviews/{reviewId}/review-info',[ReviewController::class,'reviewsInfo'])->name('reviews-info')->middleware(['removePublic']);


// ------------------main routes------------------------------------------
Route::get('/admin', [AuthorizationController::class, 'adminLoginForm'])->name('admin.login')->middleware(['removePublic']);
Route::post('/adminLogin', [AuthorizationController::class, 'adminLogin'])->name('admin.signin');

Route::prefix('admin')->middleware(['admin', 'removePublic'])->group(function () {
   Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
   Route::get('logout', [AuthorizationController::class, 'adminLogout'])->name('admin.logout');

   /*IMAGE UPLOAD IN SUMMER NOTE*/
   Route::post('image/upload', [ImageController::class,'upload_image']);
   Route::resource('profile_update', ProfileUpdateController::class);

   /*Common*/
   Route::post('common/changestatus', [CommonController::class,'changeStatus'])->name('common.changestatus');

   /*Users*/
   Route::resource('users', UserController::class);
   Route::post('users/add-address', [UserController::class, 'addAddresses'])->name('user.add-address');

   /*Categories*/
   Route::resource('category', CategoryController::class);

   /*Products*/
   Route::post('getStockHistory', [ProductController::class,'getStockHistory'])->name('products.stockHistory');
   Route::post('products/add-stock', [ProductController::class,'addProductStock'])->name('products.add_stock');
   Route::get('/index_stock', [ProductController::class, 'index_stock'])->name('products.index_stock');
   Route::get('products/import-product', [ProductController::class,'importProduct'])->name('products.import.product');
   Route::post('products/import-product-store', [ProductController::class,'importProductStore'])->name('products.import.product.store');
   Route::post('products/removeimage', [ProductController::class,'removeImage'])->name('products.removeimage');
   Route::post('products/getoptions', [ProductController::class,'getOptions'])->name('products.getoptions');
   Route::post('products/editoption', [ProductController::class,'editOption'])->name('products.editoption');
   Route::resource('products', ProductController::class);
   Route::get('products/{id}/reviews', [ProductController::class, 'reviewsList'])->name('product.reviews.list');
   Route::get('products/{reviewId}/review-infos',[ProductController::class,'reviewDetails'])->name('admin.product.review-info');

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
   Route::get('/orders/export', [OrderController::class,'exportOrders'])->name('orders.export');
   Route::resource('orders',OrderController::class);

   /*Reports*/
   Route::get('reports/user_orders', [ReportController::class, 'index_user_orders'])->name('reports.user_orders');
   Route::get('reports/purchase_product', [ReportController::class, 'index_purchase_product'])->name('reports.purchase_product');
   Route::get('reports/sales', [ReportController::class, 'index_sales'])->name('reports.sales');

   /* settings */
   Route::resource('settings', SettingController::class);

   /* banners */
   Route::resource('banners', BannerController::class);

   /*Subscriber*/
   Route::resource('subscribers', SubscriberController::class);
});
