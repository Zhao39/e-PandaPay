<?php

namespace App\Livewire\Admin\CopyTrade;

use App\Models\Settings;
use App\Models\SymbolMap as Symbol;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class SymbolMap extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $from;
    public $to;
    public $addSymbol = false;

    public function mount(): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['subscription'] !== 'true', 404);
    }

    public function render()
    {
        return view('livewire.admin.copy-trade.symbol-map', [
            'symbols' => Symbol::latest()->paginate(10),
        ]);
    }

    public function addSymbolMapping(): void
    {
        $this->validate([
            'from' => 'required',
            'to' => 'required',
        ]);

        Symbol::create([
            'from_symbol' => $this->from,
            'to_symbol' => $this->to,
        ]);

        $this->from = '';
        $this->to = '';
        $this->addSymbol = false;
        $this->alert(message: 'Symbol mapping added successfully');
    }

    // delete symbol mapping
    public function deleteSymbolMapping(int $id): void
    {
        $symbol = Symbol::findOrFail($id);
        $symbol->delete();
        $this->alert(message: 'Symbol mapping deleted successfully');
    }
}
