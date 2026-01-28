@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Email Templates
</x-slot:title>
<div>
    <x-breadcrumbs title="Email Templates">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Email Templates</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="mb-1 text-right">
                @if ($edit_email_verification_mail)
                    <x-ui.button type="button" class="btn-sm" wire:click="pref('0')">
                        <x-spinner wire:loading wire:target="pref" />
                        Use system email verification mail
                    </x-ui.button>
                @else
                    <x-ui.button type="button" class="btn-sm" wire:click="pref('1')">
                        <x-spinner wire:loading wire:target="pref" />
                        Edit email verification mail.
                    </x-ui.button>
                @endif
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $template)
                                    <tr>
                                        <td>
                                            {{ Str::ucfirst(str_replace('_', ' ', $template->name)) }}
                                        </td>
                                        <td>
                                            @if ($template->name == 'deposit_sucess')
                                                Email sent when your user's deposit is succesfully submitted.
                                            @elseif($template->name == 'withdraw_processed')
                                                Email sent when you process users withdrawal successsfully.
                                            @elseif($template->name == 'withdraw_success')
                                                Email sent when your users place a pending withdrawal request.
                                            @elseif($template->name == 'transfer')
                                                Email sent to receiver when a user transfer their funds to them.
                                            @elseif($template->name == 'withdraw_failed')
                                                Email sent when you cancel a user withdrawal
                                            @elseif($template->name == 'kyc_approved')
                                                Email sent when you approve a KYC
                                            @elseif($template->name == 'kyc_failed')
                                                Email sent when you disapprove a KYC
                                            @elseif($template->name == 'roi_received')
                                                Email sent when users receive Profit from their investments
                                            @elseif($template->name == 'plan_started')
                                                Email sent when users buy an invesment plan
                                            @elseif($template->name == 'plan_ended')
                                                Email sent when user's plan expires
                                            @elseif($template->name == 'kyc_received')
                                                Email sent's when users submit their KYC Application
                                            @elseif($template->name == 'copytrade_success')
                                                Email sent's to users when you process their submitted trading account
                                            @elseif($template->name == 'course')
                                                Email sent's when users buy a membership course
                                            @elseif($template->name == 'signal')
                                                Email sent's when users subscribe to your trade signals
                                            @elseif ($template->name == 'deposit_confirmed')
                                                Email sent when you process/confirm user's deposit
                                            @elseif ($template->name == 'welcome_email')
                                                Email sent when a new user regsiters and has confirmed his/her email
                                                address
                                            @else
                                                Email sent for users to verify their email address.
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.settings.editTemplate', ['template' => $template]) }}"
                                                class="m-1 btn btn-warning btn-sm"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 
--}}
