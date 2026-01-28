<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        $template = Settings::select('theme')->find(1)->theme;
        $auth_folder = resource_path("views/{$template}/auth");
        if (file_exists($auth_folder)) {
            Fortify::loginView(function () use ($template) {
                return view("{$template}.auth.login");
            });
            Fortify::registerView(function () use ($template) {
                return view("{$template}.auth.register");
            });
        }

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)
                ->orWhere('username', $request->email)
                ->where('status', 'active')
                ->isNotAdmin()
                ->first();

            if (
                $user &&
                Hash::check($request->password, $user->password)
            ) {
                $ip = $request->ip();

                activity()->by($user)->log("Logged in to account from IP Address: {$ip}");
                $user->assignRole('User');
                return $user;
            }
        });
    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}