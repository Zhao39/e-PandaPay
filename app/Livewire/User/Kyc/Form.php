<?php

namespace App\Livewire\User\Kyc;

use App\Mail\UserSubmitKycMail;
use App\Models\Kyc;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\User\KycApplicationReceivedNotification;
use App\Rules\PhoneNumberRule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Form extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $first_name;
    public $last_name;
    public $email;
    public $phone_number;
    public $dob;
    public $social_media;
    public $address;
    public $city;
    public $state;
    public $country;
    public $document_type = "Int'l Passport";
    public $frontImg;
    public $backImg;
    public $status = 'under review';

    public function mount(): void
    {
        $settings = Settings::select('id', 'enable_kyc')->find(1);
        if (! $settings->enable_kyc || auth()->user()->account_verify === 'under review') {
            $this->flash('warning', 'Start Kyc Application', redirect: route('user.kyc.start'));
        }
    }

    public function render()
    {
        $template = Settings::select('id', 'theme')->find(1)->theme;
        return view("{$template}.kyc.form")
            ->extends("layouts.{$template}")
            ->title('Start KYC');
    }

    public function submit(): void
    {
        $validated = $this->validate([
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
            'document_type' => ['required', 'string', 'max:190'],
            'frontImg' => [
                'required',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('30mb'),
            ],
            'backImg' => ['required',   File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf'])->max('30mb')],
            'status' => ['required'],
        ]);
        try {
            // user
            $user = User::find(auth()->user()->id);
            // save uploaded images
            $image_front = $this->frontImg->store('kyc', 'local'); //$this->frontimg->store('kyc', 'local');
            $image_back = $this->backImg->store('kyc', 'local');
            // save to db
            $filtered = Arr::except($validated, ['frontImg', 'backImg']);
            $kyc = Kyc::create($filtered + ['frontimg' => $image_front, 'backimg' => $image_back, 'user_id' => $user->id]);
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

            $this->reset();
            $this->flash('success', 'KYC Submitted Successfully, please wait while we verify your details', redirect: route('user.kyc.start'));
        } catch (\Throwable $e) {
            $this->alert('error', 'Something went wrong, please contact support');
        }
    }
}
