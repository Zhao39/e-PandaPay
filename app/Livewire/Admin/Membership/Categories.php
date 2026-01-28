<?php

namespace App\Livewire\Admin\Membership;

use App\Exceptions\MembershipException;
use App\Models\Settings;
use App\Services\MembershipService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Categories extends Component
{
    use LivewireAlert;
    public $categories;
    public $addNew = false;
    public $categoryName;

    public function mount(): void
    {
        $settings = Settings::select('modules')->find(1);
        abort_if($settings->modules['membership'] !== 'true', 404);
    }

    public function render(MembershipService $membership)
    {
        try {
            $this->categories = $membership->categories();
        } catch (MembershipException $e) {
            session()->flash('error', $e->getMessage());
        }
        return view('livewire.admin.membership.categories');
    }

    public function save(MembershipService $membership): void
    {
        $this->validate(['categoryName' => ['required']]);
        try {
            $message = $membership->saveCategory($this->categoryName);
            $this->categoryName = '';
            $this->addNew = false;
            $this->alert(message: $message);
        } catch (MembershipException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
    public function delete(MembershipService $membership, string $id): void
    {
        try {
            $message = $membership->deleteCategory($id);
            $this->alert(message: $message);
        } catch (MembershipException $e) {
            $this->alert(type: 'error', message: $e->getMessage());
        }
    }
}
