<div>
    <h1 class="h2">
        {{ $data->course->course_title }}
    </h1>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="p-2 mt-3 mb-5 d-lg-flex justify-content-lg-between align-items-center">
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
                        <h4>Course Lessons</h4>
                        @forelse ($data->lessons as $lesson)
                            <div>
                                <a href="{{ route('user.membership.learning', ['lesson' => $lesson->id, 'course' => $data->course->id]) }}"
                                    @if ($settings->spa_mode) wire:navigate @endif>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <i class="bi bi-play-circle-fill text-danger fs-2"></i>
                                            &nbsp; &nbsp;
                                            <div>
                                                <h6 class="m-0 h6">{{ $lesson->title }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-clock-history"></i>
                                                    {{ $lesson->length }}
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="{{ route('user.membership.learning', ['lesson' => $lesson->id, 'course' => $data->course->id]) }}"
                                                class="btn btn-primary btn-sm"
                                                @if ($settings->spa_mode) wire:navigate @endif>
                                                Watch
                                            </a>
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
