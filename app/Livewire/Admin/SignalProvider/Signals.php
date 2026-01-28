<?php

namespace App\Livewire\Admin\SignalProvider;

use App\Exceptions\SignalErrorException;
use App\Models\Settings;
use App\Notifications\SignalPublished;
use App\Services\SignalService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Signals extends Component
{
    use LivewireAlert;

    public $signals;
    public $tradeDirection = 'Sell';
    public $tradePair = '';
    public $price = '';
    public $stopLoss = '';
    public $takeProfit1 = '';
    public $takeProfit2 = '';
    public $buyStop = '';
    public $sellStop = '';
    public $buyLimit = '';
    public $sellLimit = '';
    public $signalId;
    public $signalResult = '';
    public $page;
    public $nextPageUrl;
    public $previousPageUrl;
    public $newSignal = false;
    public $addResult = false;
    public $saveAnalysis = false;
    public $active_tab = 'signal';
    public $analysisId;
    public $analyses = [];
    public $description;
    public $image;
    public $image_result;

    public function mount(string $page): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['signal'] !== 'true', 404);

        $this->page = $page;
    }

    public function render(SignalService $signal)
    {
        try {
            $data = $signal->signals($this->page);
            $this->signals = $data['data'];
            $this->nextPageUrl = $data['next_page_url'] ?? '';
            $this->previousPageUrl = $data['prev_page_url'] ?? '';
            $this->analyses = $signal->analysis();
        } catch (SignalErrorException $e) {
            session()->flash('message', $e->getMessage());
        }

        return view('livewire.admin.signal-provider.signals');
    }

    public function setResult(string $id): void
    {
        $this->signalId = $id;
        $this->newSignal = false;
        $this->addResult = true;
    }

    public function addSignal(SignalService $signal): void
    {
        $this->authorize('manage signals');
        try {
            $signal->add([
                'direction' => $this->tradeDirection,
                'pair' => $this->tradePair,
                'price' => $this->price,
                'tp1' => $this->takeProfit1,
                'tp2' => $this->takeProfit2,
                'sl1' => $this->stopLoss,
                'buy_stop' => $this->buyStop,
                'sell_stop' => $this->sellStop,
                'buy_limit' => $this->buyLimit,
                'sell_limit' => $this->sellLimit,
            ]);
            $this->reset([
                'tradeDirection',
                'tradePair',
                'price',
                'takeProfit1',
                'takeProfit2',
                'stopLoss',
                'buyStop',
                'sellStop',
                'buyLimit',
                'sellLimit',
            ]);
            $this->alert(message: 'Signal Added Successfully');
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function deleteSignal(SignalService $signal, string $id): void
    {
        $this->authorize('manage signals');
        try {
            $signal->delete($id);
            $this->alert(message: 'Signal Deleted Successfully');
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function publishSignal(SignalService $signal, string $id): void
    {
        $this->authorize('manage signals');
        try {
            $response = $signal->publish($id);
            $settings = $signal->settings();
            $token = $settings['telegram_bot_api'];
            Http::get('https://api.telegram.org/bot' . $token . '/sendMessage?chat_id=' . $response['chat_id'] . '&text=' . $response['message']);
            $this->alert(message: 'Signal Published Successfully');
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function updateResult(SignalService $signal): void
    {
        $this->authorize('manage signals');

        try {
            $signal->updateResult([
                'signalId' => $this->signalId,
                'result' => $this->signalResult,
            ]);
            $this->flash(message: 'Signal Result Published Successfully', redirect: route('admin.signal.signals', ['page' => 1]));
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function editAnalysis(string $id, string $description)
    {
        $this->analysisId = $id;
        $this->description = $description;
        $this->saveAnalysis = true;
        // dd($this->all());
    }

    public function cancelAnalysis(): void
    {
        $this->saveAnalysis = false;
        $this->analysisId = null;
        $this->description = null;
    }

    public function deleteAnalysis(SignalService $signal, string $id): void
    {
        $this->authorize('manage signals');
        try {
            $signal->deleteAnalysis($id);
            $this->alert(message: 'Analysis Deleted Successfully');
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }

    public function publishAnalysis(SignalService $signal, string $id, string $type): void
    {
        $this->authorize('manage signals');
        try {
            $analysis = collect($signal->analysis())->where('id', $id)->first();

            if ($type == 'result') {
                $imageUrl = asset('storage/' . $analysis['image_result']); // generates full URL
            } else {
                $imageUrl = asset('storage/' . $analysis['image']); // generates full URL
            }
            $signal->publishAnalysis([
                'id' => $id,
                'image_url' => $imageUrl,
            ]);

            $this->alert(message: 'Analysis Published Successfully');
        } catch (SignalErrorException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
