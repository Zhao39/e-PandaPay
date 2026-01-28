<?php

namespace App\Livewire\Admin\Settings;

use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\SetModulesRequest;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

#[Layout('layouts.admin')]
class ModulesSettings extends Component
{
    use LivewireAlert;

    public $set;
    public $modules;
    public $permissions = [];
    public $role;

    public function mount(): void
    {
        $role = Role::firstWhere('name', 'User');
        $this->permissions = $role->permissions->pluck('name');
        $this->role = $role;

        $settings = Settings::select([
            'id',
            'modules',
        ])->find(1);
        $this->fill($settings);
        $this->set = $settings;
    }

    public function render()
    {
        return view('livewire.admin.settings.modules-settings');
    }

    public function updateModule($module, $value)
    {
        if ($module === 'membership' || $module === 'signal') {
            $GetEPandaPay = new GetEPandaPay();
            $request = new SetModulesRequest([
                'value' => $value,
                'module' => ucfirst($module),
            ]);

            $response = $GetEPandaPay->send($request);
            $res = json_decode($response->body(), true);

            if ($response->failed()) {
                $this->flash(type: 'warning', message: $res['message'], redirect: route('admin.settings.modules'));
                return;
            }

            $this->set->update(['modules' => $this->modules]);

            $this->flash(message: 'Settings Saved Successfully', redirect: route('admin.settings.modules'));
        } else {
            $this->set->update(['modules' => $this->modules]);
            $this->flash(message: 'Settings Saved Successfully', redirect: route('admin.settings.modules'));
        }
        Cache::forget('site_settings');
        activity()->log('Modules Settings Updated');
    }

    public function savePermissions(): void
    {
        $this->role->syncPermissions($this->permissions);
        $this->alert(message: 'Settings Saved Successfully');
    }
}