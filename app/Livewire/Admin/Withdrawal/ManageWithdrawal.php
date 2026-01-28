<?php

namespace App\Livewire\Admin\Withdrawal;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\ProcessWithdrawalRequest;
use App\Models\Settings;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ManageWithdrawal extends Component
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
    public $id = '';
    public $viewWithdrawal = false;

    public function render()
    {
        return view('livewire.admin.withdrawal.manage-withdrawal', [
            'withdrawals' => Withdrawal::search($this->search)->status($this->status)->orderBy('id', $this->order)->with('user:id,name,username')->date($this->fromDate, $this->toDate)->paginate($this->perPage),
        ]);
    }

    //reset all filter
    public function resetFilter()
    {
        $this->reset(['search', 'order', 'status', 'perPage', 'toDate', 'fromDate']);
    }

    public function delete(string $id)
    {
        Gate::authorize('delete withdrawals');
        try {
            $withdrawal = Withdrawal::with('user')->findOrFail($id);
            $user = $withdrawal->user;

            $settings = Cache::get('site_settings');

            $getEPandaPay = new GetEPandaPay();
            $request = new ProcessWithdrawalRequest([
                'proaction' => 'Reject',
                'account_bal' => $user->account_bal,
                'deduction' => $withdrawal->to_deduct,
            ]);

            $response = $getEPandaPay->send($request);

            if ($response->failed()) {
                $error = json_decode($response->body());
                $this->alert(type: 'warning', message: $error->message);
                return;
            }

            $data = json_decode($response->body());

            if ($settings->deduction_option === 'userRequest') {
                $withdrawal->user()->update(['account_bal' => $data->data->reverse]);
            }

            $withdrawal->delete();
            Cache::forget('total_withdrawn');
            Cache::forget('chart_pendwithdraw');
            $this->alert(type: 'success', message: 'Withrdwal deleted successfully!');
        } catch (\Throwable) {
            $this->alert(type: 'warning', message: 'Something went wrong!, Withrdwal record does not exist.');
        }
    }

    public function view(int $id): void
    {
        Gate::authorize('view withdrawals');
        $this->id = $id;
        $this->viewWithdrawal = true;
    }

    public function cancel()
    {
        $this->reset('id', 'viewWithdrawal');
    }
}