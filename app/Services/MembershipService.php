<?php

namespace App\Services;

use App\Exceptions\MembershipException;
use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\AddCategoryRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\AddCourseRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\AddLessonRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\BuyCourseRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\DeleteCategoryRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\DeleteCourseRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\DeleteLessonRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\GetCourseLessonsRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\LessonsRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\LessonsWithNoCourse;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\MembershipCategoryRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\MembershipCourses;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\SingleCourse;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\UpdateCourseRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\UpdateLessonRequest;
use App\Http\Integrations\GetEPandaPay\Requests\Membership\UserCourses;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MembershipService
{
    private GetEPandaPay $ePandaPay;

    public function __construct()
    {
        $this->ePandaPay = new GetEPandaPay();
    }

    public function categories(): Collection| array
    {
        if (Cache::has('categories')) {
            return collect(Cache::get('categories'));
        }

        $request = new MembershipCategoryRequest();

        $res = $this->ePandaPay->send($request);
        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $categories = $response['data']['categories'];

        Cache::put('categories', $categories, now()->addHour());

        return collect($categories);
    }
    // courses
    public function courses(string $page): Collection| array
    {
        if (Cache::has('courses')) {
            return collect(Cache::get("courses-data-{$page}"));
        }

        $request = new MembershipCourses($page);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $data = $response['data']['coursesv6'];

        Cache::put("courses-data-{$page}", $data, now()->addHour());

        return collect($data);
    }

    // lessons for course with id
    public function courseLessons(string $coursId, string $page): Collection| array
    {
        if (Cache::has("lessons_{$coursId}_page_{$page}")) {
            return collect(Cache::get("lessons_{$coursId}_page_{$page}"));
        }
        $request = new GetCourseLessonsRequest($coursId, $page);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $lessons = $response['data'];

        Cache::put("lessons_{$coursId}_page_{$page}", $lessons, now()->addHour());

        return collect($lessons);
    }

    // lessons without a course
    public function lessonWithoutCourse(): Collection| array
    {
        if (Cache::has('lessonsNoCourse')) {
            return collect(Cache::get('lessonsNoCourse'));
        }
        $request = new LessonsWithNoCourse();

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $lessons = $response['data']['lessons'];

        Cache::put('lessonsNoCourse', $lessons, now()->addHour());

        return collect($lessons);
    }

    public function course(string $courseId): Collection| array
    {
        if (Cache::has('course' . $courseId)) {
            return collect(Cache::get('course' . $courseId));
        }
        $request = new SingleCourse($courseId);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $course = $response['data'];

        Cache::put('course' . $courseId, $course, now()->addHour());

        return collect($course);
    }

    public function myCourses(string $user_id): Collection| array
    {
        if (Cache::has('purchased' . $user_id)) {
            return collect(Cache::get('purchased' . $user_id));
        }

        $request = new UserCourses($user_id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $courses = $response['data']['courses'];

        Cache::put('purchased' . $user_id, $courses, now()->addHour());

        return collect($courses);
    }

    public function saveCategory(string $category_name): string
    {
        $request = new AddCategoryRequest($category_name);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        Cache::forget('categories');

        return $response['message'];
    }

    public function deleteCategory(string $id): string
    {
        $request = new DeleteCategoryRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        Cache::forget('categories');

        return $response['message'];
    }

    public function addCourse(array $coureData): string
    {
        $request = new AddCourseRequest($coureData);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("courses-data-{$page}");
        }

        return $response['message'];
    }

    public function updateCourse(array $coureData): string
    {
        $request = new UpdateCourseRequest($coureData);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("courses-data-{$page}");
        }

        return $response['message'];
    }

    public function deleteCourse(string $id): string
    {
        $request = new DeleteCourseRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        foreach (range(1, 20) as $page) {
            Cache::forget("courses-data-{$page}");
        }

        return $response['message'];
    }

    public function addLesson(array $lessonData): string
    {
        $request = new AddLessonRequest($lessonData);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        if (array_key_exists('course_id', $lessonData) && ! is_null($lessonData['course_id'])) {
            foreach (range(1, 20) as $page) {
                Cache::forget("lessons_{$lessonData['course_id']}_page_{$page}");
            }
        } else {
            Cache::forget('lessonsNoCourse');
        }
        return $response['message'];
    }

    public function updateLesson(array $lessonData): string
    {
        $request = new UpdateLessonRequest($lessonData);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        if (array_key_exists('course_id', $lessonData) && ! is_null($lessonData['course_id'])) {
            foreach (range(1, 20) as $page) {
                Cache::forget("lessons_{$lessonData['course_id']}_page_{$page}");
            }
            Cache::forget('course' . $lessonData['course_id']);
        } else {
            Cache::forget('lessonsNoCourse');
        }

        Cache::forget("lessonInfo_{$lessonData['lesson_id']}");

        return $response['message'];
    }

    public function deleteLesson(string $id, string $courseId = ''): string
    {
        $request = new DeleteLessonRequest($id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        if ($courseId !== '') {
            foreach (range(1, 20) as $page) {
                Cache::forget("lessons_{$courseId}_page_{$page}");
            }
        } else {
            Cache::forget('lessonsNoCourse');
        }

        return $response['message'];
    }

    public function buyCourse(array $data): string
    {
        $request = new BuyCourseRequest($data);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        Cache::forget('course' . $data['courseId']);
        Cache::forget('purchased' . $data['clientId']);

        return $response['message'];
    }

    public function lessonInfo(string $lesson_id): Collection| array
    {
        if (Cache::has("lessonInfo_{$lesson_id}")) {
            return collect(Cache::get("lessonInfo_{$lesson_id}"));
        }
        $request = new LessonsRequest($lesson_id);

        $res = $this->ePandaPay->send($request);

        $response = json_decode($res->body(), true);

        throw_if($res->failed(), MembershipException::class, $response['message']);

        $lesson = $response['data']['lesson'];

        Cache::put("lessonInfo_{$lesson_id}", $lesson, now()->addHour());

        return collect($lesson);
    }
}
