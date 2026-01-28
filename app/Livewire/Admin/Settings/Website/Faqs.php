<?php

namespace App\Livewire\Admin\Settings\Website;

use App\Models\Faq;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Faqs extends Component
{
    use LivewireAlert;

    public $add = false;
    public $edit = false;
    public $question;
    public $answer;
    public $id;

    public function render()
    {
        return view('livewire.admin.settings.website.faqs', [
            'faqs' => Faq::latest()->get(),
        ]);
    }

    public function setUpdate(string $id): void
    {
        $faq = Faq::find($id);
        $this->fill($faq);
        $this->add = false;
        $this->edit = true;
    }

    public function delete(string $id): void
    {
        $faq = Faq::find($id);
        $faq->delete();
        $this->alert(message: 'FAQ Deleted Successfully.');
    }

    public function save(): void
    {
        $val = $this->validate([
            'question' => ['required', 'max:190'],
            'answer' => ['required'],
        ]);
        Faq::create($val);
        $this->cancel();
        $this->alert(message: 'FAQ Saved Successfully.');
    }

    public function saveEdit(): void
    {
        $val = $this->validate([
            'question' => ['required', 'max:190'],
            'answer' => ['required'],
        ]);
        Faq::where('id', $this->id)->update($val);
        $this->cancel();
        $this->alert(message: 'FAQ Updated Successfully.');
    }

    public function cancel(): void
    {
        $this->reset();
    }
}
