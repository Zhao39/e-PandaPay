<?php

namespace App\Livewire\Admin\Kyc;

use App\Models\Kyc;
use App\Models\Settings;
use App\Notifications\User\KycApprovedNotification;
use App\Notifications\User\KycFailedNotification;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SingleApplication extends Component
{
    use LivewireAlert;

    public Kyc $kyc;
    public $reason;
    public $action = 'verified';
    public $status;

    public function mount(Kyc $kyc)
    {
        $this->kyc = $kyc;
        $this->status = $kyc->status;
    }

    public function render()
    {
        return view('livewire.admin.kyc.single-application');
    }

    public function submit()
    {
        Gate::authorize('process kyc applications');

        $settings = Cache::get('site_settings');

        if ($this->action === 'verified') {
            $this->kyc->user->update(['account_verify' => $this->action]);
            $this->kyc->update(['status' => $this->action]);
            if ($settings->send_kyc_status_email) {
                $message = 'Your Kyc has been verified. You can now place a withdrawal request.';
                dispatch(function () use ($message) {
                    $this->kyc->user->notify(new KycApprovedNotification(kyc: $this->kyc, message: $message));
                })->afterResponse();
            }
            $this->status = $this->kyc->status;
            $this->flash(message: 'Kyc Verified Successfully.', redirect: route('admin.kycApplications'));
        }

        if ($this->action === 'reject') {
            if (
                Storage::disk('local')->exists($this->kyc->frontimg) &&
                Storage::disk('local')->exists($this->kyc->backimg)
            ) {
                Storage::disk('local')->delete($this->kyc->frontimg);
                Storage::disk('local')->delete($this->kyc->backimg);
            }

            if ($settings->send_kyc_status_email) {
                $message = 'Your Kyc has been rejected. Please check your email for more details.';
                dispatch(function () use ($message) {
                    $this->kyc->user->notify(new KycFailedNotification(kyc: $this->kyc, message: $message, reason: $this->reason));
                })->afterResponse();
            }

            $this->kyc->user->update(['account_verify' => $this->action]);

            $this->kyc->delete();

            $this->flash(message: 'Kyc Rejected Successfully.', redirect: route('admin.kycApplications'));
        }
    }

    public function downloadFile(string $type)
    {
        try {
            if ($type === 'front') {
                return Storage::disk('local')->download($this->kyc->frontimg);
            }
            return Storage::disk('local')->download($this->kyc->backimg);
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
}