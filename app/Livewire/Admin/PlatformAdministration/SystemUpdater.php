<?php

namespace App\Livewire\Admin\PlatformAdministration;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\GetSoftwareVersionRequest;
use App\Http\Integrations\GetEPandaPay\Requests\GetUpdateFilesRequest;
use App\Models\Settings;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use ZipArchive;

#[Layout('layouts.admin')]
class SystemUpdater extends Component
{
    use LivewireAlert;

    public $version;
    public $hasUpdate;
    public $set;

    public function mount(): void
    {
        $settings = Cache::get('site_settings');
        $this->set = $settings;
        $this->version = $settings->software_version;
        $this->hasUpdate = $settings->software_has_update;
    }

    public function render()
    {
        return view('livewire.admin.platform-administration.system-updater');
    }

    public function checkVersion()
    {
        $GetEPandaPay = new GetEPandaPay();
        $request = new GetSoftwareVersionRequest();
        $response = $GetEPandaPay->send($request);

        $res = json_decode($response->body(), true);

        if ($response->failed()) {
            $this->alert(type: 'error', message: $res['message']);
            return;
        }

        if (floatval($res['version']) > $this->version) {
            $this->set->software_has_update = true;
            $this->set->save();
            $this->hasUpdate = true;
            return;
        }

        $this->alert(message: 'Your system is up-to-date. There are no new versions to update!');
    }

    public function updateSystem()
    {
        // get the update files from the remote location
        $GetEPandaPay = new GetEPandaPay();
        $request = new GetUpdateFilesRequest();
        $response = $GetEPandaPay->send($request);

        $res = json_decode($response->body(), true);

        if ($response->failed()) {
            $this->alert(type: 'error', message: $res['message']);
            return;
        }

        $zipFile = $res['zip_file'];

        // read the content of the zip file
        $zip = new ZipArchive();
        $open = $zip->open($zipFile);

        if ($open) {
            // extract the zip file to the base folder
            $zip->extractTo(base_path());
            $zip->close();
        }

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('migrate');
        Artisan::call('view:cache');
        Artisan::call('route:cache');
        Artisan::call('config:cache');

        $this->set->software_has_update = false;
        $this->set->software_version = floatval($res['version']);
        $this->set->save();

        $this->hasUpdate = false;

        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        session()->flash('success', 'Your system have been updated successfully, please login again to continue');

        $this->redirect(route('admin.dashboard'), $this->set->spa_mode);
    }
}