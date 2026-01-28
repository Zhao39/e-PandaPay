<?php

namespace App\Livewire\Pages\Home;

use App\Models\Content;
use App\Models\Page;
use App\Models\Plan;
use App\Models\Settings;
use App\Models\Testimony;
use App\Models\Faq as ModelsFaq;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.pages')]
class Home extends Component
{
    public Page $page;
    public $set;

    public function mount()
    {
        $page = Page::where('name', 'Home')->first();
        abort_if($page->status === 'draft', 404);
        $settings = Settings::select(['id', 'redirect_url', 'home_theme'])->find(1);
        $this->set = $settings;
        if (! empty($settings->redirect_url)) {
            return redirect()->away($settings->redirect_url);
        }
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.pages.home.' . $this->set->home_theme, [
            'contents' => Content::all(),
            'plans' => Plan::latest()->get(),
            'testimones' => Testimony::latest()->get(),
            'faqs' => ModelsFaq::latest()->get(),
        ]);
    }
}
