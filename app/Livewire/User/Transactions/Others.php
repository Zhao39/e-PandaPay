<?php

namespace App\Livewire\User\Transactions;

use App\Models\Settings;
use App\Models\Transaction;
use Illuminate\Pagination\Paginator;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Others extends Component
{
    use WithPagination;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.transactions.others", [
            'totalTransactionsCount' => Transaction::where('user_id', auth()->user()->id)->count(),
        ])
            ->extends("layouts.{$template}")
            ->title('Other tansactions');
    }

    #[Computed()]
    public function transactions(): Paginator
    {
        return Transaction::where('user_id', auth()->user()->id)->latest()->simplePaginate(10);
    }
}
