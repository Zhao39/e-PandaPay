<?php

namespace App\Livewire\Pages;

use App\Models\Content;
use App\Models\Page;
use App\Models\Settings;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.pages')]
class Terms extends Component
{
    public Page $page;

    public function mount()
    {
        $page = Page::where('name', 'Terms')->first();
        abort_if($page->status === 'draft', 404);
        $settings = Settings::select('redirect_url')->find(1);
        if (! empty($settings->redirect_url)) {
            return redirect()->away($settings->redirect_url);
        }
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.pages.terms', [
            'terms' => Content::where('ref_key', 'skjf23')->first(),
        ]);
    }
}
