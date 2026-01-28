<?php

namespace App\Livewire\Admin\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class LessonsWithoutCourses extends Component
{
    public $lessons;
    public $categories;

    public function mount(MembershipService $mem): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);

        try {
            $this->categories = $mem->categories();
        } catch (MembershipException $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function render(MembershipService $mem)
    {
        try {
            $this->lessons = json_decode(json_encode($mem->lessonWithoutCourse()));
        } catch (MembershipException $e) {
            session()->flash('message', $e->getMessage());
        }

        return view('livewire.admin.membership.lessons-without-courses');
    }
}
