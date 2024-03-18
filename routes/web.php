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
Route::get('/shop', [ClientProductController::class, 'index'])->name('client.shop.index');
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
    
    
    // roles
    Route::prefix('roles')->controller(RoleController::class)->name('roles.')->group(function() {
        Route::get('/', 'index')->name('index')->middleware('permission:show-role');
        Route::get('/show', 'show')->name('show')->middleware('permission:show-role');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-role');
        Route::post('/', 'store')->name('store')->middleware('permission:create-role');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:update-role');
        Route::put('/{product}', 'update')->name('update')->middleware('permission:update-role');
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware('permission:delete-role');
    });
    // user
    Route::prefix('user')->controller(UserController::class)->name('user.')->group(function() {
        Route::get('/', 'index')->name('index')->middleware('permission:show-user');
        Route::get('/show', 'show')->name('show')->middleware('permission:show-user');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-user');
        Route::post('/', 'store')->name('store')->middleware('permission:create-user');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:update-user');
        Route::put('/{product}', 'update')->name('update')->middleware('permission:update-user');
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware('permission:delete-user');
    });
    // categories
    Route::prefix('categories')->controller(CategoryController::class)->name('categories.')->group(function() {
        Route::get('/', 'index')->name('index')->middleware('permission:show-category');
        Route::get('/show', 'show')->name('show')->middleware('permission:show-category');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-category');
        Route::post('/', 'store')->name('store')->middleware('permission:create-category');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:update-category');
        Route::put('/{product}', 'update')->name('update')->middleware('permission:update-category');
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware('permission:delete-category');
    });
    // products
    Route::prefix('products')->controller(ProductController::class)->name('products.')->group(function() {
        Route::get('/', 'index')->name('index')->middleware('permission:show-product');
        Route::get('/{product}', 'show')->name('show')->middleware('permission:show-product');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-product');
        Route::post('/', 'store')->name('store')->middleware('permission:create-product');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:update-product');
        Route::put('/{product}', 'update')->name('update')->middleware('permission:update-product');
        Route::delete('/{product}', 'destroy')->name('destroy')->middleware('permission:delete-product');
    });
    // coupons
    Route::prefix('coupons')->controller(CouponController::class)->name('coupons.')->group(function() {
        Route::get('/', 'index')->name('index')->middleware('permission:show-coupon');
        Route::get('/show', 'show')->name('show')->middleware('permission:show-coupon');
        Route::get('/create', 'create')->name('create')->middleware('permission:create-coupon');
        Route::post('/', 'store')->name('store')->middleware('permission:create-coupon');
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:update-coupon');
        Route::put('/{coupon}', 'update')->name('update')->middleware('permission:update-coupon');
        Route::delete('/{coupon}', 'destroy')->name('destroy')->middleware('permission:delete-coupon');
    });

    Route::get('admin-orders', [AdminOrderController::class, 'index'])->name('admin.orders.index')->middleware('permission:list-order');
    Route::post('update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update')->middleware('permission:update-order-status');
    
});

Route::get('/test-role', [RoleController::class, 'testRole']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
