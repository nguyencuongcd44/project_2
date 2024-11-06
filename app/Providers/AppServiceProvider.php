<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Arr;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // truyền biến global toàn project(có thể chỉ định những view có thể truyền đến bằng cách thay * bằng mảng)
        view()->composer('*', function($view){
            $cats = Category::orderBy('id', 'DESC')->paginate(10);
            $cart = new Cart;
            $favoriteList = [];
            if(session('favorite')){
                $favoriteList = Arr::flatten(session('favorite'));
                $favoriteList = array_unique($favoriteList);
            }
            $view->with(compact(['cats', 'cart', 'favoriteList']));
        });
    }
}
