<?php

namespace App\Traits;

use App\Models\CoinPayment as ModelsCoinPayment;
use App\Models\Settings;
use App\Models\User;
use App\Services\UserService;

trait Coinpayment
{
    private $private_key = '';
    private $public_key = '';
    private $ch = null;

    public function Setup($private_key, $public_key)
    {
        $this->private_key = $private_key;
        $this->public_key = $public_key;
        $this->ch = null;
    }

    /**
     * Gets the current CoinPayments.net exchange rate. Output includes both crypto and fiat currencies.
     *
     * @param short If short == TRUE (the default), the output won't include the currency names and confirms needed to save bandwidth.
     */
    public function GetRates($short = true)
    {
        $short = $short ? 1 : 0;
        return $this->api_call('rates', ['short' => $short]);
    }

    /**
     * Gets your current coin balances (only includes coins with a balance unless all = TRUE).<br />
     *
     * @param all If all = TRUE then it will return all coins, even those with a 0 balance.
     */
    public function GetBalances($all = false)
    {
        return $this->api_call('balances', ['all' => $all ? 1 : 0]);
    }

    /**
     * Creates a basic transaction with minimal parameters.<br />
     * See CreateTransaction for more advanced features.
     *
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency1 The source currency (ie. USD), this is used to calculate the exchange rate for you.
     * @param currency2 The cryptocurrency of the transaction. currency1 and currency2 can be the same if you don't want any exchange rate conversion.
     * @param address Optionally set the payout address of the transaction. If address is empty then it will follow your payout settings for that coin.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     * @param buyer_email Optionally (recommended) set the buyer's email so they can automatically claim refunds if there is an issue with their payment.
     */
    public function CreateTransactionSimple($amount, $currency1, $currency2, $address = '', $ipn_url = '', $buyer_email = '')
    {
        $req = [
            'amount' => $amount,
            'currency1' => $currency1,
            'currency2' => $currency2,
            'address' => $address,
            'ipn_url' => $ipn_url,
            'buyer_email' => $buyer_email,
        ];
        return $this->api_call('create_transaction', $req);
    }

    public function GetWithdrawalInfo($txId)
    {
        $req = [
            'txid' => $txId,
        ];
        return $this->api_call('get_withdrawal_info', $req);
    }

    public function CreateTransaction($req)
    {
        // See https://www.coinpayments.net/apidoc-create-transaction for parameters
        return $this->api_call('create_transaction', $req);
    }

    /**
     * Creates an address for receiving payments into your CoinPayments Wallet.<br />
     *
     * @param currency The cryptocurrency to create a receiving address for.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     */
    public function GetCallbackAddress($currency, $ipn_url = '')
    {
        $req = [
            'currency' => $currency,
            'ipn_url' => $ipn_url,
        ];
        return $this->api_call('get_callback_address', $req);
    }

    public function GetTransactionInformation($txId)
    {
        $req = [
            'txid' => $txId,
        ];
        return $this->api_call('get_tx_info', $req);
    }

    /**
     * Creates a withdrawal from your account to a specified address.<br />
     *
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param address The address to send the coins to.
     * @param auto_confirm If auto_confirm is TRUE, then the withdrawal will be performed without an email confirmation.
     * @param ipn_url Optionally set an IPN handler to receive notices about this transaction. If ipn_url is empty then it will use the default IPN URL in your account.
     */
    public function CreateWithdrawal($amount, $add_tx_fee, $currency, $currency2, $address, $auto_confirm = false, $ipn_url = '')
    {
        $req = [
            'amount' => $amount,
            'add_tx_fee' => $add_tx_fee,
            'currency' => $currency,
            'currency2' => $currency2,
            'address' => $address,
            'auto_confirm' => $auto_confirm ? 1 : 0,
            'ipn_url' => $ipn_url,
        ];
        return $this->api_call('create_withdrawal', $req);
    }

    /**
     * Creates a transfer from your account to a specified merchant.<br />
     *
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param merchant The merchant ID to send the coins to.
     * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
     */
    public function CreateTransfer($amount, $currency, $merchant, $auto_confirm = false)
    {
        $req = [
            'amount' => $amount,
            'currency' => $currency,
            'merchant' => $merchant,
            'auto_confirm' => $auto_confirm ? 1 : 0,
        ];
        return $this->api_call('create_transfer', $req);
    }

    /**
     * Creates a transfer from your account to a specified $PayByName tag.<br />
     *
     * @param amount The amount of the transaction (floating point to 8 decimals).
     * @param currency The cryptocurrency to withdraw.
     * @param pbntag The $PayByName tag to send funds to.
     * @param auto_confirm If auto_confirm is TRUE, then the transfer will be performed without an email confirmation.
     */
    public function SendToPayByName($amount, $currency, $pbntag, $auto_confirm = false)
    {
        $req = [
            'amount' => $amount,
            'currency' => $currency,
            'pbntag' => $pbntag,
            'auto_confirm' => $auto_confirm ? 1 : 0,
        ];
        return $this->api_call('create_transfer', $req);
    }

    //COINPAYMENT TRANSACTIONS

    // pay with coinpayment option
    // pay with coinpayment option
    public function paywithcp(string $amount, string $coin, string $ui, string $msg, ?string $address = null): array
    {
        $user = User::find($ui);
        $settings = Settings::select(['cp_p_key', 'cp_pv_key', 'cp_m_id', 'cp_ipn_secret', 'cp_debug_email', 'coinpayment_to_wallet'])->find(1);

        //create transaction
        if ($msg === 'new') {
            $this->Setup($settings->cp_pv_key, $settings->cp_p_key);

            $req = [
                'amount' => $amount,
                'currency1' => 'USD',
                'currency2' => $coin,
                'buyer_email' => $user->email,
                'buyer_name' => $user->name,
                'item_name' => 'Account deposit',
                'ipn_url' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '_p',
            ];

            if ($settings->coinpayment_to_wallet) {
                $req['address'] = $address;
            }

            $result = $this->CreateTransaction($req);

            if ($result['error'] === 'ok') {
                //if transacton created successful

                $txn_id = $result['result']['txn_id'];

                //store transacton details in DB
                $txn = new ModelsCoinPayment();
                $txn->txn_id = $txn_id;
                $txn->item_name = 'Account deposit';
                $txn->type = 'Deposit';
                $txn->amount_paid = $amount;
                $txn->user_id = $ui;
                $txn->currency1 = 'USD';
                $txn->currency2 = $coin;
                $txn->save();

                $res = $this->GetTransactionInformation($txn_id);
                //get the array info of transaction
                if ($res['error'] !== 'ok') {
                    return [
                        'status' => 'error',
                        'message' => 'Transaction error!',
                    ];
                }

                return [
                    'status' => 'success',
                    'p_address' => $result['result']['address'],
                    'p_qrcode' => $result['result']['qrcode_url'],
                ];
            }
            return [
                'status' => 'error',
                'message' => $result['error'],
            ];
        }
        if ($msg === 'new_p') {
            //credit fund to user account
            User::where('id', $ui)->update([
                'account_bal' => $user->account_bal + $amount,
            ]);
            return redirect()->route('user.deposit.make')->with('success', 'Payment successful!');
        }
    }

    public function cpaywithcp()
    {
        $settings = Settings::select(['cp_p_key', 'cp_pv_key', 'cp_m_id', 'cp_ipn_secret', 'cp_debug_email'])->find(1);

        $this->Setup($settings->cp_pv_key, $settings->cp_p_key);

        //fetch Coinpayment unconfirmed txns
        $cp_txns = ModelsCoinPayment::whereNull('status')
            ->orWhere('status', 'Waiting for buyer funds...')
            ->get();

        if (count($cp_txns) > 0) {
            foreach ($cp_txns as $txn) {
                $txn_id = $txn->txn_id;
                $result = $this->GetTransactionInformation($txn_id);

                //get the array info of transaction
                if ($result['error'] === 'ok') {
                    $status = $result['result']['status'];

                    if ($status >= 100 || $status === 2) {
                        // payment is complete or queued for nightly payout, success

                        //Update txn info on cp_txns
                        ModelsCoinPayment::where('id', $txn->id)
                            ->update([
                                'status' => $result['result']['status'],
                                'status_text' => $result['result']['status_text'],
                            ]);

                        //get user
                        $user = User::where('id', $txn->user_id)->first();

                        (new UserService($user))->saveDeposit(paymentData: [
                            'user_id' => $user->id,
                            'payment_mode' => "{$txn->currency2}(CoinPayment)",
                            'amount' => $txn->amount_paid,
                            'status' => 'Processed',
                        ]);
                    } elseif ($status < 0) {
                        //payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent
                        //Update txn info on cp_txns
                        ModelsCoinPayment::where('id', $txn->id)
                            ->update([
                                'status' => $result['result']['status'],
                                'status_text' => $result['result']['status_text'],
                            ]);
                    } else {
                        //payment is pending, you can optionally add a note to the order page
                        //Update txn info on cp_txns
                        ModelsCoinPayment::where('id', $txn->id)
                            ->update([
                                'status_text' => $result['result']['status_text'],
                            ]);
                    }
                }
            }
        }
    }

    public function cpwithdraw(
        float $amount,
        ?string $coin,
        ?string $wallet,
    ): array {
        //get settings
        $settings = Settings::select(['cp_p_key', 'cp_pv_key', 'cp_m_id', 'cp_ipn_secret', 'cp_debug_email', 's_currency'])->find(1);

        $this->Setup($settings->cp_pv_key, $settings->cp_p_key);

        $result = $this->CreateWithdrawal($amount, 1, $coin, trim($settings->s_currency), $wallet);

        if ($result['error'] !== 'ok') {
            return [
                'status' => 'error',
                'message' => $result['error'],
            ];
        }

        return [
            'status' => 'success',
            'txn_id' => $result['result']['id'],
            'payment_status' => $result['result']['status'],
        ];
    }

    private function is_setup()
    {
        return ! empty($this->private_key) && ! empty($this->public_key);
    }

    private function api_call($cmd, $req = [])
    {
        if (! $this->is_setup()) {
            return ['error' => 'You have not called the Setup function with your private and public keys!'];
        }

        // Set the API command and required fields
        $req['version'] = 1;
        $req['cmd'] = $cmd;
        $req['key'] = $this->public_key;
        $req['format'] = 'json'; //supported values are json and xml

        // Generate the query string
        $post_data = http_build_query($req, '', '&');

        // Calculate the HMAC signature on the POST data
        $hmac = hash_hmac('sha512', $post_data, $this->private_key);

        // Create cURL handle and initialize (if needed)
        if ($this->ch === null) {
            $this->ch = curl_init('https://www.coinpayments.net/api.php');
            curl_setopt($this->ch, CURLOPT_FAILONERROR, true);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, ['HMAC: ' . $hmac]);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post_data);

        $data = curl_exec($this->ch);
        if ($data !== false) {
            if (PHP_INT_SIZE < 8 && version_compare(PHP_VERSION, '5.4.0') >= 0) {
                // We are on 32-bit PHP, so use the bigint as string option. If you are using any API calls with Satoshis it is highly NOT recommended to use 32-bit PHP
                $dec = json_decode($data, true, 512, JSON_BIGINT_AS_STRING);
            } else {
                $dec = json_decode($data, true);
            }
            if ($dec !== null && count($dec)) {
                return $dec;
            }
            // If you are using PHP 5.5.0 or higher you can use json_last_error_msg() for a better error message
            return ['error' => 'Unable to parse JSON result (' . json_last_error() . ')'];
        }
        return ['error' => 'cURL error: ' . curl_error($this->ch)];
    }
}
