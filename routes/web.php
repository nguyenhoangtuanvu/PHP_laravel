<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
