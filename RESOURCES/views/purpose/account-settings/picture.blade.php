<style>
    .card-profile .profile-picture {
        text-align: center;
        position: absolute;
        margin: 0 auto;
        left: 0;
        right: 0;
        bottom: -41px;
        width: 100%;
        box-sizing: border-box;
    }

    .card-profile .user-profile .name {
        font-size: 20px;
        font-weight: 400;
        margin-bottom: 3px;
    }

    .card-profile .user-profile .job {
        color: #83848a;
        margin-bottom: 5px;
    }

    .card-profile .user-profile .desc {
        color: #bbb;
        margin-bottom: 15px;
    }

    .card-profile .user-profile .social-media {
        margin-bottom: 20px;
    }

    .card-profile .user-profile .social-media .btn {
        padding: 3px !important;
    }

    .card-profile .user-profile .social-media .btn i {
        font-size: 22px !important;
    }

    .card-profile .user-stats {
        margin-bottom: 10px;
    }

    .card-profile .user-stats [class^="col"] {
        border-right: 1px solid #ebebeb;
    }

    .card-profile .user-stats [class^="col"]:last-child {
        border-right: 0;
    }

    .card-profile .user-stats .number {
        font-weight: 400;
        font-size: 15px;
    }

    .card-profile .user-stats .title {
        color: #7d7b7b;
    }

    .card-profile .card-header {
        border-bottom: 0;
        height: 100px;
        position: relative;
    }

    .card-profile .card-body {
        padding-top: 60px;
    }

    .card-profile .card-footer {
        border-top: 0;
    }

    .card-profile.card-secondary .card-header {
        background: #6861ce;
    }

    /* Profile sidebar */
    .file-div {
        position: relative;
        overflow: hidden;
    }

    .file-input {
        position: absolute;
        font-size: 50px;
        opacity: 0;
        right: 0;
        top: 0;
    }

    .profile-userpic img {
        float: none;
        display: block;
        margin: auto;
        width: 50%;
        height: 50%;
        -webkit-border-radius: 50% !important;
        -moz-border-radius: 50% !important;
        border-radius: 50% !important;
    }

    .profile-usertitle {
        text-align: center;
        margin-top: 20px;
    }

    .profile-usertitle-name {
        color: #5a7391;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 7px;
    }

    .profile-usertitle-job {
        text-transform: uppercase;
        color: #5b9bd1;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .profile-userbuttons {
        text-align: center;
        margin-top: 10px;
    }

    .profile-userbuttons .btn {
        text-transform: uppercase;
        font-size: 11px;
        font-weight: 600;
        padding: 6px 15px;
        margin-right: 5px;
    }
</style>
<div class="card-header bg-light">
    <div class="profile-picture">
        <div class="avatar avatar-xl">
            <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('dash/images/avatar.svg') }}"
                alt="..." class="avatar-img rounded-circle">
        </div>
    </div>
</div>
<div class="mt-1 card-body">
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
