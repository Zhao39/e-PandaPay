<?php

namespace App\Livewire\Admin\Settings\Website\Web;

use App\Models\Content;
use App\Models\Image;
use App\Models\Page;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Contents extends Component
{
    use LivewireAlert;

    public Page $page;
    public $message;

    public function mount()
    {
        $this->message = Content::where('ref_key', 'skjf23')->first()->description ?? null;
    }

    public function render()
    {
        return view('livewire.admin.settings.website.web.contents', [
            'contents' => Content::where('page', $this->page->name)->get(),
        ]);
    }

    #[Computed]
    public function images(): Collection
    {
        return Image::all();
    }

    public function saveTerms(): void
    {
        Content::where('ref_key', 'skjf23')->update([
            'description' => $this->message,
        ]);
        activity()->log('Terms and Conditions Updated');
        $this->alert(message: 'Page saved successfully.');
    }
}
