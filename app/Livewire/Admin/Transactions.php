<?php

namespace App\Livewire\Admin;

use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Transactions extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $search = '';
    public $order = 'desc';
    public $status = 'all';
    public $perPage = 10;
    public $toDate = '';
    public $fromDate = '';
    public $deleteId = '';

    public function render()
    {
        return view('livewire.admin.transactions', [
            'transactions' => Transaction::with('user')
                ->search($this->search)
                ->status($this->status)
                ->orderBy('id', $this->order)
                ->with('user:id,name,username')
                ->date($this->fromDate, $this->toDate)
                ->paginate($this->perPage),
        ]);
    }

    public function deleteTransaction(string $id): void
    {
        Gate::authorize('delete transactions');

        Transaction::find($id)->delete();

        $this->resetFilter();
        $this->alert(type: 'success', message: 'Transaction record deleted Successfully.');
    }

    public function resetFilter()
    {
        $this->reset();
    }
}
