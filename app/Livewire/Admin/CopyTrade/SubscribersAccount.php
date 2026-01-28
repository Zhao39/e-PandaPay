<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Exceptions\CopytradeErrorException;
use App\Models\Settings;
use App\Models\TradingAccount;
use App\Notifications\User\CopyTradeStarted;
use App\Services\TradeCopier;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class SubscribersAccount extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $addNewAccount = false;
    public $editAccount = false;
    public $accountId;
    public $process_type = 'process';
    public $providers = [];
    public $profile;
    public $masterId;
    public $fixed_provider;

    public function mount(TradeCopier $copier): void
    {
        $set = Settings::select('use_copytrade', 'modules')->find(1);
        abort_if($set->modules['subscription'] !== 'true', 404);
        if ($set->use_copytrade) {
            try {
                $this->profile = $copier->profile();
                $this->providers = $copier->providers();
            } catch (CopytradeErrorException $e) {
                session()->flash('message', $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.copy-trade.subscribers-account', [
            'accounts' => TradingAccount::with('user')->latest()->paginate(5),
        ]);
    }

    public function resetProps(): void
    {
        $this->reset(['addNewAccount', 'editAccount', 'accountId', 'process_type']);
    }

    #[On('refresh-sub-accounts')]
    public function refreshThis(): void
    {
        $this->resetProps();
        $this->render();
    }

    public function setUpdate(string $id): void
    {
        $this->accountId = $id;
        $this->addNewAccount = false;
        $this->editAccount = true;
    }

    public function deleteAccount(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage subscribers');
        $settings = Settings::select('use_copytrade')->find(1);

        try {
            $account = TradingAccount::findOrFail($id);
            if (! $settings->use_copytrade || $account->status === 'pending') {
                $account->delete();
                $this->alert(message: 'Account Deleted Succssfully.');
            } else {
                if (empty($account->meta_account_id)) {
                    $account->delete();
                    $this->alert(message: 'Account Deleted Succssfully.');
                    return;
                }
                $msg = $copier->deleteAccount("/delete-sub-account/{$account->meta_account_id}");
                $account->delete();
                $this->alert(message: $msg);
            }
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function process(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage subscribers');
        $account = TradingAccount::with('user')->find($id);
        $settings = Settings::select([
            'id',
            'send_trade_request_success_email',
            'notifiable_email',
            'use_copytrade',
        ])->find(1);

        try {
            if (! $settings->use_copytrade && ! is_null($account->user_id) && ! is_null($account->duration)) {
                if ($this->confirmSub($account)) {
                    $message = 'Your trading account management request has been reviewed and processed.';
                    if ($settings->send_trade_request_success_email) {
                        dispatch(function () use ($account, $message) {
                            $account->user->notify(new CopyTradeStarted($account, $message));
                        })->afterResponse();
                    }
                    $this->alert(message: 'Account Processed Successfully.');
                    return;
                }
                $this->alert(type: 'error', message: 'Something went wrong. Please try again.');
                return;
            }
            $meta_account = $copier->addAccount([
                'login' => $account->login,
                'password' => $account->password,
                'serverName' => $account->server,
                'name' => $account->name,
                'leverage' => $account->leverage,
                'account_type' => $account->account_type,
                'baseCurrency' => $account->currency ? $account->currency : 'USD',
                'platform' => strtolower($account->platform),
            ]);

            if ($account->status === 'pending') {
                if ($this->confirmSub($account)) {
                    $message = 'Your trading account management request has been reviewed and processed.';
                    if ($settings->send_trade_request_success_email) {
                        dispatch(function () use ($account, $message) {
                            $account->user->notify(new CopyTradeStarted($account, $message));
                        })->afterResponse();
                    }
                }
            }

            $account->meta_account_id = $meta_account['account']['metapi_account_id'];
            $account->deployment_status = $meta_account['account']['deployment_status'];
            $account->expired_at = $meta_account['account']['end_date'];
            $account->save();

            $this->alert(message: $meta_account['message']);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function renew(TradeCopier $copier, string $id): void
    {
        $this->authorize('manage subscribers');

        try {
            $res = $copier->renewAccount([
                'account' => $id,
            ]);
            $this->alert(message: $res['message']);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deployment(TradeCopier $copier, string $id, string $deployment): void
    {
        $this->authorize('manage subscribers');
        try {
            $res = $copier->deployment([
                'account' => $id,
                'deploy_type' => $deployment,
            ]);
            $this->alert(message: $res['message']);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function setSync(string $id, string $master)
    {
        $this->masterId = $master;
        $this->accountId = $id;
        $this->fixed_provider = 'Yes';
    }

    public function copyTrade(TradeCopier $copier)
    {
        $this->authorize('manage subscribers');

        $this->validate([
            'masterId' => ['required', 'integer'],
        ]);

        try {
            $data = [
                'account' => $this->accountId,
                'master_account_id' => $this->masterId,
            ];

            if ($this->fixed_provider === 'Yes') {
                // $provider = explode('-', $this->masterId);
                $data['fixedProvider'] = 'Yes';
                // $data['master_account_id'] = $provider[1];
            }

            $res = $copier->copyThisTrade($data);

            TradingAccount::where('meta_account_id', $this->accountId)->update([
                'copying_trade' => true,
                'provider' => $this->masterId,
            ]);

            $this->fixed_provider = null;

            $this->flash(message: $res['message'], redirect: route('admin.copytrading.subscribers'));
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deploymentAll(TradeCopier $copier, string $acnt_type, string $type): void
    {
        $this->authorize('manage subscribers');
        try {
            $msg = $copier->deploymentAll("/deployment-all/{$acnt_type}/{$type}");
            $this->alert(message: $msg);
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function refreshSub(TradeCopier $copier)
    {
        $this->authorize('manage subscribers');
        try {
            $subscribers = $copier->subscribers();
            if (count($subscribers) > 0) {
                foreach ($subscribers as $subscriber) {
                    TradingAccount::updateOrCreate(
                        ['meta_account_id' => $subscriber['metapi_account_id']],
                        [
                            'login' => $subscriber['login'],
                            'name' => $subscriber['account_name'],
                            'password' => $subscriber['password'],
                            // 'platform' => $subscriber['platform'],
                            'account_type' => $subscriber['account_type'],
                            'currency' => $subscriber['currency'],
                            'leverage' => $subscriber['leverage'],
                            'server' => $subscriber['server'],
                            'status' => $subscriber['status'] === 'active' ? 'processed' : $subscriber['status'],
                            'copying_trade' => $subscriber['started_copy_trade'],
                            'is_deployed' => $subscriber['deployment_status'] === 'Undeployed' ? false : true,
                            'deployment_status' => strtoupper($subscriber['deployment_status']),
                            'provider' => $subscriber['provider'],
                            'start_date' => $subscriber['start_date'],
                            'end_date' => $subscriber['end_date'],
                        ]
                    );
                }
            }
            $this->alert(message: 'Accounts Refreshed Successfully.');
        } catch (CopytradeErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    private function confirmSub(TradingAccount $account): bool
    {
        if ($account->duration === 'Monthly') {
            $end_at = now()->addMonth();
        } elseif ($account->duration === 'Quaterly') {
            $end_at = now()->addMonths(4);
        } else {
            $end_at = now()->addYear();
        }
        $remindAt = $end_at->subWeek();

        $account->status = 'processed';
        $account->reminded_at = $remindAt;
        $account->end_date = $end_at;
        $account->start_date = now();
        $account->save();

        return true;
    }
}