<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/', [FrontendController::class, 'index'])->name('index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::controller(DashboardController::class)->group(function(){

    Route::get('/admin/dashboard', 'dashboard')->name('dashboard');

 });

 Route::controller(CategoryController::class)->group(function(){

    Route::get('/add/category', 'add_category')->name('add_category');
    Route::post('/store/category', 'store_category')->name('store_category');
    Route::get('/all/category', 'all_category')->name('all_category');
    Route::get('/edit/category/{id}', 'edit_cat')->name('edit_cat');
    Route::post('/update/category', 'update_cat')->name('update_cat');
    Route::get('/delete/category/{id}', 'delete_cat')->name('delete_cat');
    Route::get('/restore/category{id}', 'restore_cat')->name('restore_cat');
    Route::get('/permanent_del/category{id}', 'permanent_del')->name('permanent_del');

 });

 Route::controller(SubcategoryController::class)->group(function(){

    Route::get('/add/sub_category', 'add_sub_category')->name('add_sub_category');
    Route::get('/all/sub_category', 'all_sub_category')->name('all_sub_category');
    Route::post('/store/sub_category', 'store_subcat')->name('store_subcat');
    Route::get('/delete/sub_category{id}', 'delete_subcat')->name('delete_subcat');
    Route::get('/edit/sub_category/{id}', 'edit_subcat')->name('edit_subcat');
    Route::post('/update/sub_category', 'update_subcat')->name('update_subcat');

 });

 Route::controller(ProductController::class)->group(function(){

    Route::get('/add/product', 'add_product')->name('add_product');
    Route::get('/all/product', 'all_product')->name('all_product');
    Route::post('/getsubcategory', 'getsubcategory');
    Route::post('/store/product', 'product_store')->name('product_store');
    Route::get('/edit/product{id}', 'edit_product')->name('edit_product');
    Route::post('/update/product', 'update_product')->name('update_product');


 });


 Route::controller(BrandController::class)->group(function(){
    Route::get('/add/brand', 'add_brands')->name('add_brands');
    Route::get('/all/brand', 'all_brands')->name('all_brands');
    Route::post('/insert/brands', 'insert_brands')->name('insert_brands');
});


Route::controller(InventoryController::class)->group(function(){
    Route::get('/variation', 'variation')->name('variation');
    Route::post('/insert/color', 'insert_color')->name('insert_color');
    Route::get('/delete/color{id}', 'delete_color')->name('delete_color');
    Route::post('/insert/size', 'insert_size')->name('insert_size');
    Route::get('/delete/size{id}', 'delete_size')->name('delete_size');
    Route::get('/product/inventory{product_id}', 'product_inventory')->name('product_inventory');
    Route::post('/store/inventory', 'store_inventory')->name('store_inventory');

});

Route::controller(FrontendController::class)->group(function(){
    Route::get('/product/details{product_id}', 'product_details')->name('product_details');
    Route::post('/getsize', 'get_size');
    Route::post('/cart/store', 'cart_store')->name('cart_store');
    Route::post('/review/store', 'review_store')->name('review_store');
});

Route::controller(CustomerController::class)->group(function(){
    Route::get('/customer/register/login', 'customer_register_login')->name('customer_register_login');
    Route::post('/customer/register', 'customer_register')->name('customer_register');
    Route::post('/customer/login', 'customer_login')->name('customer_login');
    Route::get('/customer/logout', 'customer_logout')->name('customer_logout');
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile/update', 'profile_update')->name('profile_update');
    Route::get('/myorder', 'my_order')->name('my_order');
    Route::get('/download/invoice/{order_id}', 'invoice_download')->name('invoice_download');


});

Route::controller(CartController::class)->group(function(){

    Route::post('/cart/store', 'cart_store')->name('cart_store');
    Route::get('/cart/remove/{cart_id}', 'remove_cart')->name('remove_cart');
    Route::get('/cart', 'cart')->name('cart');
    Route::post('/cart/update', 'cart_update')->name('cart_update');

 });

 Route::controller(CouponController::class)->group(function(){

    Route::get('/coupon', 'coupon')->name('coupon');
    Route::post('/coupon/store', 'coupon_store')->name('coupon_store');

 });

 Route::controller(CheckoutController::class)->group(function(){
    Route::get('/checkout', 'checkout')->name('checkout');
    Route::post('/getcity', 'getcity');
    Route::post('/order/store', 'order_store')->name('order_store');
    Route::get('/order/success/{order_id_new}', 'order_success')->name('order_success');
 });


 Route::controller(OrdersController::class)->group(function(){

    Route::get('/orders', 'orders')->name('orders');
    Route::post('/status/update', 'status_update')->name('status_update');

 });

 // SSLCOMMERZ Start
Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


 // STRIPE
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe');
    Route::post('stripe', 'stripePost')->name('stripe.post');
});
 // STRIPE END


