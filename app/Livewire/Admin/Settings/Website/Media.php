<?php

namespace App\Livewire\Admin\Settings\Website;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Media extends Component
{
    use WithPagination;
    use WithFileUploads;
    use LivewireAlert;

    public $add = false;
    public $edit = false;

    public $photos = [];

    public function render()
    {
        return view('livewire.admin.settings.website.media', [
            'images' => Image::latest()->get(),
        ]);
    }

    public function save()
    {
        $this->validate([
            'photos.*' => [
                'image',
                File::types(['jpg', 'jpeg', 'png', 'webp', 'pdf', 'mp4', 'webm', 'gif'])->max('55mb'),
            ],
        ]);

        if (count($this->photos) === 0) {
            $this->alert(type: 'error', message: 'Please select at least one image');
            return;
        }

        foreach ($this->photos as $photo) {
            $path = $photo->store(path: 'media');
            $image = new Image();
            $image->title = $photo->hashName();
            $image->path = $path;
            $image->save();
        }
        $this->cancel();
        $this->alert(message: 'Images Uploaded Successfully.');
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function delete(string $id): void
    {
        $image = Image::find($id);
        if (Storage::exists($image->path)) {
            Storage::delete($image->path);
        }
        $image->delete();
        $this->alert(message: 'Image Deleted Successfully.');
    }
}
