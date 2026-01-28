<?php

namespace App\Livewire\Admin\Settings\Payment;

use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CoinpaymentApi extends Component
{
    use LivewireAlert;

    public $cp_p_key;
    public $cp_pv_key;
    public $cp_m_id;
    public $cp_ipn_secret;
    public $cp_debug_email;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function render()
    {
        return view('livewire.admin.settings.payment.coinpayment-api');
    }

    public function save(): void
    {
        $array = $this->all();
        $filtered = Arr::except($array, ['set']);
        $this->set->update($filtered);
        Cache::forget('site_settings');
        activity()->log('Coinpayment Api Settings Updated');
        $this->alert(message: 'Settings Saved Successfully.');
    }
}