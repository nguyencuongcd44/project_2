<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\AccountController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminController;

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

//Front Group routes----------------------------------------------------------------------------------------------------------------------------------------
Route::middleware('savePreUrl')->group(function () {
    //home
    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    //category
    Route::get('/category/{category}', [HomeController::class, 'category'])->name('front.category');

    //product
    Route::get('/product/{product}', [HomeController::class, 'detail'])->name('front.product');

    //post product comment
    Route::post('/comment/{product}', [HomeController::class, 'post_cmt'])->name('front.post_cmt');
    

    // Cart routes
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

    
    // Account routes
    Route::prefix('account')->group(function () {
        //login
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::get('/verify-account/{email}', [AccountController::class, 'verify'])->name('account.verify');
        Route::post('/login', [AccountController::class, 'check_login'])->name('account_check_login');

        //register
        Route::get('/register', [AccountController::class, 'register'])->name('account.register');
        Route::post('/register', [AccountController::class, 'check_register']);
        
        //forgot password
        Route::get('/forgot-password', [AccountController::class, 'forgot_password'])->name('account.forgot-password');
        Route::post('/forgot-password', [AccountController::class, 'check_forgot_password']);

        //reset password
        Route::get('/reset-password', [AccountController::class, 'reset_password'])->name('account.forgot-password');
        Route::post('/reset-password', [AccountController::class, 'check_reset_password']);

        // Customer routes 
        Route::middleware('customer')->group(function () {
            //profile
            Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
            Route::post('/profile', [AccountController::class, 'profile']);

            //change password
            Route::get('/change-password', [AccountController::class, 'change_password'])->name('account.change-password');
            Route::post('/change-password', [AccountController::class, 'check_change_password']);

            //logout
            Route::post('/logout', [AccountController::class, 'logout'])->name('account.logout');
        });
    });
});



// Admin Group Routes -------------------------------------------------------------------------------------------------------------------------------
Route::prefix('admin')->group(function () {
    //Register
    Route::get('/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/register', [AdminController::class, 'check_register']);

    //login
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'check_login'])->name('admin.check_login');

    // Auth
    Route::middleware('auth', 'role:admin,editor')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resources([
            'category' => CategoryController::class,
            'product' => ProductController::class,
        ]);

        //logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});