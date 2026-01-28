<?php

namespace App\Livewire\Admin\ManageUsers;

use App\Models\User;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfilePicture extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public User $user;
    public $avatar;

    public function render()
    {
        return view('livewire.admin.manage-users.profile-picture');
    }

    public function updatedAvatar(): void
    {
        $this->authorize('edit user');
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
    }
}
