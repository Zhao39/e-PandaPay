@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="{{ $lesson['title'] }}" :homeUrl="route('user.dashboard')">
        @if ($data)
            <li class="nav-item">
                <a href="{{ route('user.membership.mycourses') }}"
                    @if ($settings->spa_mode) wire:navigate @endif>My
                    Courses</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('user.membership.mycoursedetails', ['id' => $data->course->id]) }}"
                    @if ($settings->spa_mode) wire:navigate @endif>My
                    {{ $data->course->course_title }}
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
        @else
            <li class="nav-item">
                <a href="{{ route('user.membership.courses', ['page' => 1]) }}"
                    @if ($settings->spa_mode) wire:navigate @endif>Courses</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
        @endif
        <li class="nav-item">
            <a href="#">Lesson</a>
        </li>
    </x-breadcrumbs>
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
