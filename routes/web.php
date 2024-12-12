<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\CommentController;
use App\Http\Controllers\Front\FavoriteController;
use App\Http\Controllers\Front\SearchController;
use App\Http\Controllers\Front\PasswordResetController;

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ToppingController;
use App\Http\Controllers\Front\PaymentController;

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
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/category/{category}', [HomeController::class, 'category'])->name('front.category');
    Route::get('/product/{product}', [HomeController::class, 'product_detail'])->name('front.product');

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'cart'])->name('cart');
        Route::get('/add-product/{product}', [CartController::class, 'addProduct'])->name('cart.addProduct');
        Route::get('/update-product/{product}', [CartController::class, 'updateProduct'])->name('cart.updateProduct');
        Route::get('/delete-product/{id}', [CartController::class, 'deleteProduct'])->name('cart.deleteProduct');

        Route::get('/add-topping/{topping}', [CartController::class, 'addTopping'])->name('cart.addTopping');
        Route::get('/update-topping/{topping}', [CartController::class, 'updateTopping'])->name('cart.updateTopping');
        Route::get('/delete-topping/{id}', [CartController::class, 'deleteTopping'])->name('cart.deleteTopping');

        Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
    });

    // Comment routes 
    Route::prefix('comment')->middleware('customer')->group(function () {
        Route::post('/post/{product}', [CommentController::class, 'post_cmt'])->name('front.post_cmt');
        Route::put('/update', [CommentController::class, 'update_cmt'])->name('front.update_cmt');
        Route::get('/delete/{id}', [CommentController::class, 'delete_cmt'])->name('front.delete_cmt');
    });

    // Favorite routes 
    Route::prefix('favorite')->group(function () {
        Route::get('/', [FavoriteController::class, 'show'])->name('favorite');
        Route::post('/add', [FavoriteController::class, 'add']);
        Route::post('/delete', [FavoriteController::class, 'delete']);
        Route::post('/clear', [FavoriteController::class, 'clear']);
    });

    // Search routes 
    Route::prefix('search')->group(function () {
        Route::get('/', [SearchController::class, 'search'])->name('front.search');
        Route::post('/reset', [SearchController::class, 'search_reset'])->name('front.search_reset');
    });

    // Toppings routes 
    Route::prefix('toppings')->group(function () {
        Route::get('/', [HomeController::class, 'show_topping'])->name('front.toppings');
        Route::get('/{id}', [HomeController::class, 'topping_detail'])->name('front.topping.detail');
    });

    // Payment routes 
    Route::prefix('payment')->group(function () {
        Route::get('/method-select', [PaymentController::class, 'method_select'])->name('front.payment.method');
    });

    // Password reset routes
    Route::get('forgot-password', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('resetPassword.sendEmail');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');

    
    // Account routes
    Route::prefix('account')->group(function () {
        //login
        Route::get('/login', [AccountController::class, 'login'])->name('account.login');
        Route::get('/verify-account/{email}', [AccountController::class, 'verify'])->name('account.verify');
        Route::post('/login', [AccountController::class, 'check_login'])->name('account.check_login');

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
    Route::middleware('auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::resources([
            'category' => CategoryController::class,
            'product' => ProductController::class,
            'topping' => ToppingController::class,
        ]);

        //logout
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    });
});