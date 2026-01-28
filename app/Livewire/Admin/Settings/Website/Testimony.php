<?php

namespace App\Livewire\Admin\Settings\Website;

use App\Models\Image;
use App\Models\Testimony as ModelsTestimony;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Testimony extends Component
{
    use LivewireAlert;

    public $add = false;
    public $edit = false;
    public $position;
    public $name;
    public $what_is_said;
    public $picture;
    public $id;

    public function render()
    {
        return view('livewire.admin.settings.website.testimony', [
            'tests' => ModelsTestimony::latest()->get(),
        ]);
    }

    #[Computed()]
    public function medias(): Collection
    {
        return Image::select('path', 'title')->latest()->get();
    }

    public function save(): void
    {
        $val = $this->validate([
            'position' => ['required', 'max:190'],
            'name' => ['required', 'max:190'],
            'picture' => ['required'],
            'what_is_said' => ['required'],
        ]);
        ModelsTestimony::create($val);
        $this->cancel();
        $this->alert(message: 'Testimony Added Successfully.');
    }

    public function setUpdate(string $id): void
    {
        $test = ModelsTestimony::find($id);
        $this->fill($test);
        $this->add = false;
        $this->edit = true;
    }

    public function delete(string $id): void
    {
        ModelsTestimony::find($id)->delete();
        $this->alert(message: 'Testimony Deleted Successfully.');
    }

    public function saveEdit(): void
    {
        $val = $this->validate([
            'position' => ['required', 'max:190'],
            'name' => ['required', 'max:190'],
            'picture' => ['required'],
            'what_is_said' => ['required'],
        ]);
        ModelsTestimony::where('id', $this->id)->update($val);
        $this->cancel();
        $this->alert(message: 'Testimony Updated Successfully.');
    }

    public function cancel(): void
    {
        $this->reset();
    }
}
