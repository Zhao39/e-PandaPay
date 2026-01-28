<?php

namespace App\Livewire\User\Deposit;

use Antimech\Coinbase\Facades\Coinbase;
use App\Models\BinanceTransaction;
use App\Models\Coinbase as ModelsCoinbase;
use App\Models\PaymentMethod;
use App\Models\Settings;
use App\Models\User;
use App\Services\UserService;
use App\Traits\BinanceApi;
use App\Traits\Coinpayment;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use KingFlamez\Rave\Facades\Rave;
use Livewire\Component;
use Livewire\WithFileUploads;
use Srmklive\PayPal\Facades\PayPal;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Unicodeveloper\Paystack\Facades\Paystack;

class MakePayment extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use BinanceApi;
    use Coinpayment;

    public PaymentMethod $method;
    public $client_secret;
    public $amount;
    public $proof;
    public $hasQrcode = false;
    public $qrcode;
    public $coinpayment_address;

    public function mount($method): void
    {
        $this->amount = session()->get('deposit_amount');

        if (is_null($this->amount)) {
            $this->redirect(route('user.deposit.make'));
        }

        $settings = Settings::select(['credit_card_provider', 's_currency', 's_s_k'])->find(1);

        $this->method = $method;

        if ($method->name === 'Credit-Debit Card' and $settings->credit_card_provider === 'Stripe') {
            $amt = "{$this->amount}00";

            try {
                Stripe::setApiKey($settings->s_s_k);
                $paymentIntent = PaymentIntent::create([
                    'amount' => $amt,
                    'currency' => strtolower(trim($settings->s_currency)),
                    'payment_method_types' => ['card'],
                    'description' => 'Funding My Account',
                    'shipping' => [
                        'name' => auth()->user()->name,
                        'address' => [
                            'line1' => 'No Address',
                            'postal_code' => '000000',
                            'city' => 'No City',
                            'state' => 'CA',
                            'country' => 'US',
                        ],
                    ],
                    'metadata' => ['integration_check' => 'accept_a_payment'],
                ]);
                $this->client_secret = $paymentIntent->client_secret;
            } catch (\Throwable) {
                $this->flash(type: 'error', message: 'Something went wrong, please try again or contact support', redirect: route('user.deposit.make'));
            }
        }
    }
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.deposit.make-payment")
            ->extends("layouts.{$template}")
            ->title('Make a Deposit');
    }

    public function savePayment(): void
    {
        $this->validate([
            'proof' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('25mb'),
            ],
        ]);

        $user = User::find(auth()->user()->id);

        try {
            (new UserService($user))->saveDeposit(paymentData: [
                'user_id' => $user->id,
                'payment_mode' => $this->method->name,
                'amount' => $this->amount,
                'status' => 'Pending',
                'proof' => $this->proof->store('proofs'),
            ]);

            session()->forget('deposit_amount');
            $this->flash(type: 'success', message: 'Payment Completed, you will be notified once this payment is confirmed', redirect: route('user.deposit.make'));
        } catch (\Throwable) {
            $this->flash(type: 'error', message: 'Something went wrong, please try again or contact support', redirect: route('user.deposit.make'));
        }
    }

    public function payWithPayPal()
    {
        $settings = Settings::select(['s_currency'])->find(1);

        $provider = PayPal::setProvider();
        $provider->getAccessToken();

        try {
            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('user.deposit.paypalSuccessTransaction'),
                    'cancel_url' => route('user.deposit.paypalCancelTransaction'),
                ],
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => rtrim($settings->s_currency, ' '),
                            'value' => $this->amount,
                        ],
                    ],
                ],
            ]);
            if (isset($response['id']) && $response['id'] !== null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] === 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                $this->alert(type: 'error', message: 'Something went wrong, please try again or contact support');
            } else {
                $this->alert(type: 'error', message: $response['message'] ?? 'Something went wrong, please try again or contact support');
            }
        } catch (\Throwable $e) {
            $this->alert(type: 'error', message: 'Something went wrong, please try again or contact support');
        }
    }

    public function payViaBinance()
    {
        $successUrl = route('user.deposit.bsuccess');
        $errorUrl = route('user.deposit.berror');
        $transactionID = $this->createTransactionId(10);
        try {
            $order = $this->createOrder($this->amount, $transactionID, $successUrl, $errorUrl);
            $response = json_decode($order);
            if ($response->code === 0) {
                $this->alert(type: 'error', message: $response->msg);
                return;
            }
            $data = $response->data;

            // Save binance tracking number to database
            $brecord = new BinanceTransaction();
            $brecord->user_id = auth()->user()->id;
            $brecord->prepay_id = $data->prepayId;
            $brecord->type = 'Deposit';
            $brecord->status = 'Pending';
            $brecord->save();
            // Redirect to binance checkout
            return redirect()->away($data->checkoutUrl);
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }

    public function payViaCoinpayment(): void
    {
        try {
            $response = $this->paywithcp(
                amount: $this->amount,
                coin: strtoupper($this->method->coin),
                ui: auth()->user()->id,
                msg: 'new',
                address: $this->method->wallet_address
            );

            if ($response['status'] === 'error') {
                $this->alert(type: 'error', message: $response['message']);
                return;
            }

            $this->hasQrcode = true;
            $this->qrcode = $response['p_qrcode'];
            $this->coinpayment_address = $response['p_address'];
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }

    public function payViaCoinbase()
    {
        $settings = Settings::select('s_currency')->find(1);
        try {
            $charge = Coinbase::createCharge([
                'name' => 'Deposit',
                'description' => 'Deposit with coinbase',
                'local_price' => [
                    'amount' => $this->amount,
                    'currency' => trim($settings->s_currency),
                ],
                'pricing_type' => 'fixed_price',
                'redirect_url' => route('user.deposit.coinbaseCallback'),
                'metadata' => [
                    'id' => auth()->user()->id,
                    'email' => auth()->user()->email,
                ],
            ]);

            $trx = new ModelsCoinbase();
            $trx->amount = $this->amount;
            $trx->user_id = auth()->user()->id;
            $trx->description = 'Deposit with coinbase';
            $trx->charge_code = $charge['data']['code'];
            $trx->transaction_id = $charge['data']['id'];
            $trx->save();

            return redirect()->away($charge['data']['hosted_url']);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            $this->alert(type: 'error', message: 'Something went wrong, try again. Contact support if issue persits.');
        }
    }

    // paystack

    public function payWithPaystack()
    {
        try {
            $s_currency = Settings::select('s_currency')->find(1)->s_currency;

            $data = [
                'amount' => floatval($this->amount) * 100,
                'reference' => $this->createTransactionId(10),
                'email' => auth()->user()->email,
                'currency' => rtrim($s_currency, ' '),
                'callback_url' => route('user.deposit.psuccess'),
                'metadata' => [
                    'cancel_action' => route('user.deposit.pcancel'),
                ],
            ];

            return Paystack::getAuthorizationUrl($data)->redirectNow();
        } catch (\Throwable $e) {
            $this->alert(type: 'error', message: 'Something went wrong, please try again or contact support');
        }
    }

    public function payViaRave()
    {
        $reference = Rave::generateReference();
        $s_currency = Settings::select('s_currency')->find(1)->s_currency;
        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => intval($this->amount),
            'email' => auth()->user()->email,
            'tx_ref' => $reference,
            'currency' => $s_currency,
            'redirect_url' => route('user.deposit.ravcallback'),
            'customer' => [
                'email' => auth()->user()->email,
                'name' => auth()->user()->name,
            ],
            'customizations' => [
                'title' => 'Deposit',
                'description' => 'Funding my account balance',
            ],
        ];

        $payment = Rave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            $this->alert(type: 'error', message: 'Something went wrong, please try again or contact support');
            return;
        }

        return redirect()->away($payment['data']['link']);
    }

    private function createTransactionId($n)
    {
        $generated_string = '';
        $domain = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string .= $domain[$index];
        }
        // Return the random generated string
        return $generated_string;
    }
}