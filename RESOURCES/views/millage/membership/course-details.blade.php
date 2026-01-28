<div>
    <x-breadcrumbs title="Courses Details" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="{{ route('user.membership.courses', ['page' => 1]) }}"
                @if ($settings->spa_mode) wire:navigate @endif>Courses</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Courses Details</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />

    <div class="row">
        <div class="col-md-8">
            @if ($purchased)
                <div class="alert alert-primary" role="alert">
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
                            <P class="m-0">
                                {{ \Carbon\Carbon::parse($data->course->updated_at)->format('d M, Y') }}
                            </P>
                        </div>
                    </div>
                    <div class="mt-5">
                        <h4 class="font-weight-bold">About Course</h4>
                        <p class="mt-2">
                            {{ $data->course->description }}
                        </p>
                    </div>
                    <div class="mt-5">
                        <h4 class="font-weight-bold">Course Lessons</h4>
                        @forelse ($data->lessons as $lesson)
                            <div>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <i class="mr-2 fas fa-play-circle fa-2x text-danger"></i>
                                        <div>
                                            <h6 class="m-0 h6">{{ $lesson->title }}</h6>
                                            <small class="text-muted">{{ $lesson->length }}</small>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($lesson->locked == 'true')
                                            <a href="#" data-toggle="modal"
                                                data-target="#preview{{ $lesson->id }}"
                                                class="px-3 text-white rounded-md shadow bg-info rounded-4">Preview</a>
                                            <i class="fas fa-unlock"></i>
                                        @else
                                            <i class="fas fa-lock"></i>
                                        @endif
                                    </div>
                                </div>
                                <div style="border-top: 1px dashed black;" class="my-3"></div>
                            </div>

                            @if ($loop->iteration == 5)
                                <div>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center justify-content-start">
                                            {{-- <i class="mr-2 fas fa-play-circle fa-2x text-danger"></i> --}}
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
                                    <div class="modal-content" data-background-color="light">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            @if (Str::startsWith($lesson->video_link, 'http'))
                                                <iframe class="embed-responsive-item" src="{{ $lesson->video_link }}"
                                                    allowfullscreen></iframe>
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
                        <button class="py-3 rounded-none btn btn-danger btn-lg btn-block rounded-0" data-toggle="modal"
                            data-target="#buyModal" wire:loading.attr='disabled'>
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
                <div class="modal-content" data-background-color="light">
                    <div class="modal-body">
                        <div class="text-center">
                            <p class="mb-3">
                                {{ !$data->course->amount ? $settings->currency . '0' : $settings->currency . number_format($data->course->amount) }}
                                will be
                                deducted from your account balance.
                            </p>
                            <button type="button" data-dismiss="modal" class="btn btn-primary btn-block"
                                wire:click='buyCourse'>Purchase
                                now</button>
                            {{-- <form action="{{ route('user.buycourse') }}" method="post">
                                @csrf
                                <input type="hidden" name="amount" value="{{ $data->course->amount }}">
                                <input type="hidden" name="course" value="{{ $data->course->id }}">
                                <button type="submit" class="btn btn-primary btn-block">Purchase now</button>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
