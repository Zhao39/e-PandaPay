@use('\Illuminate\Support\Str', 'Str')
<div>
    <!-- Title -->
    <div class="mb-5 d-flex justify-content-between">
        <div>
            <h1 class="m-0 h2">
                {{ $lesson['title'] }}
            </h1>
        </div>
        @if ($data)
            <div>
                <a href="{{ route('user.membership.mycourses') }}" @if ($settings->spa_mode) wire:navigate @endif
                    class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        @else
            <div>
                <a href="{{ route('user.membership.courses', ['page' => 1]) }}"
                    @if ($settings->spa_mode) wire:navigate @endif class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-arrow-left"></i>
                    Back
                </a>
            </div>
        @endif
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="" x-data="{ hide: true }">
                        <div class="mb-2 d-flex justify-content-between border-bottom">
                            <div>
                                <h4 class="font-weight-bold">Description</h4>
                            </div>
                            <div class="mb-2 text-right">
                                <a href="" @click.prevent="hide = !hide" class="text-decoration-none">
                                    <i class="bi text-dark" x-bind:class="hide ? 'bi-eye-slash' : 'bi-eye-fill'"></i>
                                </a>
                            </div>
                        </div>
                        <div x-show="hide" x-transition>
                            {!! $lesson['description'] !!}
                        </div>
                        <div class="embed-responsive embed-responsive-16by9">
                            @if (Str::startsWith($lesson['video_link'], 'http'))
                                <iframe class="embed-responsive-item w-100" src="{{ $lesson['video_link'] }}"
                                    allowfullscreen height="500"></iframe>
                            @else
                                {!! $lesson['video_link'] !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
