<?php

namespace App\Livewire\Admin\InvestmentPlan;

use App\Actions\Plan\MarkPlanAsExpiredAndReturnCapital;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class UsersPlans extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $order = 'desc';
    public $status = 'All';
    public $perPage = 10;
    public $user = 'All';
    public $planId;
    public $fromDate = '';
    public $toDate = '';

    #[Computed()]
    public function usersPlans()
    {
        return UserPlan::with('plan:id,name', 'user:id,name,username')
            ->status($this->status)
            ->customer($this->user)
            ->betweenDate($this->fromDate, $this->toDate)
            ->orderBy('id', $this->order)
            ->paginate(15);
    }

    #[Computed()]
    public function users()
    {
        return User::select('name')->IsNotAdmin()->latest()->get();
    }

    public function render()
    {
        return view('livewire.admin.investment-plan.users-plans');
    }

    public function markAsActive(int $id)
    {
        Gate::authorize('edit users plan');
        UserPlan::find($id)->update(['status' => 'active']);
    }

    public function markAsExpired(int $id)
    {
        Gate::authorize('edit users plan');
        $this->planId = $id;
        UserPlan::find($id)->update(['status' => 'expired']);
        $this->alert('question', 'Plan marked as expired. Do you want to return capital to user', [
            'showConfirmButton' => true,
            'showCancelButton' => true,
            'position' => 'center',
            'allowOutsideClick' => false,
            'timer' => null,
            'confirmButtonText' => 'Yes, Return',
            'onConfirmed' => 'returnCapital',
        ]);
    }

    #[On('returnCapital')]
    public function returnCapital()
    {
        $plan = UserPlan::find($this->planId);
        $mark = new MarkPlanAsExpiredAndReturnCapital(userPlan: $plan, returnCapital: true);
        $mark->process();
        $this->alert(message: 'Capital Returned Successfully');
    }

    public function deletePlan()
    {
        Gate::authorize('delete users plan');
        UserPlan::find($this->planId)->delete();
        $this->alert(type: 'success', message: 'User plan Deleted Successfully.');
    }

    public function resetFilter()
    {
        $this->reset();
    }
}
