<?php

namespace App\Livewire\Admin\Crm;

use App\Mail\CampaignEmail;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class EmailServices extends Component
{
    use LivewireAlert;

    public $users_id = [];
    public $category = 'All';
    public $message;
    public $title = '$fullname';
    public $greeting = 'Hello';
    public $subject;

    public function render()
    {
        return view('livewire.admin.crm.email-services');
    }
    #[Computed()]
    public function users(): Collection
    {
        return User::query()->isNotAdmin()->get();
    }

    public function send(): void
    {
        $this->validate([
            'message' => ['required'],
            'subject' => ['required'],
        ]);

        if ($this->category === 'All') {
            $users = User::isNotAdmin()->select('email', 'name')->cursor();
        } elseif ($this->category === 'No Active Plans') {
            $users = User::isNotAdmin()->whereDoesntHave('investmentPlans', function (Builder $query) {
                $query->where('status', 'active');
            })->select('email', 'name')->cursor();
        } elseif ($this->category === 'No Deposit') {
            $users = User::isNotAdmin()->doesntHave('deposits')->select('email', 'name')->cursor();
        } elseif ($this->category === 'No Withdrawal') {
            $users = User::isNotAdmin()->doesntHave('withdrawals')->select('email', 'name')->cursor();
        } elseif ($this->category === 'Select Users') {
            $users = User::isNotAdmin()
                ->whereIn('id', $this->users_id)
                ->select('email', 'name')
                ->cursor();
        } else {
            $users = null;
        }

        try {
            $users->each(function (User $user): void {
                $name = $user->name;
                if ($this->title !== '$fullname') {
                    $name = $this->title;
                }
                Mail::to($user->email)->send(new CampaignEmail($this->message, $this->subject, $name, $this->greeting));
            });
            $this->flash(message: 'Your Email was sent Successfully.', redirect: route('admin.crm.sendMail'));
        } catch (\Throwable $e) {
            $this->flash(type: 'error', message: $e->getMessage());
        }
    }
}
