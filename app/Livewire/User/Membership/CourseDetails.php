<?php

namespace App\Livewire\User\Membership;

use App\Exceptions\MembershipException;
use App\Mail\MembershipMail;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\User\MembershipCoursePurchased;
use App\Services\MembershipService;
use Illuminate\Support\Facades\Mail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CourseDetails extends Component
{
    use LivewireAlert;

    public $data;
    public $purchased = false;

    public function mount(MembershipService $membership, string $course, string $id)
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);
        try {
            $this->data = json_decode($membership->course($id));
            $this->purchased = in_array(auth()->user()->id, $this->data->usersWhoPurchased);
        } catch (MembershipException $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        } catch (\Throwable $e) {
            $this->flash(type: 'warning', message: $e->getMessage(), redirect: route('user.dashboard'));
        }
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.membership.course-details")
            ->extends("layouts.{$template}")
            ->title('Course Details');
    }

    public function buyCourse(MembershipService $membership): void
    {
        $user = User::find(auth()->user()->id);

        if ($user->account_bal < floatval($this->data->course->amount)) {
            $this->alert(type: 'error', message: 'Your account balance is insufficient to purchase this course.');
            return;
        }

        try {
            $response = $membership->buyCourse([
                'courseId' => $this->data->course->id,
                'clientId' => $user->id,
            ]);

            // debit user
            $user->account_bal -= floatval($this->data->course->amount);
            $user->save();

            $course_name = $this->data->course->course_title;

            // create transaction history
            Transaction::create([
                'user_id' => $user->id,
                'amount' => floatval($this->data->course->amount),
                'narration' => "Bought course: {$course_name}",
                'type' => 'Debit',
            ]);

            $setting = Settings::select(['id', 'send_buy_course_email', 'receive_buy_course_email', 'notifiable_email'])->find(1);

            if ($setting->send_buy_course_email) {
                $message = "You just purchased this course: {$course_name}.";
                dispatch(function () use ($user, $course_name, $message) {
                    $user->notify(new MembershipCoursePurchased($course_name, floatval($this->data->course->amount), $message));
                })->afterResponse();
            }

            if ($setting->receive_buy_course_email) {
                dispatch(function () use ($setting, $user, $course_name) {
                    Mail::to($setting->notifiable_email)->send(new MembershipMail([
                        'name' => $user->name,
                        'course_name' => $course_name,
                    ]));
                })->afterResponse();
            }

            $this->alert(message: $response);
            $this->purchased = true;
        } catch (MembershipException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
