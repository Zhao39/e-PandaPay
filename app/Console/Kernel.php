<?php

namespace App\Console;

use Antimech\Coinbase\Facades\Coinbase as FacadesCoinbase;
use App\Http\Integrations\Solo\AssetPrices;
use App\Jobs\ProcessRoi;
use App\Jobs\SubscriptionReminder;
use App\Models\Coinbase;
use App\Models\CryptoCurrency;
use App\Models\Settings;
use App\Models\User;
use App\Services\UserService;
use App\Traits\BinanceApi;
use App\Traits\Coinpayment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    use Coinpayment;
    use BinanceApi;

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $this->cpaywithcp();
        })->everyMinute();

        $schedule->call(function () {
            $this->queryOrder();
        })->everyMinute();

        $schedule->job(new SubscriptionReminder())->twiceDaily(1, 13);

        $schedule->call(function () {
            $settings = Settings::select('use_api_price_for_swap')->find(1);
            if ($settings->use_api_price_for_swap) {
                CryptoCurrency::where('is_default', true)->get()->each(function (CryptoCurrency $currency) {
                    $request = new AssetPrices(strtolower($currency->symbol));
                    $response = $request->send();
                    if ($response->successful()) {
                        $data = json_decode($response->body(), true);
                        if (! empty($data)) {
                            $currency->disableLogging();
                            $currency->update(['price_in_usd' => $data[0]['Price']]);
                        }
                    }
                });
            }
        })->everyThirtySeconds();

        $schedule->command('activitylog:clean --force')->daily();

        $schedule->call(function () {
            $charges = Coinbase::where('status', 'pending')->get();
            $charges->each(function (Coinbase $chargee) {
                $charge = FacadesCoinbase::getCharge($chargee->transaction_id);
                if (! empty($charge)) {
                    $timeline = collect($charge['data']['timeline']);
                    $completed = $timeline->where('status', 'NEW');
                    $hasCompleted = $completed->first();
                    if ($hasCompleted) {
                        $user = User::find($chargee->user_id);
                        (new UserService($user))->saveDeposit(paymentData: [
                            'user_id' => $user->id,
                            'payment_mode' => 'Coinbase',
                            'amount' => $chargee->amount,
                            'status' => 'Processed',
                            'txn_id' => $chargee->transaction_id,
                        ]);
                    } else {
                        $expired = $timeline->where('status', 'EXPIRED');
                        $hasExpired = $expired->first();
                        if ($hasExpired) {
                            $chargee->delete();
                        }
                    }
                }
            });
            echo 'Finish checking for charges';
        })->everyMinute();

        $schedule->call(function () {
            ProcessRoi::dispatchSync();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}