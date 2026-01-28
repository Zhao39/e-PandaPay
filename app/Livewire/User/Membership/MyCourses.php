<?php

namespace App\Livewire\User\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MyCourses extends Component
{
    use LivewireAlert;

    public $data;

    public function mount(MembershipService $membership): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);
        try {
            $this->data = $membership->myCourses(auth()->user()->id);
        } catch (MembershipException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        }
    }
    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.membership.my-courses")
            ->extends("layouts.{$template}")
            ->title('My Courses');
    }
}
