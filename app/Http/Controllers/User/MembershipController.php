<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Contracts\View\View;

class MembershipController extends Controller
{
    protected readonly string $template;

    public function __construct()
    {
        $this->template = Settings::select('website_theme')->find(1)->website_theme;
    }

    public function courses(): View
    {
        return view("{$this->template}.membership.courses");
    }

    public function courseDetails(): View
    {
        return view("{$this->template}.membership.course-details");
    }

    public function myCourses(): View
    {
        return view("{$this->template}.membership.my-courses");
    }

    public function myCoursesDetails(): View
    {
        return view("{$this->template}.membership.my-course-details");
    }

    public function learning(): View
    {
        return view("{$this->template}.membership.learning");
    }
}
