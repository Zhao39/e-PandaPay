<?php

namespace App\Livewire\Admin\CopyTrade\Prov;

use App\Exceptions\CopytradeErrorException;
use App\Services\TradeCopier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class AddAccount extends Component
{
    use LivewireAlert;
    public $name;
    public $login;
    public $password;
    public $platform = 'mt4';
    public $account_type;
    public $currency;
    public $leverage;
    public $server;
    public $cloudType = 'cloud-g2';

    public function render()
    {
        return view('livewire.admin.copy-trade.prov.add-account');
    }

    public function save(TradeCopier $copier): void
    {
        $this->authorize('manage providers');

        $validated = $this->validate([
            'name' => ['required'],
            'login' => ['required'],
            'password' => ['required'],
            'platform' => ['required'],
            'account_type' => ['required'],
            'currency' => ['required'],
            'leverage' => ['required'],
            'server' => ['required'],
            'cloudType' => ['required'],
        ]);

        try {
            $data = [
                'login' => $this->login,
                'password' => $validated['password'],
                'serverName' => $this->server,
                'name' => $this->name,
                'leverage' => $this->leverage,
                'account_type' => $this->account_type,
                'baseCurrency' => $this->currency ? $this->currency : 'USD',
                'platform' => strtolower($this->platform),
                'type' => $this->cloudType,
            ];
            $copier->addAccount($data, 'prov');
            $this->alert(message: ' Account Created Successfully.');
            $this->reset();
            $this->dispatch('refresh-prov-accounts');
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
