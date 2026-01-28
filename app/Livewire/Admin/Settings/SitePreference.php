<?php

namespace App\Livewire\Admin\Settings;

use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SitePreference extends Component
{
    use LivewireAlert;

    public $set;
    public $contact_email;
    public $notifiable_email;
    public $currency;
    public $s_currency;
    public $currencies;
    public $referral_proffit_from;
    public $currency_current;
    public $spa_mode;
    public $progress_bar_color;
    public $use_copytrade;
    public $should_cancel_plan;
    public $return_capital;
    public $enable_email_verification;
    public $enable_social_login;
    public $enable_kyc_registration;
    public $enable_kyc;
    public $enable_google_translate;
    public $enable_withdrawal_otp;
    public $enable_weekend_trade;
    public $enable_trade_mode;
    public $enable_annoucement;
    public $use_terms;

    public function mount(): void
    {
        include 'currencies.php';
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->currency_current = $settings->currency;
        $this->set = $settings;
        $this->currencies = $currencies;
    }
    public function render()
    {
        return view('livewire.admin.settings.site-preference', []);
    }

    public function save(string $type = ''): void
    {
        $this->validate([
            'currency' => ['required'],
        ]);

        $all = $this->all();

        $curr = explode('-', $this->currency);

        if (array_key_exists(1, $curr)) {
            $currency_array = [
                's_currency' => $curr[0],
                'currency' => $curr[1],
            ];
            $this->currency_current = $currency_array['currency'];
            $this->s_currency = $currency_array['s_currency'];
        } else {
            $currency_array = [];
        }

        $filtered = Arr::except($all, ['currency', 's_currency', 'currencies', 'set', 'currency_current']);

        $savable = array_merge($filtered, $currency_array);

        $this->set->update($savable);
        Cache::forget('site_settings');
        activity()->log('Site Preference Updated');

        $this->alert(message: 'Settings Saved Successfully');
    }
}