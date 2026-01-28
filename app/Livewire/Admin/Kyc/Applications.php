<?php

namespace App\Livewire\Admin\Kyc;

use App\Models\Kyc;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Applications extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $status = 'All';
    public $search = '';

    public function render()
    {
        return view('livewire.admin.kyc.applications', [
            'applications' => Kyc::latest()
                ->with('user:id,name')
                ->whereStatus($this->status)
                ->whereSearch($this->search)
                ->paginate(15),
        ]);
    }

    public function resetFilter()
    {
        $this->reset();
    }

    // delete kyc
    public function delete(string $id): void
    {
        $this->authorize('delete kyc applications');

        $kyc = Kyc::with('user')->find($id);

        if (
            Storage::disk('local')->exists($kyc->frontimg) &&
            Storage::disk('local')->exists($kyc->backimg)
        ) {
            Storage::disk('local')->delete($kyc->frontimg);
            Storage::disk('local')->delete($kyc->backimg);
        }

        $kyc->user->update(['account_verify' => 'reject']);

        $kyc->delete();

        $this->alert(message: 'Kyc Deleted Successfully.');
    }
}
