<?php

namespace App\Livewire\User\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class WatchLesson extends Component
{
    use LivewireAlert;

    public $data;
    public $lesson;

    public function mount(MembershipService $membership, $lesson, $course = null): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);

        try {
            if (! is_null($course)) {
                $this->data = json_decode($membership->course($course));
            }
            $this->lesson = $membership->lessonInfo($lesson);
        } catch (MembershipException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.membership.watch-lesson")
            ->extends("layouts.{$template}")
            ->title('Lesson');
    }
}
