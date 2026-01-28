<?php

namespace App\Livewire\Admin\ManageDeposits;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\ProcessDepositRequest;
use App\Models\Deposit;
use App\Models\Settings;
use App\Models\Transaction;
use App\Notifications\User\DepositConfirmedNotification;
use App\Services\ReferralCommisionService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Records extends Component
{
    use WithPagination;
    use LivewireAlert;

    #[Url(except: '')]
    public $search = '';
    public $order = 'desc';
    public $status = 'All';
    public $perPage = 10;
    public $toDate = '';
    public $fromDate = '';
    public $deleteId = '';

    #[On('close-deposit-modal')]
    public function render()
    {
        return view('livewire.admin.manage-deposits.records', [
            'deposits' => Deposit::search($this->search)->status($this->status)->orderBy('id', $this->order)->with('user:id,name,username')->date($this->fromDate, $this->toDate)->paginate($this->perPage),
        ]);
    }

    //reset all filter
    public function resetFilter()
    {
        $this->reset(['search', 'order', 'status', 'perPage', 'toDate', 'fromDate']);
    }

    // delete deposit record
    public function delete(string $id)
    {
        Gate::authorize('delete deposits');
        try {
            $deposit = Deposit::findOrFail($id);
            if (! empty($deposit->proof) && Storage::disk('public')->exists($deposit->proof)) {
                Storage::disk('public')->delete($deposit->proof);
            }
            $deposit->delete();
            Cache::forget('total_deposited');
            Cache::forget('chart_pendepsoit');
            $this->alert(type: 'success', message: 'Deposit Deleted Successfully.');
        } catch (\Throwable) {
            $this->alert(type: 'warning', message: 'Something went wrong!, deposit does not exist.');
        }
    }

    //process deposits
    public function confirmDeposit(int $id)
    {
        Gate::authorize('process deposits');

        try {
            $deposit = Deposit::findOrFail($id);

            $settings = Cache::get('site_settings');
            $GetEPandaPay = new GetEPandaPay();
            $request = new ProcessDepositRequest([
                'amount' => $deposit->amount,
                'user' => $deposit->user->id,
                'account_bal' => $deposit->user->account_bal,
                'bonus' => $deposit->user->bonus,
                'depositBonus' => $settings->deposit_bonus,
            ]);

            $res = $GetEPandaPay->send($request);

            $response = json_decode($res->body(), true);

            if ($res->failed()) {
                $this->alert(type: 'warning', message: $response['message']);
                return;
            }

            $deposit->user()->update($response['data']['fracture']);

            if ($settings->deposit_bonus !== null and $settings->deposit_bonus > 0) {
                Transaction::create([
                    'user_id' => $deposit->user->id,
                    'narration' => "Deposit Bonus for {$settings->currency} {$deposit->amount} deposited",
                    'amount' => $response['data']['fracture']['bonus'],
                    'type' => 'Credit',
                ]);
            }
            // credit referral commission
            if ($settings->referral_proffit_from === 'Deposit') {
                $ref = new ReferralCommisionService($deposit->user, $deposit->amount);
                $ref->run();
            }

            //update deposit status
            $deposit->status = 'Processed';
            $deposit->save();
            Cache::forget('total_deposited');
            Cache::forget('chart_pendepsoit');
            // send email notfication to user with deposit details
            if ($settings->send_deposit_email) {
                $in_app_message = "Your deposit of {$settings->currency} {$deposit->amount} has been processed.";
                dispatch(function () use ($deposit, $in_app_message) {
                    $deposit->user->notify(new DepositConfirmedNotification($deposit, $in_app_message));
                })->afterResponse();
            }

            $this->alert(type: 'success', message: 'Deposit confirmed Successfully.');
        } catch (\Throwable $th) {
            $this->alert(type: 'warning', message: $th->getMessage());
        }
    }
}
