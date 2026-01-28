<?php

namespace App\Livewire\Admin\InvestmentPlan;

use App\Models\Plan;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Plans extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $newPlan = false;
    public $updateMode = false;
    public $name;
    public $price;
    public $min_price;
    public $max_price;
    public $min_return;
    public $max_return;
    public $bonus = 0;
    public $increment_interval = 'Monthly';
    public $increment_type = 'Percentage';
    public $increment_amount;
    public $duration;
    public $status;
    public $intervalOptions = [
        'Yearly on June 1st at 17:00' => 'Yearly on June 1st at 18:00',
        'Yearly' => 'Yearly',
        'Quarterly on 4th at 14:00' => 'Quarterly on 4th at 15:00',
        'Quarterly' => 'Quarterly',
        'Last Day of the Month' => 'Last Day of the Month',
        'Twice Monthly' => 'Twice Monthly(1st & 16th at 14:00)',
        'Monthly' => 'Monthly',
        'Weekly on Monday at 8:00' => 'Weekly on Monday at 9:00',
        'Weekly' => 'Weekly',
        'Twice Daily' => 'Twice Daily at 2:00 & 14:00',
        'Daily' => 'Daily',
        'Every 6 Hours' => 'Every 6 Hours',
        'Every 4 Hours' => 'Every 4 Hours',
        'Every 2 Hours' => 'Every 2 Hours',
        'Hourly' => 'Hourly',
        'Every 30 Minutes' => 'Every 30 Minutes',
        'Every 15 Minutes' => 'Every 15 Minutes',
        'Every 10 Minutes' => 'Every 10 Minutes',
    ];
    public $topupTypeOptions = [
        'Percentage' => 'Percentage',
        'Fixed' => 'Fixed',
    ];

    public Plan $plan;

    #[Computed()]
    public function plans()
    {
        return Plan::latest()->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.investment-plan.plans');
    }

    public function createPlan(): void
    {
        Gate::authorize('create investment plan');
        // validate properties to be correct
        $validated = $this->validate($this->validationRules());

        try {
            $this->validateDuration();
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
            return;
        }

        $validated['duration'] = $this->duration;

        // Add validated plan info to database
        Plan::create($validated);
        // dispatch alert
        $this->alert(type: 'success', message: 'Plan created successfully.');
        // reset properties back to their normal state
        $this->resetProps();
        // close the new plan page
        $this->newPlan = false;
    }

    public function updatePlan(): void
    {
        Gate::authorize('edit investment plan');

        // validate properties to be correct
        $validated = $this->validate($this->validationRules());

        try {
            $this->validateDuration();
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
            return;
        }

        $validated['duration'] = $this->duration;

        // Add validated plan info to database
        $this->plan->update($validated);
        // dispatch alert
        $this->alert(type: 'success', message: 'Plan updated successfully.');
        // reset properties back to their normal state
        $this->resetProps();
        // close the update plan page
        $this->updateMode = false;
    }

    public function setPlan(int $id)
    {
        Gate::authorize('delete investment plan');
        $plan = Plan::find($id);
        $this->plan = $plan;
    }

    public function setUpdateMode(int $id)
    {
        Gate::authorize('edit investment plan');
        $plan = Plan::find($id);
        $this->plan = $plan;
        $this->fill($this->plan->toArray());
        $this->updateMode = true;
    }

    public function resetProps(): void
    {
        $this->reset();
    }

    public function markAs(string $id, string $status): void
    {
        Gate::authorize('edit investment plan');
        Plan::find($id)->update(['status' => $status]);
    }

    public function deletePlan(): void
    {
        Gate::authorize('delete investment plan');
        $this->plan->delete();

        $this->alert(type: 'success', message: 'Plan Deleted Successfully.');
    }

    public function showInfo(int $id)
    {
        Gate::authorize('view investment plan');
        $plan = Plan::find($id);
        $this->plan = $plan;
        $this->fill($this->plan->toArray());
    }

    private function validationRules(): array
    {
        return [
            'name' => ['required'],
            'price' => ['required'],
            'min_price' => ['required'],
            'max_price' => ['required'],
            'min_return' => ['required'],
            'max_return' => ['required'],
            'bonus' => ['required'],
            'increment_interval' => ['required'],
            'increment_type' => ['required'],
            'increment_amount' => ['required', 'regex:/^\d+(\.\d+)?(,\s*\d+(\.\d+)?)*$/', 'max:150'],
        ];
    }

    private function validateDuration(): void
    {
        $durationArr = explode(' ', $this->duration);

        // if durationArr does not have 2 elements then return error
        if (count($durationArr) !== 2) {
            throw new \Exception('Invalid duration format');
        }

        $durationNum = $durationArr[0];

        // if the first element of durationArr is not a number then return error
        if (! is_numeric($durationNum)) {
            throw new \Exception('Investment duration should start with a digit greater than 0');
        }

        $durationNum = (int) $durationArr[0];
        $durationType = $durationArr[1];

        //if the digit is 0 return error
        if ($durationArr[0] === 0) {
            throw new \Exception('Investment duration should start with a digit greater than 0');
        }

        // the second element of durationArr should be a word that starts with capital letter and does not contain numeric value
        if (! preg_match('/^[A-Z][a-z]*$/', $durationArr[1])) {
            throw new \Exception('Invalid duration format');
        }
        // $durationNum === 1 and $durationType ends with s then return error
        if ($durationNum === 1 && preg_match('/s$/', $durationType)) {
            throw new \Exception('Should not end with s if duration is 1');
        }

        // should end with s if duration is greater than 1
        if ($durationNum > 1 && ! preg_match('/s$/', $durationType)) {
            throw new \Exception('Should end with s if duration is greater than 1');
        }

        if (! in_array($durationType, ['Days', 'Weeks', 'Months', 'Years', 'Day', 'Week', 'Month', 'Year', 'Minutes', 'Hours', 'Hour'])) {
            throw new \Exception('Should only contain Days, Weeks, Months, Years, Day, Week, Month or Year');
        }
    }
}
