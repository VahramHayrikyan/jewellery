<?php

namespace App\Providers;

use App\Models\Address;
use App\Models\Admin;
use App\Models\Admin as AdminUser;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use App\Policies\Admin\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }

        Passport::tokensExpireIn(now()->addDays(30));

        Gate::define('delete-admin', function (Admin $admin, AdminUser $user) {
            return $admin->id !== $user->id;
        });

        Gate::define('delete-address', function (User $user, Address $address) {
            return $address->user_id !== $user->id;
        });

        Gate::define('access-cartProduct', function (User $user, CartProduct $cartProduct) {
            return $cartProduct->cart->user_id === $user->id;
        });

        Gate::define('access-cart', function (User $user, Cart $cart) {
            return $cart->user_id === $user->id;
        });

        Gate::define('access-logs', function (Admin $admin) {
            return $admin->role_id === Admin::ROLES['super_admin'];
        });
    }
}
