@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Courses
</x-slot:title>
<div>
    <x-breadcrumbs title="Courses">
        <li class="nav-item">
            <a href="#">Courses</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        <div class="mb-4 col-12">
            @if ($courses && count($courses) > 0)
                <div class="text-right">
                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#adduser">
                        <i class=" fa fa-plus"></i>
                        Create New
                    </button>
                </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" tabindex="-1" id="adduser" aria-h6ledby="exampleModalh6" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" data-background-color="light">
                        <div class="modal-header ">
                            <h3 class="mb-2 d-inline ">Add New Course</h3>
                            <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <form method="POST" action="{{ route('admin.membership.addCourse') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        @if ($categories)
                                            <div class="form-group col-md-6">
                                                <label>Course Category</label>
                                                <select name="category" class="form-control">
                                                    @foreach ($categories as $cat)
                                                        <option value="{{ $cat['category']['category'] }}">
                                                            {{ $cat['category']['category'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        <div class="form-group col-lg-6">
                                            <label>Course Title</label>
                                            <x-form.input name="title" placeholder='Enter title here' required />
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label>Short Description</label>
                                            <x-form.input name="desc" placeholder='Enter description here'
                                                required />
                                            <small>Not more than 200 letters</small>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Amount {{ $settings->currency }}</label>
                                            <x-form.input name="amount" type='number' step='any'
                                                placeholder='Enter amount here' />
                                            <small>
                                                The amount users can pay to
                                                get this course. If empty the course will
                                                be available for free.
                                            </small>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label>Course Image (File)</label>
                                            <x-form.input name="image" type='file'
                                                placeholder='Enter amount here' />
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label>Course Image (Url)</label>
                                            <x-form.input name="image_url" />
                                        </div>
                                        <h6>
                                            Use either file upload or url to
                                            choose a course image, if both is entered, the file upload will be
                                            used.
                                        </h6>
                                    </div>
                                    <button type="submit" class="px-4 btn btn-primary">Add Course</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- End add user modal --}}
        </div>
        @if ($courses)
            @foreach ($courses as $course)
                <div class="col-lg-4">
                    <div class="card">
                        <img src="{{ str_starts_with($course->course_image, 'http') ? $course->course_image : asset('storage/' . $course->course_image) }}"
                            class="card-img-top" alt="course image">
                        <div class="card-body">
                            <h4 class="mb-0 font-weight-bolder">
                                {{ $course->course_title }}
                            </h4>
                            <small class="mt-0">{{ Str::limit($course->description, 100, '...') }}</small>
                            <div class="mt-1">
                                <h2 class="font-weight-bolder text-primary">
                                    {{ !$course->amount ? 'Free' : $settings->currency . $course->amount }}
                                </h2>
                            </div>
                            <span data-toggle="tooltip" data-placement="top" title="Number of lessons in this course">
                                <i class="bi bi-book"></i> {{ $course->lessons_count }}</span>
                            <span data-toggle="tooltip" data-placement="top"
                                title="Number of users that purchased this course"> <i class="bi bi-people-fill"></i>
                                {{ $course->users_count }}</span>
                        </div>
                        <div class="card-footer">
                            @can('manage lessons')
                                <a href="{{ route('admin.membership.courseLessons', ['id' => $course->id, 'page' => 1]) }}"
                                    class="card-link">View
                                    lessons</a>
                            @endcan
                            <a href="#" class="card-link" data-toggle="modal"
                                data-target="#editcourse{{ $course->id }}">Edit</a>
                            <a href="#" class="card-link text-danger" data-toggle="modal"
                                data-target="#deleteCourse{{ $course->id }}">Delete</a>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="editcourse{{ $course->id }}" aria-h6ledby="exampleModalh6"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header ">
                                <h3 class="mb-2 d-inline ">Update this Course</h3>
                                <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">
                                <div>
                                    <form method="POST" action="{{ route('admin.membership.editCourse') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">
                                            @if ($categories)
                                                <div class="form-group col-md-6">
                                                    <label>Course Category</label>
                                                    <select name="category" class="form-control">
                                                        <option value="{{ $course->category }}">
                                                            {{ $course->category }}</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat['category']['category'] }}">
                                                                {{ $cat['category']['category'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="form-group col-lg-6">
                                                <label>Course Title</label>
                                                <x-form.input name="title" value="{{ $course->course_title }}"
                                                    required />
                                            </div>
                                            <div class="form-group col-lg-12">
                                                <label>Short Description</label>
                                                <x-form.input name="desc" value=' {{ $course->description }}'
                                                    required />
                                                <small>Not more than 200 letters</small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Amount {{ $settings->currency }}</label>
                                                <x-form.input name="amount" type='number' step='any'
                                                    value=' {{ $course->amount }}' />
                                                <small>
                                                    The amount users can pay to
                                                    get this course. If empty the course will
                                                    be available for free.
                                                </small>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Course Image (File)</label>
                                                <x-form.input name="image" type='file'
                                                    placeholder='Enter amount here' />
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Course Image (Url)</label>
                                                <x-form.input name="image_url" value="{{ $course->course_image }}" />
                                            </div>
                                            <h6>
                                                Use either file upload or url to
                                                choose a course image, if both is entered, the file upload will be
                                                used.
                                            </h6>
                                        </div>
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <button type="submit" class="px-4 btn btn-primary">Update Course</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End add user modal --}}

                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="deleteCourse{{ $course->id }}"
                    aria-h6ledby="exampleModalh6" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header ">
                                <h3 class="mb-2 d-inline ">Delete Course</h3>
                                <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">
                                <div>
                                    <p>
                                        Are you sure you want delete this Course
                                        and it's related lessons?
                                    </p>
                                    <form action="{{ route('admin.membership.deleteCourse', $course->id) }}"
                                        method="post">
                                        @csrf
                                        @method('Delete')
                                        <x-ui.button class="btn-danger">Delete</x-ui.button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End add user modal --}}
            @endforeach
            @include('components.pagination', ['route' => 'admin.membership.courses'])
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="text-center card-body">
                        <x-no-data />
                        <h5>No Course Added</h5>
                        <button class="px-3 btn btn-secondary" data-toggle="modal" data-target="#adduser">
                            Add Course
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
