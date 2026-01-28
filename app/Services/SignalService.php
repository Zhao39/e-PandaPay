<?php

namespace App\Services;

use App\Exceptions\SignalErrorException;
use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\AddSignalRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\DeleteAnalysis;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\DeleteChatIdRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\DeleteSignalRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\DeleteSubscriberRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetChatIdRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetSignalAnaylsis;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetSignalSettings;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetSignalSubscribers;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetTradeSignals;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\GetUserSubscription;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\PublishAnalysis;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\PublishSignalRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\RenewSubRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\SaveAnalysis;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\SubscribeRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\UnsubscribeUserRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\UpdateSignalResultRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Signal\UpdateSignalSettingsRequest;
use Illuminate\Support\Facades\Cache;

class SignalService
{
    private GetEPandaPay $ePandaPay;

    public function __construct()
    {
        $this->ePandaPay = new GetEPandaPay();
    }
    public function settings(): array
    {
        if (Cache::has('signal-settings')) {
            return Cache::get('signal-settings');
        }

        $request = new GetSignalSettings();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        $settings = $response['data']['settings'];

        Cache::put('signal-settings', $settings, now()->addHour());

        return $settings ?? [];
    }

    public function updateSignalSettings(array $data): string
    {
        $request = new UpdateSignalSettingsRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signal-settings');

        return $response['message'];
    }

    public function getChatId(): string
    {
        $request = new GetChatIdRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signal-settings');

        return $response['message'];
    }

    public function deletChatId(): string
    {
        $request = new DeleteChatIdRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signal-settings');

        return $response['message'];
    }

    public function subscribers(string $page): array
    {
        if (Cache::has("subscribers-{$page}")) {
            return Cache::get("subscribers-{$page}");
        }

        $request = new GetSignalSubscribers($page);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        logger($res->body());
        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        $subscribers = $response['data']['subscribers'];

        Cache::put("subscribers-{$page}", $subscribers, now()->addHour());

        return $subscribers ?? [];
    }

    public function deleteSubscriber(string $id, string $user_id): string
    {
        $request = new DeleteSubscriberRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("subscribers-{$page}");
        }

        Cache::forget('signal-subscription-' . $user_id);

        return $response['message'];
    }

    public function signals(string $page): array
    {
        if (Cache::has("signals-{$page}")) {
            return Cache::get("signals-{$page}");
        }

        $request = new GetTradeSignals($page);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        $settings = $response['data']['signalls'];

        Cache::put("signals-{$page}", $settings, now()->addHour());

        return $settings ?? [];
    }

    public function add(array $data): void
    {
        $request = new AddSignalRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("signals-{$page}");
        }
    }

    public function delete(string $id): void
    {
        $request = new DeleteSignalRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("signals-{$page}");
        }
    }

    public function updateResult(array $data): array
    {
        $request = new UpdateSignalResultRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("signals-{$page}");
        }

        return $response['data'];
    }

    public function publish(string $id): array
    {
        $request = new PublishSignalRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("signals-{$page}");
        }

        return $response['data'];
    }

    public function subscriberBan(array $data): string
    {
        $request = new UnsubscribeUserRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("subscribers-{$page}");
        }

        return $response['message'];
    }

    public function subscription(string $user_id): array | null
    {
        if (Cache::has('signal-subscription-' . $user_id)) {
            return Cache::get('signal-subscription-' . $user_id);
        }

        $request = new GetUserSubscription($user_id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        $sub = $response['data'];

        Cache::put('signal-subscription-' . $user_id, $sub, now()->addHour());

        return $sub;
    }

    public function subscribe(array $data): array
    {
        $request = new SubscribeRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signal-subscription-' . $data['id']);

        foreach (range(1, 20) as $page) {
            Cache::forget("subscribers-{$page}");
        }

        return $response['data'];
    }

    public function renew(array $data): void
    {
        $request = new RenewSubRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);
        logger($res);
        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signal-subscription-' . $data['id']);
        foreach (range(1, 20) as $page) {
            Cache::forget("subscribers-{$page}");
        }
    }

    public function saveAnalysis(array $data): string
    {
        $request = new SaveAnalysis($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget("signals-analysis");

        return $response['message'];
    }

    public function analysis(): array
    {
        if (Cache::has("signals-analysis")) {
            return Cache::get("signals-analysis");
        }

        $request = new GetSignalAnaylsis();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        $anaylsis = $response['data']['analysis'];

        Cache::put("signals-analysis", $anaylsis, now()->addHour());

        return $anaylsis ?? [];
    }

    public function deleteAnalysis(string $id): string
    {
        $request = new DeleteAnalysis($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget('signals-analysis');

        return $response['message'];
    }

    public function publishAnalysis(array $data): string
    {
        $request = new PublishAnalysis($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), SignalErrorException::class, $response['message']);

        Cache::forget("signals-analysis");

        return $response['message'];
    }
}
