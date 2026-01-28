<?php

namespace App\Livewire\User\Transactions;

use App\Models\Deposit as ModelsDeposit;
use App\Models\Settings;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Deposit extends Component
{
    use WithPagination;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.transactions.deposit")
            ->extends("layouts.{$template}")
            ->title('Deposit tansactions');
    }
    #[Computed]
    public function deposits(): LengthAwarePaginator
    {
        return ModelsDeposit::where('user_id', auth()->user()->id)->latest()->paginate(10);
    }
}
