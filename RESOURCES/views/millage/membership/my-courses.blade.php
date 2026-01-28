<div>
    <x-breadcrumbs title="My Courses" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">My Courses</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        @forelse ($data as $info)
            <div class="col-md-4">
                <div class="card rounded-0">
                    <img src="{{ str_starts_with($info['course']['course_image'], 'http') ? $info['course']['course_image'] : asset('storage/' . $info['course']['course_image']) }}"
                        class="card-img-top" alt="course image">
                    <div class="card-body">
                        <h5 class="font-weight-bolder">{{ $info['course']['course_title'] }}</h5>
                        <div class="my-2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="mr-1 fa fa-book"></i>
                                <span>
                                    {{ count($info['course']['lessons']) }}
                                    {{ count($info['course']['lessons']) > 1 ? 'Lessons' : 'Lesson' }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('user.membership.mycoursedetails', ['id' => $info['course_id']]) }}"
                                class="btn btn-primary btn-block rounded-0 d-flex align-items-center justify-content-center"
                                @if ($settings->spa_mode) wire:navigate @endif>
                                <i class="mr-2 fas fa-play-circle fa-2x text-danger"></i>
                                <span>Watch</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-12">
                <div class="card">
                    <div class="pb-5 text-center card-body">
                        <x-no-data />
                        <h5>No Course Available</h5>
                        <a href="{{ route('user.membership.courses', ['page' => 1]) }}" class="btn btn-primary"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            Browse Courses
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
