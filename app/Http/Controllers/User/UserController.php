<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\UserSubmitKycMail;
use App\Models\Kyc;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\User\KycApplicationReceivedNotification;
use App\Rules\PhoneNumberRule;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\File;

class UserController extends Controller
{
    public function submitPayment(Request $request): RedirectResponse
    {
        $request->validate([
            'proof' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('25mb'),
            ],
        ]);

        $user = User::find(auth()->user()->id);

        try {
            (new UserService($user))->saveDeposit(paymentData: [
                'user_id' => $user->id,
                'payment_mode' => $request->method_name,
                'amount' => $request->amount,
                'status' => 'Pending',
                'proof' => $request->file('proof')->store('proofs'),
            ]);

            session()->forget('deposit_amount');
            return to_route('user.deposit.make')->with('success', 'Payment Completed, you will be notified once this payment is confirmed');
        } catch (\Throwable) {
            return to_route('user.deposit.make')->with('error', 'Something went wrong, please try again or contact support');
        }
    }

    public function submitKyc(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:190'],
            'last_name' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone_number' => ['required', new PhoneNumberRule()],
            'dob' => ['required', 'date'],
            'social_media' => ['nullable', 'string', 'max:190'],
            'address' => ['required', 'string', 'max:190'],
            'city' => ['required', 'string', 'max:190'],
            'state' => ['required', 'string', 'max:190'],
            'country' => ['required', 'string', 'max:190'],
            'document_type' => ['nullable', 'string', 'max:190'],
            'frontImg' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('30mb'),
            ],
            'backImg' => ['required',   File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('30mb')],
        ]);
        // dd($validated);
        try {
            // user
            $user = User::find(auth()->user()->id);
            // save uploaded images
            $image_front = $request->file('frontImg')->store('kyc', 'local'); //$this->frontimg->store('kyc', 'local');
            $image_back = $request->file('backImg')->store('kyc', 'local');
            // save to db
            $filtered = Arr::except($validated, ['frontImg', 'backImg']);
            $kyc = Kyc::create($filtered + ['frontimg' => $image_front, 'backimg' => $image_back, 'user_id' => $user->id, 'status' => 'under review']);
            $settings = Settings::select(['id', 'receive_kyc_submission_email', 'send_kyc_status_email', 'notifiable_email'])->find(1);
            // update user
            $user->account_verify = 'under review';
            $user->save();
            // send notification
            if ($settings->send_kyc_status_email) {
                $message = 'Your Kyc has been submitted. Please wait while we verify your details.';
                dispatch(function () use ($user, $kyc, $message) {
                    $user->notify(new KycApplicationReceivedNotification(kyc: $kyc, message: $message));
                })->afterResponse();
            }
            if ($settings->receive_kyc_submission_email) {
                dispatch(function () use ($kyc, $settings) {
                    Mail::to($settings->notifiable_email)->send(new UserSubmitKycMail(kyc: $kyc));
                })->afterResponse();
            }

            return to_route('user.kyc.start')->with('success', 'KYC Submitted Successfully, please wait while we verify your details');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}