<?php

namespace App\Providers;

use App\Models\TradingAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $isProduction = $this->app->environment('production');

        Schema::defaultStringLength(191);

        Model::shouldBeStrict(! $isProduction);

        // authorization
        Gate::define('renew-account', function (
            User $user,
            TradingAccount $account
        ) {
            return $user->id === $account->user_id;
        });
    }
}
