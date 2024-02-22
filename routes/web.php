<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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

Route::get('/', function () {
    return view('welcome');
});

// admin routes
Route::get('/dashboard', function () {
    return view('admin.Dashboard.index');
})->name('dashboard');

Route::get('/home', function () {
    return view('clients.home');
});
// products
Route::get('/shop', function () {
    return view('clients.products.shop');
});
Route::get('/single-product', function () {
    return view('clients.products.single_product');
});

// carts
Route::get('/cart', function () {
    return view('clients.carts.cart');
});
Route::get('/checkout', function () {
    return view('clients.carts.checkout');
});

// about
Route::get('/about', function () {
    return view('clients.about');
});
Route::get('/contact', function () {
    return view('clients.contact');
});

Route::resource('roles', RoleController::class);
Route::resource('user', UserController::class);
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
