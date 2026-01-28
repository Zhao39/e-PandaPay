<?php

namespace App\Livewire\Admin\PlatformAdministration;

use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.admin')]
class ActivitiesLog extends Component
{
    use WithPagination;
    public $order = 'desc';
    public $fromDate = '';
    public $toDate = '';

    public function render()
    {
        return view('livewire.admin.platform-administration.activities-log', [
            'activities' => Activity::with('causer')
                ->betweenDate($this->fromDate, $this->toDate)
                ->orderBy('id', $this->order)
                ->paginate(10),
        ]);
    }

    public function resetFilter(): void
    {
        $this->reset();
    }
}
