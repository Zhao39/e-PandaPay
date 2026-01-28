<?php

namespace App\Livewire\Admin\CryptoSwap;

use App\Models\CryptoCurrency;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class ManageAssets extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $addNew = false;
    public $edit = false;
    public $id;
    public $name;
    public $symbol;
    public $price_in_usd;
    public $status;
    public $is_default;
    public $logo_url;
    public $logo_size = 30;

    public function render()
    {
        return view('livewire.admin.crypto-swap.manage-assets', [
            'currencies' => CryptoCurrency::latest()->paginate(10),
        ]);
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function setEdit(string $id): void
    {
        $currency = CryptoCurrency::find($id);
        $this->fill($currency);
        $this->addNew = false;
        $this->edit = true;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'unique:crypto_currencies'],
            'symbol' => ['required', 'unique:crypto_currencies', 'uppercase'],
            'price_in_usd' => ['required'],
            'logo_url' => ['nullable', 'max:220'],
            'logo_size' => ['required', 'integer'],
        ]);

        CryptoCurrency::create($validated);

        Schema::table('crypto_accounts', function (Blueprint $table) {
            $table->decimal(strtolower($this->symbol) . '_balance', 20, 8)->default(0.00)->after('user_id');
        });

        $this->alert(message: 'Currency Saved Successfully.');
        $this->cancel();
    }

    public function saveUpdate(): void
    {
        $validated = $this->validate([
            'name' => ['required'],
            'symbol' => ['required'],
            'price_in_usd' => ['required'],
            'logo_url' => ['nullable', 'max:220'],
            'logo_size' => ['nullable', 'integer'],
        ]);

        CryptoCurrency::where('id', $this->id)->update($validated);

        $this->alert(message: 'Currency Updated Successfully.');
        $this->cancel();
    }

    public function delete(string $id): void
    {
        $curr = CryptoCurrency::where('id', $id)->first();

        Schema::table('crypto_accounts', function (Blueprint $table) use ($curr) {
            $column = strtolower($curr->symbol) . '_balance';
            $table->dropColumn([$column]);
        });

        $curr->delete();

        $this->alert(message: 'Currency Deleted Successfully.');
        $this->cancel();
    }

    public function setStatus(string $id, string $status): void
    {
        CryptoCurrency::where('id', $id)->update(['status' => $status]);
        $this->alert(message: 'Currency Updated Successfully.');
        $this->cancel();
    }
}
