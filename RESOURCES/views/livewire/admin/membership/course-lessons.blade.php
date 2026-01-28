@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Course Lessons
</x-slot:title>
<div>
    <x-breadcrumbs title="Course Lessons">
        <li class="nav-item">
            <a href="{{ route('admin.membership.courses', ['page' => '1']) }}"
                @if ($settings->spa_mode) wire:navigate @endif>
                {{ Str::limit($course['course_title'], 50, '...') }}
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Course Lessons</a>
        </li>
    </x-breadcrumbs>
    <x-admin.alert />
    <div class="row">
        @if ($lessons && count($lessons) > 0)
            <div class="mb-4 col-12">
                <div class="text-right">
                    <button class="px-3 border shadow-sm btn btn-light" type="button" data-toggle="modal"
                        data-target="#lessonModal">
                        <i class=" fa fa-plus"></i>
                        New Lesson
                    </button>
                </div>
            </div>
        @endif
        @isset($lessons)
            @forelse ($lessons as $less)
                <div class="mb-3 col-md-4">
                    <div class="card" style="max-width: 540px;">
                        <div class="row no-gutters">
                            <div class="pt-2 pl-2 col-md-4">
                                <img src="{{ str_starts_with($less->thumbnail, 'http') ? $less->thumbnail : asset('storage/' . $less->thumbnail) }}"
                                    class="card-img-top" alt="lesson image">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="font-weight-bold"> {{ $less->title }}</h5>
                                    <div class="">
                                        <a href="#" class="card-link" data-toggle="modal"
                                            data-target="#lessonModal{{ $less->id }}">Edit</a>
                                        <a href="#" class="card-link text-danger" data-toggle="modal"
                                            data-target="#lessonDeleteModal{{ $less->id }}">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="lessonModal{{ $less->id }}" aria-h6ledby="exampleModalh6"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header ">
                                <h3 class="mb-2 d-inline ">Update Lesson</h3>
                                <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body ">
                                <div>
                                    <form method="POST" action="{{ route('admin.membership.updatelesson') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PATCH')
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label>Lesson Title</label>
                                                <x-form.input name="title" value="{{ $less->title }}" required />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Length of video</label>
                                                <x-form.input name="length" value="{{ $less->length }}" required />
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label>Video Link</label>
                                                <x-form.input name="videolink" value="{{ $less->video_link }}" required />
                                                <small>Only Iframe (embedded) Link is allowed</small>
                                            </div>

                                            <div class="form-group col-md-12" wire:ignore>
                                                <label>Description</label>
                                                <textarea name="descc" cols="4" class="form-control" required> {!! $less->description !!}</textarea>
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Allow Preview</label>
                                                <select name="preview" class="border form-control border-primary">
                                                    <option value="{{ $less->locked }}">
                                                        {{ $less->locked }}</option>
                                                    <option value="true">true</option>
                                                    <option value="false">false</option>
                                                </select>
                                                <small>
                                                    If you want users to be
                                                    able to view this lesson before
                                                    purchase
                                                </small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Lesson Thumbnail (File)</label>
                                                <x-form.input name="image" type='file' />
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Lesson Thumbnail (Url)</label>
                                                <x-form.input value="{{ $less->thumbnail }}" name="image_url" />
                                            </div>

                                            <h6>
                                                Use either file upload or url to
                                                choose a lesson image, if both is entered, the file upload will be
                                                used.
                                            </h6>
                                            <input type="hidden" value="{{ $less->id }}" name="lesson_id">
                                            <input type="hidden" value="{{ $course['id'] }}" name="course_id">
                                        </div>
                                        <button type="submit" class="px-4 btn btn-primary">Update Lesson</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End add user modal --}}
                <!-- Modal -->
                <div class="modal fade" tabindex="-1" id="lessonDeleteModal{{ $less->id }}"
                    aria-h6ledby="exampleModalh6" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" data-background-color="light">
                            <div class="modal-header">
                                <h3 class="mb-2 d-inline">Delete Lesson</h3>
                                <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div>
                                    <p>
                                        Are you sure you want delete this lesson?
                                    </p>
                                    <form
                                        action="{{ route('admin.membership.deletelesson', ['id' => $less->id, 'course_id' => $course['id']]) }}"
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
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="text-center card-body">
                            <x-no-data />
                            <h5 class="font-weight-bold">No Data Available</h5>
                            <button class="border btn btn-light" type="button" data-toggle="modal"
                                data-target="#lessonModal">
                                <i class=" fa fa-plus"></i>
                                Add Lesson
                            </button>
                        </div>
                    </div>
                </div>
            @endforelse
            @include('components.pagination', ['route' => 'admin.membership.courseLessons'])
        @endisset
    </div>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" id="lessonModal" aria-h6ledby="exampleModalh6" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" data-background-color="light">
                <div class="modal-header ">
                    <h3 class="mb-2 d-inline ">Add Lesson</h3>
                    <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div>
                        <form method="POST" action="{{ route('admin.membership.addlesson') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Lesson Title</label>
                                    <x-form.input name="title" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Length of video</label>
                                    <x-form.input name="length" required />
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Video Link</label>
                                    <x-form.input name="videolink" required />
                                    <small>Only Iframe (embedded) Link is allowed</small>
                                </div>

                                <div class="form-group col-md-12" wire:ignore>
                                    <label>Description</label>
                                    <textarea name="desc" cols="4" class="form-control" required></textarea>
                                </div>

                                <div class="form-group col-md-6">
                                    <x-preference label="Allow Preview">
                                        <x-slot:check1>
                                            <x-radio name='preview' value="true" label="Allow" checked />
                                        </x-slot:check1>
                                        <x-slot:check2>
                                            <x-radio name='preview' value="false" label="Don't Allow" />
                                        </x-slot:check2>
                                    </x-preference>
                                    <small>
                                        If you want users to be
                                        able to view this lesson before
                                        purchase
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Lesson Thumbnail (File)</label>
                                    <x-form.input name="image" type='file' />
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Lesson Thumbnail (Url)</label>
                                    <x-form.input name="image_url" />
                                </div>
                                <h6>
                                    Use either file upload or url to
                                    choose a lesson image, if both is entered, the file upload will be used.
                                </h6>
                                <input type="hidden" value="{{ $course['id'] }}" name="course_id">
                            </div>
                            <button type="submit" class="px-4 btn btn-primary">Add Lesson</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End add user modal --}}
</div>
<x-slot:scripts>
    <script>
        const editor = CKEDITOR.replace('desc', {
            versionCheck: false,
        });
        const editor2 = CKEDITOR.replace('descc', {
            versionCheck: false,
        });
    </script>
</x-slot:scripts>
