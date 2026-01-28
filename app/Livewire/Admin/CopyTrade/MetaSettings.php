<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Services\TradeCopier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MetaSettings extends Component
{
    use LivewireAlert;
    public $use_my_metaapi_account = false;
    public $meta_api_token;

    public function mount(TradeCopier $copier): void
    {
        try {
            $profile = $copier->profile();
            $this->use_my_metaapi_account = boolval($profile['use_my_metaapi_account']);
            $this->meta_api_token = $profile['meta_api_token'];
        } catch (CopytradeErrorException $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.copy-trade.meta-settings');
    }

    public function save(TradeCopier $copier): void
    {
        try {
            $message = $copier->updateAccount([
                'use_my_metaapi_account' => $this->use_my_metaapi_account,
                'meta_api_token' => $this->meta_api_token,
            ]);
            $this->alert(message: $message);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }
}
