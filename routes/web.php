<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AccountController;

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






// Account routes ----------------------------------------------------------------
Route::prefix('account')->group(function () {
    //login
    Route::get('/login', [AccountController::class, 'login'])->name('account.login');
    Route::get('/verify-account/{email}', [AccountController::class, 'verify'])->name('account.verify');
    Route::post('/login', [AccountController::class, 'check_login']);

    //register
    Route::get('/register', [AccountController::class, 'register'])->name('account.register');
    Route::post('/register', [AccountController::class, 'check_register']);

    //profile
    Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::post('/profile', [AccountController::class, 'profile']);

    //change password
    Route::get('/change-password', [AccountController::class, 'change_password'])->name('account.change-password');
    Route::post('/change-password', [AccountController::class, 'check_change_password']);

    //forgot password
    Route::get('/forgot-password', [AccountController::class, 'forgot_password'])->name('account.forgot-password');
    Route::post('/forgot-password', [AccountController::class, 'check_forgot_password']);

    //reset password
    Route::get('/reset-password', [AccountController::class, 'reset_password'])->name('account.forgot-password');
    Route::post('/reset-password', [AccountController::class, 'check_reset_password']);
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


//Front Group routes----------------------------------------------------------------
Route::middleware('savePreUrl')->group(function () {
    //home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    //category
    Route::get('/category/{category}', [HomeController::class, 'category'])->name('front.category');

    //product
    Route::get('/product/{product}', [HomeController::class, 'detail'])->name('front.product');

    

    Route::prefix('cart')->group(function () {
        //cart
        Route::get('/', [CartController::class, 'cart'])->name('cart');

        //add to cart
        Route::get('/add/{product}', [CartController::class, 'addToCart'])->name('cart.add');

        //update
        Route::get('/update/{product}', [CartController::class, 'update'])->name('cart.update');

        //delete
        Route::get('/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');

        //clear
        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

});