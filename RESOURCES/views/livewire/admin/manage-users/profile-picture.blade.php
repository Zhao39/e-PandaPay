<div>
    <div class="card-profile">
        <div class="card-header bg-light">
            <div class="profile-picture">
                <div class="avatar avatar-xl">
                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                        alt="..." class="avatar-img rounded-circle">
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 card-body">
        <div class="text-center user-profile">
            <div class="name">{{ $user->name }}</div>
            <div class="job">{{ $user->email }}</div>
            <div class="file-div btn btn-block btn-primary">
                <x-spinner wire:loading />
                <span wire:loading.remove>Update Avatar</span>
                <input type="file" name="avatar" wire:model.live='avatar' class="file-input" />
            </div>
            <div>
                @error('avatar')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>
</div>
