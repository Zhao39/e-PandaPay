<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use KingFlamez\Rave\Facades\Rave;
use Srmklive\PayPal\Facades\PayPal;
use Unicodeveloper\Paystack\Facades\Paystack;

class ActionController extends Controller
{
    public function paypalCancelTransaction(Request $request): RedirectResponse
    {
        $request->session()->forget('deposit_amount');
        return redirect()->route('user.deposit.make')->with('message', 'Paypal Transaction cancelled');
    }

    public function paypalSuccessTransaction(Request $request): RedirectResponse
    {
        $provider = PayPal::setProvider();
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $user = User::find(auth()->user()->id);

            try {
                (new UserService($user))->saveDeposit(paymentData: [
                    'user_id' => $user->id,
                    'payment_mode' => 'Paypal',
                    'amount' => $request->session()->get('deposit_amount'),
                    'status' => 'Processed',
                ]);

                $request->session()->forget('deposit_amount');
                return redirect()
                    ->route('user.deposit.make')
                    ->with('success', 'Transaction complete.');
            } catch (\Throwable) {
                return redirect()
                    ->route('user.deposit.make')
                    ->with('message', $response['message'] ?? 'Something went wrong.');
            }
        } else {
            return redirect()
                ->route('user.deposit.make')
                ->with('message', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function binanceSuccess()
    {
        return redirect()->route('user.deposit.make')->with('success', 'Your Deposit was successful, please wait while it is confirmed. You will receive a notification regarding the status of your deposit.');
    }

    public function binanceError()
    {
        return redirect()->route('user.deposit.make')->with('message', 'Something went wrong please try again. Contact our support if problem persist');
    }

    public function paystackSuccess(Request $request): RedirectResponse
    {
        try {
            $paymentDetails = Paystack::getPaymentData();
            $txn_ref = $paymentDetails['data']['reference'];

            $user = User::where('id', auth()->user()->id)->first();

            (new UserService($user))->saveDeposit(paymentData: [
                'user_id' => $user->id,
                'payment_mode' => 'Credit-Debit Card(Paystack)',
                'amount' => $request->session()->get('deposit_amount'),
                'status' => 'Processed',
                'txn_id' => $txn_ref,
            ]);
            $request->session()->forget('deposit_amount');
            return redirect()
                ->route('user.deposit.make')
                ->with('success', 'Transaction complete.');
        } catch (\Throwable) {
            return redirect()
                ->route('user.deposit.make')
                ->with('message', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paystackCancel()
    {
        return redirect()->route('user.deposit.make')->with('message', 'Something went wrong please try again. Contact our support if problem persist');
    }

    public function coinbaseCallback()
    {
        return redirect()->route('user.deposit.make')->with('success', 'Your Deposit was successful, please wait while it is confirmed. You will receive a notification regarding the status of your deposit.');
    }

    public function raveCallback(Request $request): RedirectResponse
    {
        $status = $request->status;

        if ($status === 'successful') {
            $user = User::find(auth()->user()->id);
            $transactionID = Rave::getTransactionIDFromCallback();
            Rave::verifyTransaction($transactionID);
            (new UserService($user))->saveDeposit(paymentData: [
                'user_id' => $user->id,
                'payment_mode' => 'Credit-Debit Card(Flutterwave)',
                'amount' => $request->session()->get('deposit_amount'),
                'status' => 'Processed',
            ]);
            $request->session()->forget('deposit_amount');
            return redirect()->route('user.deposit.make')->with('success', 'Payment was successful.');
        }
        if ($status === 'cancelled') {
            return redirect()->route('user.deposit.make')->with('message', 'Payment is cancelled, please try payment again');
        }
        return redirect()->route('user.deposit.make')->with('message', 'Something went wrong, please try payment again');
    }
}
