@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Edit email template
</x-slot:title>
<div>
    <x-breadcrumbs title="Edit Template">
        <li class="nav-item">
            <a href="{{ route('admin.settings.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Settings
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.settings.emailTemplates') }}"
                @if ($settings->spa_mode) wire:navigate @endif>Email Templates</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#"> {{ Str::ucfirst(str_replace('_', ' ', $template->name)) }}</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <form action="" wire:submit='save'>
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <x-form.input name="subject" wire:model='subject' />
                                </div>

                                <div class="mb-2 form-group" wire:ignore>
                                    <div class="p-2 border">
                                        <p>Available variables</p>
                                        @switch($template->name)
                                            @case('copytrade_success')
                                                <span>
                                                    {$name},
                                                    {$account_type}, {$currency}, {$leverage},
                                                    {$server}, {$duration}, {$status}
                                                </span>
                                            @break

                                            @case('course')
                                                <span>
                                                    {$course}, {$amount}, {$currency},
                                                </span>
                                            @break

                                            @case('kyc_failed')
                                                <span>
                                                    {$name}
                                                    {$first_name}, {$last_name},
                                                    {$email}, {$phone_number}, {$address},
                                                    {$city}, {$state}, {$country}, {$status},
                                                    {reason}
                                                </span>
                                            @break

                                            @case('kyc_approved')
                                                <span>
                                                    {$name}
                                                    {$first_name}, {$last_name},
                                                    {$email}, {$phone_number}, {$address},
                                                    {$city}, {$state}, {$country}, {$status}
                                                </span>
                                            @break

                                            @case('withdraw_success')
                                                <span>
                                                    {$name}
                                                    {$amount}, {$payment_mode},
                                                    {$status}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('transfer')
                                                <span>
                                                    {$sender},
                                                    {$receiver},
                                                    {$currency},
                                                    {$amount}, {$created_at}
                                                </span>
                                            @break

                                            @case('withdraw_processed')
                                                <span>
                                                    {$name}
                                                    {$amount}, {$payment_mode},
                                                    {$status}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('withdraw_failed')
                                                <span>
                                                    {$name}
                                                    {$amount}, {$payment_mode},
                                                    {$status}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('roi_received')
                                                <span>
                                                    {$name}
                                                    {$amount}, {plan_name}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('kyc_received')
                                                <span>
                                                    {$name}
                                                    {$first_name}, {$last_name},
                                                    {$email}, {$phone_number}, {$address},
                                                    {$city}, {$state}, {$country}, {$status}
                                                </span>
                                            @break

                                            @case('plan_started')
                                                <span>
                                                    {$name}
                                                    {$plan_name}, {$amount},
                                                    {$profit_earned}, {$status}, {$created_at},
                                                    {$expire_date}, {$currency},
                                                </span>
                                            @break

                                            @case('plan_ended')
                                                <span>
                                                    {$name}
                                                    {$plan_name}, {$amount},
                                                    {$profit_earned}, {$status}, {$created_at},
                                                    {$expire_date}, {$currency},
                                                </span>
                                            @break

                                            @case('deposit_sucess')
                                                <span>
                                                    {$name}
                                                    {$amount}, {$payment_mode},
                                                    {$status}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('deposit_confirmed')
                                                <span>
                                                    {$name}
                                                    {$amount}, {$payment_mode},
                                                    {$status}, {$created_at}, {$currency},
                                                </span>
                                            @break

                                            @case('signal')
                                                <span>
                                                    {$expiration}, {$duration},
                                                    {$amount}, {$currency},
                                                </span>
                                            @break

                                            @case('welcome_email')
                                                <span>
                                                    {$name}, {$email},
                                                    {$phone_number}, {$username}
                                                </span>
                                            @break

                                            @default
                                                <span>
                                                    {$name}, {$url}
                                                </span>
                                        @endswitch
                                    </div>
                                    <strong class="d-block">
                                        <small>
                                            NOTE: <strong>Use double curly braces in your variables when you
                                                insert them in your template content.</strong>
                                        </small>
                                    </strong>
                                    <label>Content</label>
                                    <textarea name="content" cols="4" class="form-control" required>
                                        {!! $content !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <x-ui.button>
                                    <i class="bi bi-floppy" wire:loading.remove"></i>
                                    <x-spinner wire:loading />
                                    Save
                                </x-ui.button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@script
    <script>
        const editor = CKEDITOR.replace('content', {
            versionCheck: false,
        });
        editor.on('change', function(event) {
            $wire.content = event.editor.getData();
        });
    </script>
@endscript
