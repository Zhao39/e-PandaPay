<?php

namespace App\Livewire\Admin\Settings\Payment;

use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class PaymentPreference extends Component
{
    use LivewireAlert;

    public $deposit_option;
    public $withdrawal_option;
    public $auto_merchant_option;
    public $minamt;
    public $deduction_option;
    public $credit_card_provider;
    public $auto_deposit_merchant;
    public $coinpayment_to_wallet;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function render()
    {
        return view('livewire.admin.settings.payment.payment-preference');
    }

    public function save(): void
    {
        $array = $this->all();
        $filtered = Arr::except($array, ['set']);
        $this->set->update($filtered);
        Cache::forget('site_settings');
        activity()->log('Payment Preference Settings Updated');
        $this->alert(message: 'Settings Saved Successfully.');
    }
}