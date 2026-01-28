<?php

namespace App\Livewire\Pages;

use App\Models\Content;
use Livewire\Component;

class Footer extends Component
{
    public function render()
    {
        return view('livewire.pages.footer', [
            'contents' => Content::all(),
        ]);
    }
}
