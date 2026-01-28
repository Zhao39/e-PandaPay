<?php

namespace App\Livewire\Admin\Membership;

use App\Models\Settings;
use App\Services\MembershipService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CourseLessons extends Component
{
    public string $id;
    public string $page;
    public $nextPageUrl;
    public $previousPageUrl;
    public $lessons;
    public $course;

    public function mount(string $id, string $page): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);

        $this->id = $id;
        $this->page = $page;
    }

    public function render(MembershipService $mem)
    {
        try {
            $data = $mem->courseLessons($this->id, $this->page);
            $this->course = $data['course'];
            $this->nextPageUrl = $data['lessons']['next_page_url'];
            $this->previousPageUrl = $data['lessons']['prev_page_url'];
            $this->lessons = json_decode(json_encode($data['lessons']['data']));
        } catch (\App\Exceptions\MembershipException $e) {
            session()->flash('error', $e->getMessage());
        }

        return view('livewire.admin.membership.course-lessons');
    }
}
