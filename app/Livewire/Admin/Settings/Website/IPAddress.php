<?php

namespace App\Livewire\Admin\Settings\Website;

use App\Models\IPAddress as ModelsIPAddress;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class IPAddress extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $add = false;
    public $edit = false;
    public $address;
    public $description;

    public function render()
    {
        return view('livewire.admin.settings.website.i-p-address', [
            'ips' => ModelsIPAddress::latest()->paginate(10),
        ]);
    }

    public function delete(string $id): void
    {
        ModelsIPAddress::find($id)->delete();
        $this->alert(message: 'IP Address Deleted Successfully.');
    }

    public function save(): void
    {
        $val = $this->validate([
            'address' => ['required', 'max:190', 'ip'],
            'description' => ['required', 'max:190'],
        ]);
        ModelsIPAddress::create($val);
        $this->cancel();
        $this->alert(message: 'IP Address Added Successfully.');
    }

    public function cancel(): void
    {
        $this->reset();
    }
}
