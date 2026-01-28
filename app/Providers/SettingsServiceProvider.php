<?php

namespace App\Providers;

use App\Models\Content;
use App\Models\Page;
use App\Models\Settings;
use App\Services\Website;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Livewire\Livewire;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {}

    /**
     * Bootstrap services.
     */

    public function boot(): void
    {
        $settings = Cache::rememberForever('site_settings', function () {
            return Settings::find(1);
        });
        $isProduction = $this->app->environment('production');
        $websiteIsSecured = Website::hasHttps();

        if ($settings->install_type === 'Sub-Folder') {
            $url = Website::url();
            $urls = explode('/', $url);
            $assetUrl = end($urls);
            Livewire::setUpdateRoute(function ($handle) use ($assetUrl) {
                return Route::post("/{$assetUrl}/livewire/update", $handle);
            });
            Livewire::setScriptRoute(function ($handle) use ($assetUrl) {
                return Route::get("/{$assetUrl}/livewire/livewire.js", $handle);
            });
        }
        $pages = Cache::rememberForever('pages', function () {
            return Page::all();
        });
        $auth = Content::where('ref_key', 'yHdg43')->first();
        $auth2 = Content::where('ref_key', '39043d')->first();

        View::share('settings', $settings);
        View::share('mod', $settings->modules);
        View::share('pages', $pages);
        View::share('auth', $auth);
        View::share('auth2', $auth2);

        Password::defaults(function () use ($isProduction, $settings) {
            $rule = Password::min($settings->password_validation_rules['leastChar']);
            $rules = $rule;
            if ($settings->password_validation_rules['mixedCase'] === '1') {
                $rules = $rule->mixedCase();
            }
            if ($settings->password_validation_rules['numbers'] === '1') {
                $rules = $rule->numbers();
            }
            if ($settings->password_validation_rules['symbols'] === '1') {
                $rules = $rule->symbols();
            }

            if ($settings->password_validation_rules['letters'] === '1') {
                $rules = $rule->letters();
            }
            if ($settings->password_validation_rules['uncompromised'] === '1') {
                $rules = $rule->uncompromised();
            }
            return $isProduction
                ? $rules
                : $rule;
        });

        if ($websiteIsSecured) {
            URL::forceScheme('https');
        }

        config([
            'livewire.navigate.progress_bar_color' => "{$settings->progress_bar_color}",
            'services.google.client_id' => trim($settings->google_id),
            'services.google.client_secret' => trim($settings->google_secret),
            'services.google.redirect' => trim($settings->google_redirect),
            'services.telegram-bot-api.token' => $settings->telegram_bot_api,
            'mail.mailers.smtp.host' => $settings->smtp_host,
            'mail.mailers.smtp.port' => $settings->smtp_port,
            'mail.mailers.smtp.encryption' => $settings->smtp_encrypt,
            'mail.mailers.smtp.username' => $settings->smtp_user,
            'mail.mailers.smtp.password' => $settings->smtp_password,
            'mail.default' => $settings->mail_server,
            'mail.from.address' => $settings->emailfrom,
            'mail.from.name' => $settings->emailfromname,
            'app.name' => $settings->site_name,
            'app.url' => Website::url(true),
            'paystack.publicKey' => $settings->paystack_public_key,
            'paystack.secretKey' => $settings->paystack_secret_key,
            'paystack.paymentUrl' => $settings->paystack_url,
            'paystack.merchantEmail' => $settings->paystack_email,
            'flutterwave.publicKey' => $settings->flw_public_key,
            'flutterwave.secretKey' => $settings->flw_secret_key,
            'flutterwave.secretHash' => $settings->flw_secret_hash,
            'paypal.mode' => 'live',
            'paypal.sandbox.client_id' => $settings->pp_ci,
            'paypal.sandbox.client_secret' => $settings->pp_cs,
            'paypal.live.client_id' => $settings->pp_ci,
            'paypal.live.client_secret' => $settings->pp_cs,
            'coinbase.api_key' => $settings->coinbase_apikey,
            'coinbase.api_version' => $settings->coinbase_apiversion,
            'activitylog.delete_records_older_than_days' => intval(
                $settings->delete_records_older_than_days
            ),
        ]);

        Carbon::macro('inUserTimezone', function () use ($settings) {
            return $this->tz(auth()->user()?->timezone ?? $settings->timezone);
        });
    }
}