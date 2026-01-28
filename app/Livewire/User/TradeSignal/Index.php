<?php

namespace App\Livewire\User\TradeSignal;

use App\Exceptions\SignalErrorException;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Services\SignalService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Index extends Component
{
    use LivewireAlert;

    public $set;
    public $page;
    public $nextPageUrl;
    public $previousPageUrl;
    public $signals;

    public function mount(SignalService $signal, string $page)
    {
        $this->page = $page;
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['signal'] !== 'true', 404);
        try {
            $this->set = $signal->settings();
        } catch (SignalErrorException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        }
    }
    #[Computed]
    public function signals(SignalService $signal)
    {
        try {
            $data = $signal->signals($this->page);
            $this->nextPageUrl = $data['next_page_url'];
            $this->previousPageUrl = $data['prev_page_url'];
            return $data['data'];
        } catch (SignalErrorException) {
            return [];
        } catch (\Throwable) {
            return [];
        }
    }

    public function render(SignalService $signal)
    {
        try {
            $subscription = $signal->subscription(auth()->user()->id);
            //dd($subscription);
            $data = $signal->signals($this->page);
            // collect only published signals
            $this->signals = collect($data['data'])->where('status', 'published')->all();
            $this->nextPageUrl = $data['next_page_url'];
            $this->previousPageUrl = $data['prev_page_url'];
        } catch (SignalErrorException $e) {
            session()->flash('message', $e->getMessage());
        } catch (\Throwable $e) {
            session()->flash('message', $e->getMessage());
        }

        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.trade-signal.index", [
            'subscription' => $subscription,
        ])
            ->extends("layouts.{$template}")
            ->title('Trade signals');
    }

    public function placeholder(array $params = [])
    {
        return view('livewire.placeholders.skeleton', $params);
    }

    public function renew(SignalService $signal, string $fee)
    {
        $user = User::find(auth()->user()->id);
        $amount = floatval($fee);

        if ($user->account_bal < $amount) {
            $this->alert(type: 'error', message: 'Insufficient funds in your account balance to perform this action');
            return;
        }

        try {
            $signal->renew([
                'id' => $user->id,
            ]);

            // debit user account balance
            $user->account_bal -= $amount;
            $user->save();

            // create transaction history
            Transaction::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'narration' => 'Signal subscription renewal',
                'type' => 'Debit',
            ]);

            // response
            $this->alert(message: 'Subscription Renewed Successfully');
        } catch (SignalErrorException $e) {
            dd($e->getMessage());
            $this->alert(type: 'error', message: $e->getMessage());
        } catch (\Throwable $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
