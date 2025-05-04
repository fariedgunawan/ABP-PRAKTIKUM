<?php

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
use App\Http\Controllers\ProductController;
use App\Models\Category;

Route::get('/api/categories', function () {
    return Category::with('products')->get();
});

Route::resource('products', ProductController::class);

Route::get('get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');

Route::get('/', function () {
    return view('welcome');
});
