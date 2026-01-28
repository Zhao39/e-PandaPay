<div>
    <div class="d-flex justify-content-between">
        <h1 class="h2">
            Course details
        </h1>
        <div>
            <a href="{{ route('user.membership.courses', ['page' => 1]) }}" class="btn btn-outline-primary btn-sm"
                @if ($settings->spa_mode) wire:navigate @endif>
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />

    <div class="row">
        <div class="col-md-8">
            @if ($purchased)
                <div class="alert alert-success" role="alert">
                    You have already purchased this course.
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div>
                        <h3 class="font-weight-bold">{{ $data->course->course_title }}</h3>
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
                            <p class="m-0 text-primary font-weight-bold">LAST UPDATED</p>
                            <P class="m-0">{{ \Carbon\Carbon::parse($data->course->updated_at)->format('d M, Y') }}
                            </P>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold">About Course</h4>
                        <p>
                            {{ $data->course->description }}
                        </p>
                    </div>
                    <div class="mt-5">
                        <h4 class="fw-bold">Course Lessons</h4>
                        @forelse ($data->lessons as $lesson)
                            <div>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <i class="bi bi-play-circle-fill text-danger fs-2"></i>
                                        &nbsp; &nbsp;
                                        <div>
                                            <h6 class="m-0 h6">{{ $lesson->title }}</h6>
                                            <i class="bi bi-clock-history"></i>
                                            <small class="text-muted">{{ $lesson->length }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($lesson->locked == 'true')
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#preview{{ $lesson->id }}"
                                                class="btn btn-primary btn-sm">Preview</a>
                                            <i class="bi bi-unlock"></i>
                                        @else
                                            <i class="bi bi-lock"></i>
                                        @endif
                                    </div>
                                </div>
                                <div style="border-top: 1px dashed black;" class="my-3"></div>
                            </div>

                            @if ($loop->iteration == 5)
                                <div>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div>
                                                <h6 class="m-0 h6">{{ $loop->remaining }} More
                                                    Lesson{{ $loop->remaining > 1 ? 's' : '' }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @break($loop->iteration == 5)
                            <!-- Modal -->
                            <div class="modal fade" tabindex="-1" id="preview{{ $lesson->id }}"
                                aria-h6ledby="exampleModalh6" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            @if (Str::startsWith($lesson->video_link, 'http'))
                                                <iframe class="embed-responsive-item w-100"
                                                    src="{{ $lesson->video_link }}" allowfullscreen
                                                    height="450"></iframe>
                                            @else
                                                {!! $lesson->video_link !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- End modal --}}
                        @empty
                            <div class="py-3 text-center">
                                <p>No Data Available</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{ str_starts_with($data->course->course_image, 'http') ? $data->course->course_image : asset('storage/' . $data->course->course_image) }}"
                    class="card-img-top" alt="course image">
                <div class="card-body">
                    @if ($purchased)
                        <a href="{{ route('user.membership.mycoursedetails', ['id' => $data->course->id]) }}"
                            class="py-3 rounded-none btn btn-primary btn-lg btn-block rounded-0"
                            @if ($settings->spa_mode) wire:navigate @endif>Watch
                            Lesson</a>
                    @else
                        <h2 class="text-black font-weight-bolder">
                            {{ !$data->course->amount ? 'Free' : $settings->currency . number_format($data->course->amount) }}
                        </h2>
                        <button class="py-3 rounded-none btn btn-danger btn-lg btn-block rounded-0"
                            data-bs-toggle="modal" data-bs-target="#buyModal" wire:loading.attr='disabled'>
                            <x-spinner wire:loading wire:target='buyCourse' />
                            Buy Now
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="buyModal" tabindex="-1" aria-labelledby="buyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="text-center">
                            <p class="mb-3">
                                {{ !$data->course->amount ? $settings->currency . '0' : $settings->currency . number_format($data->course->amount) }}
                                will be
                                deducted from your account balance.
                            </p>
                            <button class="py-3 rounded-none btn btn-danger btn-lg btn-block rounded-0"
                                data-bs-toggle="modal" data-bs-target="#buyModal" wire:click='buyCourse'>Buy
                                Now</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
