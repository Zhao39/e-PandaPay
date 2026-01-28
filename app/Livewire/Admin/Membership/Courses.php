<?php

namespace App\Livewire\Admin\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Courses extends Component
{
    public $courses;
    public $page;
    public $nextPageUrl;
    public $previousPageUrl;
    public $categories;

    public function mount(MembershipService $membership, $page)
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);

        $this->page = $page;
        try {
            $this->categories = $membership->categories();
        } catch (MembershipException $e) {
            session()->flash('message', $e->getMessage());
        }
    }

    public function render(MembershipService $membership)
    {
        try {
            $response = $membership->courses($this->page);
            $this->courses = json_decode(json_encode($response['data']));
            $this->nextPageUrl = $response['next_page_url'];
            $this->previousPageUrl = $response['prev_page_url'];
        } catch (MembershipException $e) {
            session()->flash('message', $e->getMessage());
        }
        return view('livewire.admin.membership.courses');
    }
}
