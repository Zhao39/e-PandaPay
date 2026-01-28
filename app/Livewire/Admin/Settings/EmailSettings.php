<?php

namespace App\Livewire\Admin\Settings;

use App\Mail\GeneralMessageMail;
use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EmailSettings extends Component
{
    use LivewireAlert;

    public $set;
    public $mail_server;
    public $emailfrom;
    public $emailfromname;
    public $smtp_host;
    public $smtp_port;
    public $smtp_encrypt;
    public $smtp_user;
    public $smtp_password;
    public $receive_deposit_email;
    public $receive_withdrawal_email;
    public $receive_buyplan_email;
    public $receive_kyc_submission_email;
    public $receive_expired_plan_email;
    public $receive_trade_account_submission_email;
    public $receive_signal_subscribe_email;
    public $receive_buy_course_email;
    public $receive_payment_method_email;
    public $send_deposit_email;
    public $send_withdrawal_email;
    public $send_buyplan_email;
    public $send_expired_plan_email;
    public $send_trade_request_success_email;
    public $send_signal_subscribe_email;
    public $send_buy_course_email;
    public $send_kyc_status_email;
    public $send_roi_email;
    public $send_welcome_email;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->fill($settings);
        $this->set = $settings;
    }

    public function render()
    {
        return view('livewire.admin.settings.email-settings');
    }

    public function save(string $type): void
    {
        $this->authorize('update email settings');
        $all = $this->all();
        $filtered = Arr::except($all, ['set']);
        $this->set->update($filtered);
        Cache::forget('site_settings');
        activity()->log('Email Settings Updated');
        $this->alert(message: 'Settings Saved Successfully.');
    }

    public function testEmail(): void
    {
        $message = 'This is a test email to ensure that your email services are functioning correctly.
        If you have received this email, it means that your system is able to send and deliver emails successfully.
        If you encounter any issues or have any feedback regarding this test, please feel free to contact our support team.';
        try {
            Mail::to($this->set->notifiable_email)->send(new GeneralMessageMail($message, 'Testing email', auth()->user()->name));
            $this->alert(message: 'Email sent to your notifiable email address');
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
}