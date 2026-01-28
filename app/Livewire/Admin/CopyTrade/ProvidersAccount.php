<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Models\Settings;
use App\Services\TradeCopier;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class ProvidersAccount extends Component
{
    use LivewireAlert;

    public $providers = [];
    public $addNewAccount = false;
    public $accountId;
    public $update_strategy = false;
    public $profile;

    public function mount(): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['subscription'] !== 'true', 404);
    }

    public function refreshProfile(): void
    {
        Cache::forget('providers');
    }

    #[On('refresh-prov-accounts')]
    public function render(TradeCopier $copier)
    {
        try {
            $this->providers = $copier->providers();
            $this->profile = $copier->profile();
        } catch (CopytradeErrorException $e) {
            session()->flash('message', $e->getMessage());
        }
        return view('livewire.admin.copy-trade.providers-account');
    }

    public function resetProps(): void
    {
        $this->addNewAccount = false;
    }

    public function renew(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage providers');

        try {
            $res = $copier->renewAccount([
                'account' => $id,
            ], 'prov');
            $this->alert(message: $res['message']);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deploy(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage providers');
        try {
            $res = $this->providers = $copier->renewAccount([
                'account' => $id,
            ], 'prov');
            $this->alert(message: $res['message']);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deleteAccount(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage providers');
        try {
            $msg = $copier->deleteAccount("/delete-master-account/{$id}", 'prov');
            $this->alert(message: $msg);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function setForUpdate(string $id): void
    {
        $this->accountId = $id;
        $this->update_strategy = true;
        $this->addNewAccount = false;
    }
    public function cancelUpdate(): void
    {
        $this->accountId = null;
        $this->update_strategy = false;
        $this->addNewAccount = false;
    }

    public function deploymentAll(TradeCopier $copier, string $acnt_type, string $type): void
    {
        $this->authorize('manage providers');
        try {
            $msg = $copier->deploymentAll("/deployment-all/{$acnt_type}/{$type}");
            $this->alert(message: $msg);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
