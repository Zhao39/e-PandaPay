<?php

namespace App\Livewire\Admin\Settings\Website\Web;

use App\Models\Page;
use App\Services\Website;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Pages extends Component
{
    use LivewireAlert;

    public $edit = false;
    public $link_name;
    public $permalink;
    public $name;
    public $title;
    public $description;
    public $keywords;
    public $status;
    public $id;

    public function render()
    {
        return view('livewire.admin.settings.website.web.pages', [
            'pages' =>  Cache::get('pages'),
            'url' => Website::url(true),
        ]);
    }

    public function editPage(string $id): void
    {
        $page = Page::find($id);
        $this->fill($page);
        $this->edit = true;
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function saveEdit(Website $website): void
    {
        $page = Page::find($this->id);

        if ($page->name === 'Home' && $this->status === 'draft') {
            $this->alert(message: 'You cannot set Home Page as draft', type: 'error');
            return;
        }

        $validated = $this->validate([
            'permalink' => ['required', 'starts_with:/', 'regex:/^[a-zA-Z\/\-]*$/', 'lowercase'],
            'link_name' => ['required', 'max:20'],
            'title' => ['required', 'max:50'],
            'description' => ['required', 'max:70'],
            'keywords' => ['required', 'max:30'],
            'status' => ['required'],
        ]);

        $page->update($validated);
        Cache::forget('pages');
        $website->clearCache('route');

        $this->alert(message: 'Page saved successfully.');
    }
}