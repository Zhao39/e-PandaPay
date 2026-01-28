<?php

namespace App\Livewire\Admin\PlatformAdministration;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class SystemCleanUp extends Component
{
    use LivewireAlert;

    public $checkedrecord = [];

    public function render()
    {
        $tables = collect(DB::select('SHOW TABLES'));
        $tables->transform(function ($item) {
            $db = config('database.connections.mysql.database');
            $database = "Tables_in_{$db}";
            $name = $item->$database;
            return [
                'name' => $name,
                'records' => DB::table($name)->count(),
            ];
        });

        return view('livewire.admin.platform-administration.system-clean-up', [
            'tables' => $tables->all(),
        ]);
    }

    public function cleanUp(): void
    {
        $this->authorize('perform system cleanup');

        if (empty($this->checkedrecord)) {
            $this->alert(type: 'error', message: 'Please select at least one table to clean');
            return;
        }

        if (in_array('users', $this->checkedrecord)) {
            DB::table('users')->where('is_admin', false)->delete();
        } elseif (in_array('crypto_currencies', $this->checkedrecord)) {
            DB::table('crypto_currencies')->where('is_default', false)->delete();
        } else {
            foreach ($this->checkedrecord as $table) {
                DB::table($table)->delete();
            }
        }

        $this->alert(message: 'System clean up completed.');

        $tables = json_encode($this->checkedrecord);

        activity()->log("Performed System Clean, Cleared the following tables: {$tables}");

        $this->reset('checkedrecord');
    }
}
