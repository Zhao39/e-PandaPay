<?php

namespace App\Services;

use App\Exceptions\CopytradeErrorException;
use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\AddTradingAccount;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\BuySlotRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\CopyTradeRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\DeleteAccountRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\DeploymentAllRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\DeployRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\GetAccountInfoRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\GetAccountMetrics;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\GetProvidersAccountRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\GetSettingsRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\GetSubscribersAccountRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\MakePaymentRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\RenewAccountRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\UpdateProfileRequest;
use App\Http\Integrations\GetEPandaPay\Requests\CopyTrade\UpdateStrategyRequest;
use Illuminate\Support\Facades\Cache;

class TradeCopier
{
    private GetEPandaPay $ePandaPay;

    public function __construct()
    {
        $this->ePandaPay = new GetEPandaPay();
    }

    public function providers(): array
    {
        if (Cache::has('providers')) {
            return Cache::get('providers');
        }
        $request = new GetProvidersAccountRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        $providers = $response['data'];

        Cache::put('providers', $providers, now()->addHour());

        return $providers;
    }

    public function subscribers(): array
    {
        $request = new GetSubscribersAccountRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        return $response['data']['data'];
    }

    public function profile(): array
    {
        if (Cache::has('account-profile')) {
            return Cache::get('account-profile');
        }

        $request = new GetAccountInfoRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        $account = $response['data'];

        Cache::put('account-profile', $account, now()->addHour());

        return $account;
    }

    public function settings(): array
    {
        if (Cache::has('copier-settings')) {
            return Cache::get('copier-settings');
        }

        $request = new GetSettingsRequest();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        $settings = $response['data'];

        Cache::put('copier-settings', $settings, now()->addHours(5));

        return $settings;
    }

    public function addAccount(array $data, string $type = 'sub'): array
    {
        $request = new AddTradingAccount($data, $type === 'sub' ? '/create-sub-account' : '/create-copytrade-account');

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        if ($type === 'prov') {
            Cache::forget('providers');
        }
        return $response;
    }

    public function updateStrategy(array $data): string
    {
        $request = new UpdateStrategyRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        Cache::forget('providers');

        return $response['message'];
    }

    public function deleteAccount(string $url, string $type = 'sub'): string
    {
        $request = new DeleteAccountRequest($url);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        if ($type === 'prov') {
            Cache::forget('providers');
        }

        return $response['message'];
    }

    public function copyThisTrade(array $data): array
    {
        $request = new CopyTradeRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        return $response;
    }

    public function deployment(array $data, string $type = 'sub'): array
    {
        $request = new DeployRequest($data, $type === 'sub' ? '/deployment' : '');

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        return $response;
    }

    public function undeploy(): void
    {
    }

    public function completePayment(): void
    {
    }

    public function renewAccount(array $data, string $type = 'sub'): array
    {
        $request = new RenewAccountRequest($data, $type === 'sub' ? '/renew-account' : '/renew-master-account');

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        if ($type === 'prov') {
            Cache::forget('providers');
        }
        return $response;
    }

    public function buySlot(array $data): string
    {
        $request = new BuySlotRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        Cache::forget('account-profile');

        return $response['message'];
    }

    public function addFunds(array $data): string
    {
        $request = new MakePaymentRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        return $response['message'];
    }

    public function updateAccount(array $data): string
    {
        $request = new UpdateProfileRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        Cache::forget('account-profile');

        return $response['message'];
    }

    public function deploymentAll(string $url): string
    {
        $request = new DeploymentAllRequest($url);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        Cache::forget('account-profile');

        return $response['message'];
    }
    public function accountMetrics(string $id, string $type = 'Provider'): array
    {
        if (Cache::has('account_metrics')) {
            return Cache::get('account_metrics');
        }
        $request = new GetAccountMetrics($id, $type);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), CopytradeErrorException::class, $response['message']);

        $metrics = $response['metrics'];

        Cache::put('account_metrics', $metrics, now()->addMinutes(20));

        return $metrics;
    }
}
