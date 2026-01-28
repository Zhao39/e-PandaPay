<?php

namespace App\Livewire\Admin\ManageUsers;

use App\Enums\UserStatus;
use App\Models\User;
use App\Rules\PhoneNumberRule;
use App\Services\Country;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Laravel\Jetstream\Agent;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

#[Layout('layouts.admin')]
class SingleUser extends Component
{
    use LivewireAlert;

    public $name;
    public $username;
    public $email;
    public $phone_number;
    public $country;
    public $address;
    public $date_of_birth;
    public $countries;
    public $refferal_link;
    public $password;
    public $password_confirmation;
    public $twoFfaIsOn;
    public $status;
    public $trade_mode;
    public User $user;
    public $addRef = false;
    public $member;
    public $whatToClear = [];
    public $can_withdraw;
    public $can_deposit;

    public function mount(): void
    {
        $this->fill($this->user);
        $this->date_of_birth = ! is_null($this->user->date_of_birth) ? $this->user->date_of_birth->format('Y-m-d') : null;
        $this->countries = Country::all();
        $this->country = $this->user->country;
        $this->twoFfaIsOn = $this->user->two_factor_confirmed_at ? true : false;
        $this->status = $this->user->status->value;
        $this->trade_mode = $this->user->trade_mode;
        $this->can_deposit = $this->user->can_deposit;
        $this->can_withdraw = $this->user->can_withdraw;
    }

    #[On('refreshp')]
    public function render(): View
    {
        return view('livewire.admin.manage-users.single-user');
    }

    public function saveUser(): void
    {
        Gate::authorize('edit user');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required',  Rule::unique('users')->ignore($this->user->id)],
            'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($this->user->id)],
            'phone_number' => ['nullable', 'max:100', new PhoneNumberRule()],
            'country' => ['required'],
            'address' => ['nullable', 'max:191'],
            'refferal_link' => ['required'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        $this->user->update($validated);

        $this->alert(message: 'User updated successfuly');
    }

    #[Computed()]
    public function sessions(): Collection
    {
        return collect(
            DB::table('sessions')
                ->where('user_id', $this->user->id)
                ->orderBy('last_activity', 'desc')
                ->get()
        )->map(function ($session) {
            return (object) [
                'agent' => $this->createAgent($session),
                'ip_address' => $session->ip_address,
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    // get user refferals
    #[Computed()]
    public function referrals(): LengthAwarePaginator
    {
        return User::query()->isNotAdmin()->where('reffered_by', $this->user->id)->select('id', 'name', 'username', 'created_at')->paginate(10);
    }

    #[Computed()]
    public function referral(): User|null
    {
        return User::query()->isNotAdmin()->where('id', $this->user->reffered_by)->select(['id', 'name', 'username'])->first();
    }

    #[Computed()]
    public function users(): Collection
    {
        return User::query()->isNotAdmin()
            ->where('id', '!=', $this->user->id)
            ->select('id', 'name')
            ->get();
    }

    public function addRefMember(): void
    {
        $this->authorize('edit user');

        $this->validate([
            'member' => ['required', 'exists:users,id'],
        ]);
        User::find($this->member)->update(['reffered_by' => $this->user->id]);
        $this->alert(type: 'success', message: 'Action Successful.');
        $this->reset(['member', 'addRef']);
    }

    public function removeRef(string $id): void
    {
        $this->authorize('edit user');

        $user = User::find($id);
        if ($user) {
            $user->update(['reffered_by' => null]);
        }
        $this->alert(type: 'success', message: 'Member removed Successfully.');
    }

    public function resetPassword(): void
    {
        // authroize action
        Gate::authorize('edit user');

        $this->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $this->user->update(['password' => Hash::make($this->password)]);
        $this->alert(type: 'success', message: 'Password reset is Successful.');
        $this->reset(['password', 'password_confirmation']);
    }

    public function turnOff2fa(): void
    {
        // authroize action
        Gate::authorize('edit user');
        $this->user->update([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ]);
        $this->twoFfaIsOn = false;
        $this->alert(type: 'success', message: '2FA turned Off Successfully.');
    }

    public function updatedStatus(): void
    {
        // authroize action
        Gate::authorize('edit user');
        $this->user->update(['status' => $this->status === 'active' ? UserStatus::Active : UserStatus::Blocked]);
        $this->alert(type: 'success', message: "{$this->user->name} account set to {$this->status}");
    }

    public function updatedTrademode(): void
    {
        // authroize action
        Gate::authorize('edit user');
        $status = $this->trade_mode ? 'On' : 'Off';
        $this->user->update(['trade_mode' => $this->trade_mode]);
        $this->alert(type: 'success', message: "Autotrade Mode is {$status}");
    }

    public function updatedCanwithdraw(): void
    {
        // authroize action
        Gate::authorize('edit user');
        $this->user->update(['can_withdraw' => boolval($this->can_withdraw)]);
        $this->alert(type: 'success', message: 'Action successful');
    }

    public function updatedCandeposit(): void
    {
        // authroize action
        Gate::authorize('edit user');
        $this->user->update(['can_deposit' => boolval($this->can_deposit)]);
        $this->alert(type: 'success', message: 'Action successful');
    }

    public function markAsVerified(): void
    {
        Gate::authorize('edit user');
        $this->user->update(['email_verified_at' => now()]);
        $this->alert(type: 'success', message: 'Email address mark as verified.');
    }

    public function clearAccount(): void
    {
        Gate::authorize('edit user');
        $userService = new UserService($this->user);

        foreach ($this->whatToClear as $action) {
            $userService->clearAccount($action);
        }
        $this->reset('whatToClear');
        $this->alert(type: 'success', message: 'Account cleared successfully');
    }

    public function deleteAccount(): void
    {
        $this->authorize('delete user');
        $name = $this->user->name;
        (new UserService($this->user))->deleteAccount();
        $this->flash(message: "{$name} account have been deleted successfully.", redirect: route('admin.users.listUsers'));
    }

    public function loginAsUser()
    {
        $this->authorize('edit user');
        $id = $this->user->id;
        $this->user->assignRole('User');
        request()->session()->invalidate();
        Auth::loginUsingId($id);
        $this->redirect('/user/dashboard');
    }

    protected function createAgent($session)
    {
        return tap(new Agent(), fn($agent) => $agent->setUserAgent($session->user_agent));
    }
}