@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5 page-title">
        <div class="row">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h5 class="text-white h3 font-weight-400">{{ $lesson['title'] }}</h5>
                @if ($data)
                    <a href="{{ route('user.membership.mycoursedetails', ['id' => $data->course->id]) }}"
                        @if ($settings->spa_mode) wire:navigate @endif class="btn btn-outline-light btn-sm">
                        <i class="fa fa-arrow-left"></i>
                        Back
                    </a>
                @endif
            </div>
        </div>
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
                                <iframe class="embed-responsive-item" src="{{ $lesson['video_link'] }}"
                                    allowfullscreen></iframe>
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
