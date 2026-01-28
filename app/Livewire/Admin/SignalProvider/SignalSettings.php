<?php

namespace App\Livewire\Admin\SignalProvider;

use App\Exceptions\SignalErrorException;
use App\Models\Settings;
use App\Services\SignalService;
use App\Services\Website;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SignalSettings extends Component
{
    use LivewireAlert;

    public $monthlyFee = '';
    public $quaterlyFee = '';
    public $yearlyFee = '';
    public $chatId = '';
    public $botToken = '';
    public $publish_message;
    public $result_message;

    public function mount(): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['signal'] !== 'true', 404);
    }

    public function render(SignalService $signal)
    {
        try {
            $settings = $signal->settings();
            $this->monthlyFee = $settings['signal_monthly_fee'];
            $this->quaterlyFee = $settings['signal_quartly_fee'];
            $this->yearlyFee = $settings['signal_yearly_fee'];
            $this->chatId = $settings['chat_id'];
            $this->botToken = $settings['telegram_bot_api'];
            $this->publish_message = $settings['publish_message'];
            $this->result_message = $settings['result_message'];
        } catch (SignalErrorException $e) {
            session()->flash('message', $e->getMessage());
        } catch (\Throwable $th) {
            session()->flash('message', $th->getMessage());
        }
        return view('livewire.admin.signal-provider.signal-settings');
    }

    public function saveSettings(SignalService $signal): void
    {
        $this->authorize('manage signal settings');
        try {
            $message = $signal->updateSignalSettings([
                'website' => Website::url(includeConnection: true) . '/get-started',
                'monthly' => $this->monthlyFee,
                'quaterly' => $this->quaterlyFee,
                'yearly' => $this->yearlyFee,
                'telegram_link' => '',
                'telegram_bot_api' => $this->botToken,
                'publish_message' => $this->publish_message,
                'result_message' => $this->result_message,
            ]);

            $settings = Settings::find(1);
            $settings->telegram_bot_api = $this->botToken;
            $settings->save();

            $this->alert(message: $message);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function getChatId(SignalService $signal)
    {
        $this->authorize('manage signal settings');
        try {
            $message = $signal->getChatId();
            $this->alert(message: $message);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deleteChatId(SignalService $signal)
    {
        $this->authorize('manage signal settings');
        try {
            $message = $signal->deletChatId();
            $this->alert(message: $message);
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
