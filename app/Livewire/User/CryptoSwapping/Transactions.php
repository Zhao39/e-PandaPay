<?php

namespace App\Livewire\User\CryptoSwapping;

use App\Models\CryptoRecord;
use App\Models\Settings;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use LivewireAlert;
    use WithPagination;

    public function render()
    {
        $template = Settings::select('theme')->find(1)->theme;
        return view("{$template}.crypto-swapping.transactions", [
            'transactions' => CryptoRecord::where('user_id', auth()->user()->id)->latest()->paginate(10),
        ])
            ->extends("layouts.{$template}")
            ->title('Swap crypto transactions ');
    }
}
