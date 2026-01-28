<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\MembershipException;
use App\Http\Controllers\Controller;
use App\Services\MembershipService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;

class MembershipController extends Controller
{
    private MembershipService $mem;

    public function __construct()
    {
        $this->mem = new MembershipService();
    }

    public function addCourse(Request $request): RedirectResponse
    {
        if (empty($request->image_url) and ! $request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        $path = $request->image_url;

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('10mb'),
                ],
                'title' => ['required'],
                'desc' => ['required'],
            ]);

            $file = $request->file('image');
            $path = $file->store('courses');
        }

        try {
            $message = $this->mem->addCourse([
                'title' => $request->title,
                'amount' => $request->amount,
                'image_url' => $path,
                'paidCourses' => $request->amount === '' ? false : true,
                'category' => $request->category,
                'desc' => $request->desc,
            ]);

            return to_route('admin.membership.courses', ['page' => 1])->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }

    public function editCourse(Request $request, MembershipService $mem): RedirectResponse
    {
        if (empty($request->image_url) and ! $request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        $path = $request->image_url;

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('10mb'),
                ],
                'title' => ['required'],
                'desc' => ['required'],
            ]);

            $file = $request->file('image');
            $path = $file->store('courses');
        }

        try {
            $message = $this->mem->updateCourse([
                'course_id' => $request->course_id,
                'title' => $request->title,
                'amount' => $request->amount,
                'image_url' => $path,
                'paidCourses' => $request->amount === '' ? false : true,
                'category' => $request->category,
                'desc' => $request->desc,
            ]);

            return to_route('admin.membership.courses', ['page' => 1])->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }

    public function deleteCourse(string $coursId): RedirectResponse
    {
        try {
            $message = $this->mem->deleteCourse($coursId);
            return to_route('admin.membership.courses', ['page' => 1])->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }

    public function addLesson(Request $request): RedirectResponse
    {
        if ($request->image_url === '' and ! $request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        $path = $request->image_url;
        $cat = null;

        $this->validate($request, [
            'title' => ['required'],
            'desc' => ['required'],
        ]);

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('10mb'),
                ],
            ]);
            $file = $request->file('image');
            $path = $file->store('lessons');
        }

        if ($request->has('category')) {
            $cat = $request->category;
        }

        try {
            $message = $this->mem->addLesson([
                'title' => $request->title,
                'length' => $request->length,
                'videolink' => $request->videolink,
                'preview' => $request->preview,
                'course_id' => $request->course_id,
                'desc' => $request->desc,
                'cat' => $cat,
                'thumbnail' => $path,
            ]);
            if ($request->has('course_id')) {
                return to_route('admin.membership.courseLessons', ['id' => $request->course_id, 'page' => 1])->with('success', $message);
            }
            return back()->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }

    public function updateLesson(Request $request): RedirectResponse
    {
        if ($request->image_url === '' and ! $request->hasfile('image')) {
            return redirect()->back()->with('message', 'Please choose a course image');
        }

        $path = $request->image_url;
        $cat = null;
        $category = null;

        $this->validate($request, [
            'title' => ['required'],
            'descc' => ['required'],
        ]);

        if ($request->hasfile('image')) {
            $this->validate($request, [
                'image' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('10mb'),
                ],
            ]);
            $file = $request->file('image');
            $path = $file->store('lessons');
        }

        if ($request->has('category')) {
            $cat = $request->category;
            $category = $request->category;
        }

        try {
            $message = $this->mem->updateLesson([
                'lesson_id' => $request->lesson_id,
                'title' => $request->title,
                'length' => $request->length,
                'videolink' => $request->videolink,
                'preview' => $request->preview,
                'course_id' => $request->course_id,
                'desc' => $request->descc,
                'cat' => $cat,
                'course_category_id' => $category,
                'thumbnail' => $path,
            ]);
            if ($request->has('course_id')) {
                return to_route('admin.membership.courseLessons', ['id' => $request->course_id, 'page' => 1])->with('success', $message);
            }
            return back()->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }

    public function deleteLesson(string $lesson_id, string $course_id = ''): RedirectResponse
    {
        try {
            $message = $this->mem->deleteLesson($lesson_id, $course_id);
            if ($course_id !== '') {
                return to_route('admin.membership.courseLessons', ['id' => $course_id, 'page' => 1])->with('success', $message);
            }
            return back()->with('success', $message);
        } catch (MembershipException $ex) {
            return back()->with('message', $ex->getMessage());
        }
    }
}
