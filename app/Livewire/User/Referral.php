<?php

namespace App\Livewire\User;

use App\Models\Deposit;
use App\Models\Roi;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Referral extends Component
{
    use WithPagination;
    use LivewireAlert;

    public bool $viewRef;
    public string $refLevel;
    public $children;
    public $referrals;
    public $totalDeposit;
    public $totalAmountInPlans;
    public $totalProfit;
    public User $user;
    public float $commision;
    public string $level;
    public array $downlinesIds;
    public array $directIDs;
    public array $level1IDs;
    public array $level2IDs;
    public array $level3IDs;
    public array $level4IDs;
    public array $level5IDs;

    public function mount()
    {
        $this->viewRef = false;
        $this->level = 'Direct level';
        $this->directIDs = User::where('reffered_by', auth()->user()->id)->pluck('id')->toArray();
        $this->level1IDs = User::whereIn('reffered_by', $this->directIDs)->pluck('id')->toArray();
        $this->level2IDs = User::whereIn('reffered_by', $this->level1IDs)->pluck('id')->toArray();
        $this->level3IDs = User::whereIn('reffered_by', $this->level2IDs)->pluck('id')->toArray();
        $this->level4IDs = User::whereIn('reffered_by', $this->level3IDs)->pluck('id')->toArray();
        $this->level5IDs = User::whereIn('reffered_by', $this->level4IDs)->pluck('id')->toArray();

        $this->totalDeposit = $this->calculateDeposit($this->directIDs);
        $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
        $this->totalProfit = $this->calculateProfit($this->directIDs);

        $settings = Settings::find(1);
        $this->commision = $settings->referral_commission;
    }

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        $parent = User::where('id', auth()->user()->reffered_by)->select(['id', 'name'])->first();
        if ($template === 'dashly') {
            $downlines = $this->getDownlines(auth()->user()->id);
        } else {
            $downlines = null;
        }
        return view("{$template}.referral", [
            'parent' => $parent,
            'downlines' => $downlines,
        ])
            ->extends("layouts.{$template}")
            ->title('Refer & earn');
    }

    public function calculateDeposit(array $ids): float
    {
        if ($this->level === 'Direct level') {
            $children = User::where('reffered_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('reffered_by', $ids)->select(['id'])->get();
        }

        $total = 0;
        foreach ($children as $child) {
            $total += Deposit::where('user_id', $child->id)->where('status', 'Processed')->sum('amount');
        }

        return $total;
    }

    public function totalAmountInPlans(array $ids): float
    {
        if ($this->level === 'Direct level') {
            $children = User::where('reffered_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('reffered_by', $ids)->select(['id'])->get();
        }
        $total = 0;
        foreach ($children as $child) {
            $total += UserPlan::where('user_id', $child->id)->sum('amount');
        }

        return $total;
    }

    public function calculateProfit(array $ids): float
    {
        if ($this->level === 'Direct level') {
            $children = User::where('reffered_by', auth()->user()->id)->select(['id'])->get();
        } else {
            $children = User::whereIn('reffered_by', $ids)->select(['id'])->get();
        }
        $total = 0;
        foreach ($children as $child) {
            $total += Roi::where('user_id', $child->id)->sum('amount');
        }

        return $total;
    }

    public function changeLevel(string $level): void
    {
        $this->level = $level;
        $settings = Settings::find(1);
        if ($level === 'Direct level') {
            $this->totalDeposit = $this->calculateDeposit($this->directIDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
            $this->totalProfit = $this->calculateProfit($this->directIDs);
        } elseif ($level === 'Level 1') {
            $downlines = $this->getReferralsUnderLevel($this->directIDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->directIDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->directIDs);
            $this->totalProfit = $this->calculateProfit($this->directIDs);
            $this->commision = floatval($settings->referral_commission1);
        } elseif ($level === 'Level 2') {
            $downlines = $this->getReferralsUnderLevel($this->level1IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level1IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level1IDs);
            $this->totalProfit = $this->calculateProfit($this->level1IDs);
            $this->commision = floatval($settings->referral_commission2);
        } elseif ($level === 'Level 3') {
            $downlines = $this->getReferralsUnderLevel($this->level2IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level2IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level2IDs);
            $this->totalProfit = $this->calculateProfit($this->level2IDs);
            $this->commision = floatval($settings->referral_commission3);
        } elseif ($level === 'Level 4') {
            $downlines = $this->getReferralsUnderLevel($this->level3IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level3IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level3IDs);
            $this->totalProfit = $this->calculateProfit($this->level3IDs);
            $this->commision = floatval($settings->referral_commission4);
        } elseif ($level === 'Level 5') {
            $downlines = $this->getReferralsUnderLevel($this->level4IDs);
            $this->children = $downlines->items();
            $this->totalDeposit = $this->calculateDeposit($this->level4IDs);
            $this->totalAmountInPlans = $this->totalAmountInPlans($this->level4IDs);
            $this->totalProfit = $this->calculateProfit($this->level4IDs);
            $this->commision = floatval($settings->referral_commission5);
        }
    }

    public function getOtherColumns(string $id, string $type)
    {
        if ($type === 'deposit') {
            return Deposit::where('user_id', $id)->where('status', 'Processed')->sum('amount');
        }

        if ($type === 'invested') {
            return UserPlan::where('user_id', $id)->sum('amount');
        }

        if ($type === 'profit') {
            return Roi::where('user_id', $id)->sum('amount');
        }

        if ($type === 'recent') {
            return Roi::where('user_id', $id)->orderBy('id', 'desc')->first();
        }
    }

    public function getReferralsUnderLevel(array $ids)
    {
        $refs = User::whereIn('reffered_by', $ids)->paginate(15);

        $refs->transform(function ($downline) {
            return [
                'id' => $downline->id,
                'name' => $downline->name,
                'email' => $downline->email,
                'totalDeposit' => $this->getOtherColumns($downline->id, 'deposit'),
                'totalInvestment' => $this->getOtherColumns($downline->id, 'invested'),
                'totalProfit' => $this->getOtherColumns($downline->id, 'profit'),
                'recent' => $this->getOtherColumns($downline->id, 'recent'),
                'parent' => User::where('id', $downline->reffered_by)->select(['name', 'id'])->first(),
                'status' => $downline->status,
                'created_at' => $downline->created_at->format('d M, Y'),
            ];
        });

        return $refs;
    }

    public function showDetails(int $id): void
    {
        $settings = Settings::find(1);
        $this->user = User::where('id', $id)->select(['name', 'id'])->first();
        $downlines = $this->getDownlines($id);
        $this->referrals = $downlines->items();

        if ($this->level === 'Direct level') {
            $commission = $settings->referral_commission;
        } else {
            $num = Str::of($this->level)->after('Level ');
            $commission = $settings->referral_commission . $num;
        }
        $this->level = 'Level 1';

        $this->totalDeposit = $this->calculateDeposit([$id]);
        $this->totalAmountInPlans = $this->totalAmountInPlans([$id]);
        $this->totalProfit = $this->calculateProfit([$id]);
        $this->commision = floatval($commission);

        $this->viewRef = true;
    }

    public function cancelShowDeatials()
    {
        $settings = Settings::find(1);
        $this->level = 'Direct level';
        $commission = $settings->referral_commission;
        $this->totalDeposit = $this->calculateDeposit([$this->user->id]);
        $this->totalAmountInPlans = $this->totalAmountInPlans([$this->user->id]);
        $this->totalProfit = $this->calculateProfit([$this->user->id]);
        $this->commision = floatval($commission);

        $this->user = new User();
        $this->viewRef = false;
    }

    public function getDownlines($parent = 0)
    {
        //get downline using map function
        $downlines = User::where('reffered_by', $parent)->select(['id', 'name', 'email', 'reffered_by', 'status', 'created_at'])->orderByDesc('id')->paginate(10);

        $downlines->transform(function ($downline) {
            return [
                'id' => $downline->id,
                'name' => $downline->name,
                'email' => $downline->email,
                'totalDeposit' => $this->getOtherColumns($downline->id, 'deposit'),
                'totalInvestment' => $this->getOtherColumns($downline->id, 'invested'),
                'totalProfit' => $this->getOtherColumns($downline->id, 'profit'),
                'recent' => $this->getOtherColumns($downline->id, 'recent'),
                'parent' => User::where('id', $downline->reffered_by)->select(['name', 'id'])->first(),
                'status' => $downline->status,
                'created_at' => $downline->created_at->format('d M, Y'),
            ];
        });
        return $downlines;
    }
}
