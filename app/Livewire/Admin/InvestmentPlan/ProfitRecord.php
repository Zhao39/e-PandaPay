<?php

namespace App\Livewire\Admin\InvestmentPlan;

use App\Models\Roi;
use App\Models\UserPlan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ProfitRecord extends Component
{
    use WithPagination;
    public UserPlan $userPlan;
    public $order = 'desc';
    public $fromDate = '';
    public $toDate = '';

    public function render()
    {
        return view('livewire.admin.investment-plan.profit-record', [
            'rois' => Roi::where('user_plan_id', $this->userPlan->id)
                ->betweenDate($this->fromDate, $this->toDate)
                ->orderBy('id', $this->order)
                ->paginate(10),
        ]);
    }
    public function resetFilter()
    {
        $this->authorize('see users plan profit history');
        $this->reset(['order', 'fromDate', 'toDate']);
    }
}
