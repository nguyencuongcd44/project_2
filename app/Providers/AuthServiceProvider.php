<?php

namespace App\Providers;

use App\Models\Comments;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('my-comment', function (Customer $customer, Comments $comment) {
            // Kiểm tra nếu id của người dùng trong comment trùng với id của khách hàng đăng nhập
            return $comment->user_id == $customer->id;
        });
    }
}
