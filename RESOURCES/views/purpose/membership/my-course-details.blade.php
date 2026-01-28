<div>
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">
                    My Courses Details
                </h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h2 class="font-weight-bold">{{ $data->course->course_title }}</h2>
                    </div>
                    <div class="p-2 mt-3 d-lg-flex justify-content-lg-between align-items-center">
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">CREATED BY</p>
                            <P class="m-0">{{ $settings->site_name }}</P>
                        </div>
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">CATEGORY</p>
                            <P class="m-0">{{ $data->course->category }}</P>
                        </div>
                        <div class="mt-2 mt-lg-0">
                            <p class="m-0 text-primary font-weight-bold">PURCHASED</p>
                            <P class="m-0">
                                {{ \Carbon\Carbon::parse($data->course->created_at)->toDayDateTimeString() }}</P>
                        </div>
                    </div>

                    <div class="mt-5">
                        <h4 class="font-weight-bold">Course Lessons</h4>
                        @forelse ($data->lessons as $lesson)
                            <div>
                                <a class="text-decoration-none"
                                    href="{{ route('user.membership.learning', ['lesson' => $lesson->id, 'course' => $data->course->id]) }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <i class="mr-2 fas fa-play-circle fa-2x text-danger"></i>
                                            <div>
                                                <h6 class="m-0 h6">{{ $lesson->title }}</h6>
                                                <small class="text-muted">Length: {{ $lesson->length }}</small>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('user.membership.learning', ['lesson' => $lesson->id, 'course' => $data->course->id]) }}"
                                                class="px-3 text-white rounded-md shadow bg-info rounded-4 text-decoration-none"
                                                @if ($settings->spa_mode) wire:navigate @endif>Watch</a>
                                        </div>
                                    </div>
                                </a>
                                <div style="border-top: 1px dashed black;" class="my-3"></div>
                            </div>
                        @empty
                            <div class="py-3 text-center">
                                <p>No Data Available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
