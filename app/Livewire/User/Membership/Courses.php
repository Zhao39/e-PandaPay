<?php

namespace App\Livewire\User\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Throwable;

class Courses extends Component
{
    use LivewireAlert;

    public $courses;
    public $lessons;
    public $page;
    public $nextPageUrl;
    public $previousPageUrl;

    public function mount(MembershipService $membership, $page)
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);
        $this->page = $page;
        try {
            $this->lessons = json_decode(json_encode($membership->lessonWithoutCourse()));
            $response = $membership->courses($this->page);
            $this->courses = json_decode(json_encode($response['data']));
            $this->nextPageUrl = $response['next_page_url'];
            $this->previousPageUrl = $response['prev_page_url'];
        } catch (MembershipException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        } catch (Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.membership.courses")
            ->extends("layouts.{$template}")
            ->title('Courses');
    }
}
