<?php

namespace App\Livewire\Admin\ManageUsers;

use App\Exports\UsersExport;
use App\Http\Integrations\GetEPandaPay\GetEPandaPay;
use App\Http\Integrations\GetEPandaPay\Requests\AccountAdjustment;
use App\Imports\UsersImport;
use App\Models\Plan;
use App\Models\Transaction;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Renderless;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

#[Layout('layouts.admin')]
class ListUsers extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $pagenum = 10;
    public $searchvalue = '';
    public $orderby = 'id';
    public $orderdirection = 'desc';
    public $selectPage = false;
    public $status = 'All';
    public $selectAll = false;
    public $checkedrecord = [];
    public $toDate = '';
    public $fromDate = '';
    public $selected = '';
    public $action = 'Delete';
    public $numberOfUsers;
    public $bulkAction = '';
    public $whatToClear = [];
    public $options = [
        'balance' => 'Account Balance',
        'Bonus' => 'Bonus',
        'Ref_Bonus' => 'Refferal Bonus',
        'Profit' => 'Profit (ROI)',
    ];
    public $column = 'balance';
    public $amount;
    public $adjustment = 'Credit';
    public $history = 'Yes';
    public $exportAs = 'Excel';
    public $exportFields = [];
    public $excelFile;

    public function mount(): void
    {
        $this->numberOfUsers = User::isNotAdmin()->count();
    }

    public function render()
    {
        return view('livewire.admin.manage-users.list-users');
    }

    #[Computed()]
    public function users(): LengthAwarePaginator
    {
        return User::search($this->searchvalue)
            ->select('id', 'name', 'username', 'email', 'account_bal', 'status', 'created_at', 'country', 'profile_photo_path')
            ->isNotAdmin()
            ->status($this->status)
            ->orderBy($this->orderby, $this->orderdirection)
            ->date($this->fromDate, $this->toDate)
            ->paginate($this->pagenum);
    }

    #[Computed()]
    public function plans(): Collection
    {
        return Plan::latest()->get();
    }

    public function downloadFile()
    {
        try {
            return Storage::disk('local')->download('users.xlsx');
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }

    public function selectAllRecords(): void
    {
        $this->checkedrecord = User::query()
            ->select('id')
            ->isNotAdmin()
            ->pluck('id')->map(fn($id) => (string) $id);
        $this->selectPage = true;
    }

    public function deSelectAll(): void
    {
        $this->reset('checkedrecord', 'selectPage');
    }

    public function updatedSelectPage()
    {
        if ($this->selectPage) {
            $this->checkedrecord = $this->users->pluck('id')->map(fn($id) => (string) $id);
        } else {
            $this->checkedrecord = [];
        }
    }

    public function resetFilter()
    {
        $this->reset();
    }

    public function updatedCheckedrecord()
    {
        $this->selectAll = false;
        $this->selectPage = false;
    }

    public function clearAccount(): void
    {
        $this->authorize('edit user');

        $users = User::whereIn('id', $this->checkedrecord)->get();

        foreach ($users as $user) {
            $userService = new UserService($user);
            foreach ($this->whatToClear as $action) {
                $userService->clearAccount($action);
            }
        }

        $this->reset(['whatToClear', 'bulkAction', 'checkedrecord']);

        $this->alert(type: 'success', message: 'Accounts cleared successfully');
    }

    public function adjustAccount(): void
    {
        $this->authorize('edit user');

        $users = User::whereIn('id', $this->checkedrecord)->get();

        foreach ($users as $user) {
            if (
                $this->adjustment === 'Debit' &&
                $this->column === 'balance' &&
                ($user->account_bal < $this->amount)
            ) {
                continue;
            }
            if (
                $this->adjustment === 'Debit' &&
                $this->column === 'Bonus' &&
                ($user->bonus < $this->amount)
            ) {
                continue;
            }

            if (
                $this->adjustment === 'Debit' &&
                $this->column === 'Ref_Bonus' &&
                ($user->ref_bonus < $this->amount)
            ) {
                continue;
            }

            if (
                $this->adjustment === 'Debit' &&
                $this->column === 'Profit' &&
                ($user->roi < $this->amount)
            ) {
                continue;
            }
            $GetEPandaPay = new GetEPandaPay();
            $request = new AccountAdjustment([
                'topUpType' => $this->adjustment,
                'userBalance' => $user->account_bal,
                'userRoi' => $user->roi,
                'userRef' => $user->ref_bonus,
                'userBonus' => $user->bonus,
                'type' => $this->column,
                'amount' => $this->amount,
            ]);

            $response = $GetEPandaPay->send($request);

            if ($response->failed()) {
                $error = json_decode($response->body());
                $this->alert(type: 'warning', message: $error->message);
                break;
                return;
            }
            $response = json_decode($response->body(), true);
            $user->update($response['data']['fixtures']);

            if ($this->history === 'Yes') {
                Transaction::create([
                    'user_id' => $user->id,
                    'narration' => "{$this->adjustment} {$user->name} account",
                    'amount' => $this->amount,
                    'type' => $this->adjustment,
                ]);
            }
        }
        $this->reset(['bulkAction', 'checkedrecord', 'amount']);
        $this->alert(message: 'Accounts Adjusted Successfully');
    }

    public function deleteAccount(): void
    {
        $this->authorize('delete user');

        $users = User::whereIn('id', $this->checkedrecord)->get();

        foreach ($users as  $user) {
            (new UserService($user))->deleteAccount();
        }
        $this->reset(['bulkAction', 'checkedrecord']);
        $this->alert(message: 'Accounts Deleted Successfully');
    }

    public function startExport(): void
    {
        $this->authorize('edit user');

        if (empty($this->checkedrecord)) {
            $this->alert('error', 'Please select at least one record to export');
            return;
        }

        $this->dispatch('open-export-modal');
    }
    #[Renderless]
    public function export()
    {
        $this->authorize('edit user');

        $this->alert(message: 'Export is completed');

        $this->dispatch('close-export-modal');

        if ($this->exportAs === 'Excel') {
            return Excel::download(new UsersExport(collect($this->checkedrecord)->toArray(), $this->exportFields), 'users-export.xlsx', \Maatwebsite\Excel\Excel::XLSX);
        }

        return Excel::download(new UsersExport(collect($this->checkedrecord)->toArray(), $this->exportFields), 'users-export.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function saveImport(): void
    {
        $this->authorize('edit user');
        $this->validate([
            'excelFile' => [
                'required',
                File::types(['xlsx', 'csv'])
                    ->min('1kb')
                    ->max('30mb'),
            ],
        ]);

        try {
            Excel::import(new UsersImport(), $this->excelFile);
            $this->alert(message: 'Import is completed');
            $this->excelFile = null;
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errors = [];
            foreach ($failures as $failure) {
                array_push($errors, $failure->errors());
            }
            $this->alert(type: 'error', message: 'Something went wrong');
            session()->flash('errors', $errors);
        } catch (\Throwable $th) {
            $this->alert(type: 'error', message: $th->getMessage());
        }
    }
}
