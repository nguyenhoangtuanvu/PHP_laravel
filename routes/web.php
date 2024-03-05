<?php

// use App\Http\Controllers\Auth;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\ClientProductController;
use App\Http\Controllers\Clients\HomeController;
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


Route::get('/single-product', function () {
    return view('clients.products.shop_detail');
});

// carts
Route::get('/cart', function () {
    return view('clients.carts.cart');
})->name('cart');
Route::post('add-to-cart', [CartController::class, 'store'])->name('carts.add');

Route::get('/checkout', function () {
    return view('clients.carts.checkout');
})->name('checkout');

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


// Route::middleware('auth')->group(function() {
    
// });
// admin routes
Route::get('/dashboard', function () {
    return view('admin.Dashboard.index');
})->name('dashboard');

Route::resource('roles', RoleController::class);
Route::resource('user', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);
Route::resource('coupons', CouponController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
