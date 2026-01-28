<?php

namespace App\Livewire\Admin\PlatformAdministration;

use App\Services\Website;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class CacheManagement extends Component
{
    use LivewireAlert;

    public function render()
    {
        return view('livewire.admin.platform-administration.cache-management');
    }

    public function optiimize(Website $website, string $type): void
    {
        try {
            if ($type === 'cache') {
                $website->setToProductionEnvironment();
                $this->alert(message: 'Website optimized');
            } else {
                $website->setToLocalEnvironment();
                $this->alert(message: 'Website optimization cleared');
            }
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
    public function clearCache(Website $website, string $type)
    {
        try {
            $website->clearCache($type);
            if ($type === 'symlink') {
                activity()->log('Run Symlink');
                $this->alert(message: 'Symlink created successfully');
            } else {
                activity()->log("Cleared {$type} cache");
                $this->alert(message: 'Cache cleared Successfully');
            }
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
}
