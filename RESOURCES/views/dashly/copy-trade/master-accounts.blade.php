@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5">
        <h1 class="h2">
            Providers
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row row-cols-1 row-cols-lg-3">
        @forelse ($providers as $provider)
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span @class([
                                    'badge',
                                    'badge-success' =>
                                        Str::upper($provider['deployment_status']) === 'DEPLOYED',
                                    'badge-danger' =>
                                        Str::upper($provider['deployment_status']) === 'UNDEPLOYED',
                                ])>{{ $provider['deployment_status'] }}</span>
                                <x-spinner wire:loading />
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-person"> </i>
                                    Name:
                                </span>
                                <span class=" font-weight-bold">{{ $provider['account_name'] }}</span>
                            </div>
                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-box-arrow-in-left"> </i>
                                    Login:
                                </span>
                                <span class=" font-weight-bold">{{ $provider['login'] }}</span>
                            </div>

                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-layers"> </i>
                                    Platform:
                                </span>
                                <span class=" font-weight-bold">{{ Str::upper($provider['platform'] ?? '') }}</span>
                            </div>
                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-hdd-stack"> </i>
                                    Server:
                                </span>
                                <span class=" font-weight-bold">{{ $provider['server'] }}</span>
                            </div>
                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-coin"> </i>
                                    Currency:
                                </span>
                                <span class=" font-weight-bold">{{ $provider['currency'] }}</span>
                            </div>
                            <div class="p-2 mb-2 bg-light d-flex justify-content-between">
                                <span>
                                    <i class="bi bi-water"> </i>
                                    Leverage:
                                </span>
                                <span class=" font-weight-bold">{{ $provider['leverage'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('user.copier.master.details', ['login' => $provider['login']]) }}"
                            class="btn btn-primary btn-sm" @if ($settings->spa_mode) wire:navigate @endif>
                            View provider information
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col">
                <div class="card">
                    <div class="py-3 text-center card-body">
                        <x-no-data />
                        <h5 class="font-weight-bold">{{ __('No providers found.') }}</h5>
                        <a href="{{ route('user.copier.show') }}" class="btn btn-primary btn-sm"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <i class="bi bi-arrow-left"></i>
                            Go back
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
