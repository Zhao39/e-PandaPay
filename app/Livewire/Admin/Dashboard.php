<?php

namespace App\Livewire\Admin;

use App\Models\Deposit;
use App\Models\Plan;
use App\Models\Settings;
use App\Models\User;
use App\Models\UserPlan;
use App\Models\Withdrawal;
use Asantibanez\LivewireCharts\Models\ColumnChartModel;
use Asantibanez\LivewireCharts\Models\LineChartModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public $year;
    public $years = [];
    public $month;
    public $yearr;
    public function mount(): void
    {
        $this->year = now()->format('Y');
        $this->yearr = now()->format('Y');
        $this->month = 'All';
        for ($i = 2012; $i <= $this->year; $i++) {
            $this->years[] = $i;
        }
    }

    public function render()
    {
        $total_deposited = Cache::remember('total_deposited', now()->addHour(), function () {
            return DB::table('deposits')->where('status', 'Processed')->sum('amount');
        });
        $total_withdrawn = Cache::remember('total_withdrawn', now()->addHour(), function () {
            return DB::table('withdrawals')->where('status', 'processed')->sum('amount');
        });
        $chart_pendepsoit = Cache::remember('chart_pendepsoit', now()->addHour(), function () {
            return DB::table('deposits')->where('status', 'Pending')->sum('amount');
        });
        $chart_pendwithdraw = Cache::remember('chart_pendwithdraw', now()->addHour(), function () {
            return DB::table('withdrawals')->where('status', 'pending')->sum('amount');
        });

        $userlist = User::isNotAdmin()->count();
        $blockedusers = User::isNotAdmin()->where('status', 'blocked')->count();
        $activities = Activity::take(6)->with('causer')->latest()->get();

        $usersOnline = DB::table('sessions')->select(['id', 'user_id'])->get()->transform(function ($session) {
            return User::isNotAdmin()->where('id', $session->user_id)->select(['id', 'name', 'username', 'email'])->first();
        });

        $topPerformingInv = Cache::remember('topPerformingInv', now()->addHour(), function () {
            return UserPlan::with('user:id,name', 'plan:id,name')
                ->where('status', 'active')
                ->orderByDesc('profit_earned')
                ->take(5)->get();
        });

        return view('livewire.admin.dashboard', [
            'regChart' => $this->chart('registration'),
            'tranChart' => $this->chart('transactions'),
            'total_deposited' => $total_deposited,
            'total_withdrawn' => $total_withdrawn,
            'numberOfUsers' => $userlist,
            'blockedusers' => $blockedusers,
            'chart_pendepsoit' => $chart_pendepsoit,
            'chart_pendwithdraw' => $chart_pendwithdraw,
            'inv_plans' => Plan::count(),
            'active_users' => User::isNotAdmin()->where('status', 'active')->count(),
            'randomUsers' => User::isNotAdmin()->inRandomOrder()->take(6)->get(),
            'subscribers' => UserPlan::where('status', 'active')->count(),
            'activities' => $activities,
            'usersOnline' => $usersOnline,
            'topPerformingInv' => $topPerformingInv,
            'quote' => $this->quote(),
        ]);
    }

    // inspiration quoest function for admin dashboard

    public function quote(): string
    {
        $quotes = collect([
            'The greatest glory in living lies not in never falling, but in rising every time we fall. - Nelson Mandela',
            'The way to get started is to quit talking and begin doing. - Walt Disney',
            'Your time is limited, so don\'t waste it living someone else\'s life. - Steve Jobs',
            'If life were predictable it would cease to be life, and be without flavor. - Eleanor Roosevelt',
            'If you look at what you have in life, you\'ll always have more. If you look at what you don\'t have in life, you\'ll never have enough. - Oprah Winfrey',
            'If you set your goals ridiculously high and it\'s a failure, you will fail above everyone else\'s success. - James Cameron',
            'Life is what happens when you\'re busy making other plans. - John Lennon',
            'Spread love everywhere you go. Let no one ever come to you without leaving happier. - Mother Teresa',
            'When you reach the end of your rope, tie a knot in it and hang on. - Franklin D. Roosevelt',
            'Always remember that you are absolutely unique. Just like everyone else. - Margaret Mead',
            'Don\'t judge each day by the harvest you reap but by the seeds you plant. - Robert Louis Stevenson',
            'The future belongs to those who believe in the beauty of their dreams. - Eleanor Roosevelt',
            'Tell me and I forget. Teach me and I remember. Involve me and I learn. - Benjamin Franklin',
        ]);

        // return random quote from the collection
        return $quotes->random();
    }

    private function chart(string $type)
    {
        $settings = Settings::select('website_theme', 'currency')->find(1);
        if ($type === 'registration') {
            return (new ColumnChartModel())
                ->setTitle('Users Registration Chart')
                ->setAnimated(true)
                ->addColumn('Jan', $this->userRegistrationCount(1), $settings->website_theme)
                ->addColumn('Feb', $this->userRegistrationCount(2), $settings->website_theme)
                ->addColumn('Mar', $this->userRegistrationCount(3), $settings->website_theme)
                ->addColumn('Apr', $this->userRegistrationCount(4), $settings->website_theme)
                ->addColumn('May', $this->userRegistrationCount(5), $settings->website_theme)
                ->addColumn('Jun', $this->userRegistrationCount(6), $settings->website_theme)
                ->addColumn('Jul', $this->userRegistrationCount(7), $settings->website_theme)
                ->addColumn('Aug', $this->userRegistrationCount(8), $settings->website_theme)
                ->addColumn('Sep', $this->userRegistrationCount(9), $settings->website_theme)
                ->addColumn('Oct', $this->userRegistrationCount(10), $settings->website_theme)
                ->addColumn('Nov', $this->userRegistrationCount(11), $settings->website_theme)
                ->addColumn('Dec', $this->userRegistrationCount(12), $settings->website_theme);
        }

        if ($type === 'transactions') {
            $conDep = $this->transactions()['deposits'];
            $conWith = $this->transactions()['withdrawals'];
            $inv = $this->transactions()['investments'];

            return (new LineChartModel())
                ->setTitle("Transactions in {$settings->currency}")
                ->setAnimated(true)
                ->addPoint('Processed Deposits', $conDep)
                ->addPoint('Processed Withdrawals', $conWith)
                ->addPoint('Investments', $inv);
        }
    }

    private function transactions(): array
    {
        if ($this->month === 'All') {
            $conDep = Deposit::where('status', 'Processed')->whereYear('created_at', $this->yearr)->sum('amount');
            $conWith = Withdrawal::where('status', 'processed')->whereYear('created_at', $this->yearr)->sum('amount');
            $inv = UserPlan::whereYear('created_at', $this->yearr)->sum('amount');
        } else {
            $conDep = Deposit::where('status', 'Processed')->whereYear('created_at', $this->yearr)->whereMonth('created_at', $this->month)->sum('amount');
            $conWith = Withdrawal::where('status', 'processed')->whereYear('created_at', $this->yearr)->whereMonth('created_at', $this->month)->sum('amount');
            $inv = UserPlan::whereYear('created_at', $this->yearr)->whereMonth('created_at', $this->month)->sum('amount');
        }

        return [
            'deposits' => $conDep,
            'withdrawals' => $conWith,
            'investments' => $inv,
        ];
    }

    private function userRegistrationCount(string $month): int
    {
        return DB::table('users')
            ->whereMonth('created_at', $month)
            ->where('is_admin', false)
            ->whereYear('created_at', $this->year)
            ->count();
    }
}