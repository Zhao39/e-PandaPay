@use('\Illuminate\Support\Str', 'Str')
<div>
    <h2 class="m-0">
        Courses
    </h2>
    <p class="m-0">
        Learning often happens in classrooms but it doesn’t have to. Use {{ $settings->site_name }} to facilitate
        learning experiences no matter the context.
    </p>
    <x-danger-alert />
    <x-success-alert />
    <div class="mt-5 row">
        @forelse ($courses as $course)
            <div class="col-lg-4">
                <div class="card">
                    <a href="{{ route('user.membership.course.details', [
                        'course' => str_replace(' ', '-', Str::lower($course->course_title)),
                        'id' => $course->id,
                    ]) }}"
                        @if ($settings->spa_mode) wire:navigate @endif>
                        <img src="{{ str_starts_with($course->course_image, 'http') ? $course->course_image : asset('storage/' . $course->course_image) }}"
                            class="card-img-top" alt="course image">
                    </a>
                    <div class="card-body">
                        <a href="{{ route('user.membership.course.details', [
                            'course' => str_replace(' ', '-', Str::lower($course->course_title)),
                            'id' => $course->id,
                        ]) }}"
                            @if ($settings->spa_mode) wire:navigate @endif>
                            <h5 class="font-weight-bolder">{{ $course->course_title }}</h5>
                        </a>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-book"></i>
                                &nbsp;
                                <span>
                                    {{ $course->lessons_count }}
                                    {{ $course->lessons_count > 1 ? 'Lessons' : 'Lesson' }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-people"></i>
                                &nbsp;
                                <span>
                                    {{ $course->users_count }}
                                </span>
                            </div>
                        </div>
                        <div style="border-top: 1px dashed black;" class="px-2 my-2"></div>
                        <div class="d-flex align-items-center justify-content-between">

                            <h3 class="font-weight-bolder text-danger">
                                {{ !$course->amount ? 'Free' : $settings->currency . number_format(intval($course->amount)) }}
                            </h3>
                            <a href="{{ route('user.membership.course.details', [
                                'course' => str_replace(' ', '-', Str::lower($course->course_title)),
                                'id' => $course->id,
                            ]) }}"
                                class="btn btn-sm btn-primary"
                                @if ($settings->spa_mode) wire:navigate @endif>View</a>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-md-12">
                <div class="card">
                    <div class="py-2 text-center card-body">
                        <x-no-data />
                        <p>No Data Available</p>
                    </div>
                </div>
            </div>
        @endforelse
        @include('components.pagination', ['route' => 'user.membership.courses'])
    </div>
    <div class="mt-3 row">
        <div class="col-12">
            <h3 class="font-weight-bold">Free Lessons</h3>
        </div>
        @isset($lessons)
            @forelse ($lessons as $less)
                <div class="mb-3 col-md-4">
                    <div class="mb-3 card" style="max-width: 540px;">
                        <a href="{{ route('user.membership.learning', ['lesson' => $less->id]) }}"
                            class=" text-decoration-none" @if ($settings->spa_mode) wire:navigate @endif>
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ str_starts_with($less->thumbnail, 'http') ? $less->thumbnail : asset('storage/' . $less->thumbnail) }}"
                                        class="card-img-top" alt="lesson image">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="mb-0 font-weight-bold text-dark"> {{ $less->title }}</h5>
                                        <small class="mt-0">
                                            <span class="fw-bold">
                                                Category:
                                            </span>
                                            {{ $less->category }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="text-center card-body">
                            <x-no-data />
                            <h5 class="font-weight-bold">No Lesson Available</h5>
                        </div>
                    </div>
                </div>
            @endforelse
        @endisset
    </div>
</div>
