<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Settings;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        $template = Settings::select('theme')->find(1)->theme;
        $auth_folder = resource_path("views/{$template}/auth");
        if (file_exists($auth_folder)) {
            Fortify::twoFactorChallengeView(function () use ($template) {
                return view("{$template}.auth.two-factor-challenge");
            });
            Fortify::requestPasswordResetLinkView(function () use ($template) {
                return view("{$template}.auth.forgot-password");
            });
            Fortify::resetPasswordView(function (Request $request) use ($template) {
                return view("{$template}.auth.reset-password", ['request' => $request]);
            });
            Fortify::verifyEmailView(function () use ($template) {
                return view("{$template}.auth.verify-email");
            });
            Fortify::confirmPasswordView(function () use ($template) {
                return view("{$template}.auth.confirm-password");
            });
        }

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
