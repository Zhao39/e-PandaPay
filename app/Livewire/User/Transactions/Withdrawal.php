<?php

namespace App\Livewire\User\Transactions;

use App\Models\Settings;
use App\Models\Withdrawal as ModelsWithdrawal;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Withdrawal extends Component
{
    use WithPagination;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.transactions.withdrawal")
            ->extends("layouts.{$template}")
            ->title('Deposit tansactions');
    }
    #[Computed()]
    public function withdrawals(): LengthAwarePaginator
    {
        return ModelsWithdrawal::where('user_id', auth()->user()->id)->latest()->paginate(10);
    }
}
