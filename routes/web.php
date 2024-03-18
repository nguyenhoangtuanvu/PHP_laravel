<?php

// use App\Http\Controllers\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\ClientProductController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\OrderController;
use App\Models\Order;
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

Route::get('/test', function () {
    return view('test');
})->name('test');


Route::get('/', [HomeController::class, 'index'])->name('client.home');

// products
Route::get('/shop', [ClientProductController::class, 'index'])->name('client.shop');
Route::get('shop/{category_id}', [ClientProductController::class, 'indexFilter'])->name('client.shop.indexFilter'); 
Route::get('shop_detail/{product_id}', [ClientProductController::class, 'show'])->name('client.shop.show'); 

// carts
Route::middleware('auth')->group(function() {
    Route::post('add-to-cart', [CartController::class, 'store'])->name('carts.add');
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::post('update-quantity-product-in-cart/{cart_product_id}', [CartController::class, 'updateQuantityProduct'])->name('client.carts.update_product_quantity');
    Route::post('delete-product-in-cart/{cart_product_id}', [CartController::class, 'deleteProduct'])->name('client.carts.delete_product');
    Route::post('apply-coupon', [CartController::class, 'applyCoupon'])->name('carts.apply.coupon');
    Route::get('check-out', [CartController::class, 'checkOut'])->name('checkOut')->middleware('user.can_checkout_cart');
    Route::post('process-checkout', [CartController::class, 'processCheckout'])->name('checkOut.process')->middleware('user.can_checkout_cart');
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('cancel-order/{product_id}', [OrderController::class, 'cancel'])->name('order.cancel');
});


Route::get('/single-product', function () {
    return view('clients.products.shop_detail');
});

Route::post('add-to-cart', [CartController::class, 'store'])->name('carts.add');

// about
Route::get('/about', function () {
    return view('clients.service.about');
})->name('about');
Route::get('/contact', function () {
    return view('clients.service.contact');
})->name('contact');
Route::get('/service', function () {
    return view('clients.service.service');
})->name('service');


Route::middleware('auth')->group(function() {
    // admin routes
    Route::get('/dashboard', function () {
        return view('admin.Dashboard.index');
    })->name('dashboard');
    
    Route::resource('roles', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('coupons', CouponController::class);

    Route::get('admin-orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update');
    
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
