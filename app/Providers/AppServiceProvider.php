<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;


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
            $view->with(compact('cats'));
        });
    }
}
