<?php

namespace App\Livewire\User\AccountSettings;

use App\Models\PaymentMethod;
use App\Models\Settings;
use App\Models\User;
use App\Rules\PhoneNumberRule;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class Show extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $avatar;
    public $name;
    public $email;
    public $phone_number;
    public $country;
    public $address;
    public $username;
    public User $user;
    public $current_password;
    public $password;
    public $password_confirmation;
    public $active_tab;
    public $account_name;
    public $account_number;
    public $bank_name;
    public $swift_code;
    public $btc_address;
    public $eth_address;
    public $ltc_address;
    public $usdt_address;

    public function mount(): void
    {
        $this->user = User::find(auth()->user()->id);
        if ($this->user->can('update their profile')) {
            $this->active_tab = 'profile';
        }
        $this->fill($this->user);
    }

    public function render()
    {
        $template = Settings::select(['id', 'theme'])->find(1)->theme;
        return view("{$template}.account-settings.show")
            ->extends("layouts.{$template}")
            ->title('Account Settings');
    }

    #[Computed()]
    public function methods(): Collection
    {
        return PaymentMethod::whereIn('name', [
            'Bank Transfer',
            'Bitcoin',
            'Ethereum',
            'Litecoin',
            'USDT',
            'BUSD',
        ])->get();
    }
    public function saveProfile(): void
    {
        $this->authorize('update their profile');
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone_number' => [
                'required',
                new PhoneNumberRule(),
            ],
        ]);
        $this->user->update($validated);

        $this->alert(message: 'Profile updated successfuly');
        $this->dispatch('refresh-profile');
    }

    public function changePassword(): void
    {
        $this->authorize('change their password');

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $this->user->update(['password' => Hash::make($this->password)]);

        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->alert(type: 'success', message: 'Password reset is Successful.');
    }

    public function updatedAvatar(): void
    {
        $this->authorize('update their profile');
        $this->validate([
            'avatar' => [
                'required',
                File::image()
                    ->min('1kb')
                    ->max('10mb'),
            ],
        ]);
        $path = $this->avatar->store(path: 'avatars');
        $this->user->update(['profile_photo_path' => $path]);
        $this->alert(type: 'success', message: 'Avatar uploaded successfully');
        $this->dispatch('refresh-profile');
    }

    public function saveWithdrawalMethod(): void
    {
        $this->authorize('update their withdrawal payment options');

        $validated = $this->validate([
            'bank_name' => ['nullable', 'string', 'max:150'],
            'account_number' => ['nullable', 'string', 'max:150'],
            'account_name' => ['nullable', 'string', 'max:150'],
            'swift_code' => ['nullable', 'string', 'max:50'],
            'btc_address' => ['nullable', 'string', 'max:150'],
            'eth_address' => ['nullable', 'string', 'max:150'],
            'ltc_address' => ['nullable', 'string', 'max:150'],
            'usdt_address' => ['nullable', 'string', 'max:150'],
        ]);

        $this->user->update($validated);

        $this->alert(type: 'success', message: 'Withdrawal method updated successfully');
    }
}
