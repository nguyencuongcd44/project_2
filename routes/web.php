<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

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

//Common ----------------------------------------------------------------
//Register routes
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/register', [LoginController::class, 'check_register']);

//login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'check_login'])->name('check_login');

//logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');





//Front Group routes----------------------------------------------------------------
Route::middleware('savePreUrl')->group(function () {
    //home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    //category
    Route::get('/category/{category}', [HomeController::class, 'category'])->name('front.category');

    //product
    Route::get('/product/{product}', [HomeController::class, 'detail'])->name('front.product');

});


//Auth Group Routes
Route::middleware('auth')->group(function () {
    //post comment
    Route::post('/comment/{product}', [HomeController::class, 'post_cmt'])->name('front.post_cmt');



    //Admin Group routes ----------------------------------------------------------------
    Route::prefix('admin')->middleware('role:admin,editor')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resources([
            'category' => CategoryController::class,
            'product' => ProductController::class,
        ]);
    });
});