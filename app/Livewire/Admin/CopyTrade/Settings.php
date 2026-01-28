<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Models\Settings as ModelsSettings;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Settings extends Component
{
    use LivewireAlert;

    public $monthlyFee;
    public $quarterlyFee;
    public $yearlyFee;
    public $iblink;
    public ModelsSettings $set;

    public function mount(): void
    {
        $set = Cache::get('site_settings');
        $this->monthlyFee = $set->monthlyfee;
        $this->quarterlyFee = $set->quarterlyfee;
        $this->yearlyFee = $set->yearlyfee;
        $this->iblink = $set->ib_link;
        $this->set = $set;
    }
    public function render()
    {
        return view('livewire.admin.copy-trade.settings');
    }

    public function save(): void
    {
        $this->authorize('manage copytrade settings');

        $this->validate([
            'monthlyFee' => ['required', 'numeric'],
            'quarterlyFee' => ['required', 'numeric'],
            'yearlyFee' => ['required', 'numeric'],
            'iblink' => ['nullable', 'string'],
        ]);

        $this->set->update([
            'monthlyfee' => $this->monthlyFee,
            'quarterlyfee' => $this->quarterlyFee,
            'yearlyFee' => $this->yearlyFee,
            'ib_link' => $this->iblink,
        ]);

        $this->alert(message: 'Subscription Settings Updated Successfully');
    }
}