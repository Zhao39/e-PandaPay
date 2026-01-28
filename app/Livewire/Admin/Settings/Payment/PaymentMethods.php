<?php

namespace App\Livewire\Admin\Settings\Payment;

use App\Mail\PaymentMethodMail;
use App\Models\PaymentMethod;
use App\Models\Settings;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class PaymentMethods extends Component
{
    use WithFileUploads;
    use LivewireAlert;
    use WithPagination;

    public $add_new = false;
    public $edit = false;
    public $id;
    public $name;
    public $minimum;
    public $maximum;
    public $charges_amount;
    public $charges_type = 'percentage';
    public $duration;
    public $type = 'both';
    public $img_url;
    public $bank_name;
    public $account_name;
    public $account_number;
    public $swift_code;
    public $wallet_address;
    public $barcode;
    public $network;
    public $methodtype = 'currency';
    public $status = 'active';
    public $default_pay = 0;
    public $note;
    public $coin;

    public function render()
    {
        return view('livewire.admin.settings.payment.payment-methods', [
            'methods' => PaymentMethod::latest()->simplePaginate(15),
        ]);
    }

    public function cancel(): void
    {
        $this->reset();
    }

    public function save(): void
    {
        $this->authorize('add payment method');
        $this->validate([
            'note' => ['nullable', 'max:200'],
            'img_url' => ['nullable'],
            'barcode' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('30mb'),
            ],
        ]);

        $filtered = Arr::except($this->all(), ['add_new', 'edit', 'id', 'paginators', 'barcode']);
        if (! is_null($this->barcode)) {
            $filtered['barcode'] = $this->barcode->store(path: 'barcodes');
        }
        $method = PaymentMethod::create($filtered);
        $settings = Settings::select(['id', 'receive_payment_method_email', 'notifiable_email'])->find(1);
        if ($settings->receive_payment_method_email) {
            dispatch(function () use ($settings, $method) {
                Mail::to($settings->notifiable_email)->send(new PaymentMethodMail($method, auth()->user()->name));
            })->afterResponse();
        }
        $this->alert(message: 'Method Saved Successfully.');
        $this->cancel();
    }

    public function setUpdate(string $id): void
    {
        $this->authorize('edit payment method');
        $method = PaymentMethod::find($id);
        $this->id = $id;
        $this->fill($method);
        $this->add_new = false;
        $this->edit = true;
    }

    public function updateMethod(): void
    {
        $this->authorize('edit payment method');

        if (! is_null($this->barcode) && ! Storage::exists($this->barcode)) {
            $this->validate([
                'barcode' => [
                    'nullable',
                    File::image()
                        ->min('1kb')
                        ->max('30mb'),
                ],
            ]);
        }

        $this->validate([
            'note' => ['nullable', 'max:200'],
            'img_url' => ['nullable'],
        ]);

        $filtered = Arr::except($this->all(), ['add_new', 'edit', 'id', 'paginators', 'barcode']);
        if (! is_null($this->barcode) && ! Storage::exists($this->barcode)) {
            $filtered['barcode'] = $this->barcode->store(path: 'barcodes');
        }
        // update payment method
        $method = PaymentMethod::find($this->id);
        $method->update($filtered);

        // send email to admin
        $settings = Settings::select(['id', 'receive_payment_method_email', 'notifiable_email'])->find(1);

        if ($settings->receive_payment_method_email) {
            dispatch(function () use ($settings, $method) {
                Mail::to($settings->notifiable_email)->send(new PaymentMethodMail($method, auth()->user()->name, false));
            })->afterResponse();
        }
        $this->alert(message: 'Method Updated Successfully.');
        $this->cancel();
    }

    public function delete(string $id): void
    {
        $this->authorize('delete payment method');
        PaymentMethod::find($id)->delete();
        $this->alert(message: 'Method Deleted Successfully.');
    }

    public function changeStatus(string $id, string $status): void
    {
        PaymentMethod::find($id)->update([
            'status' => $status,
        ]);

        $this->alert(message: 'Method Status Changed Successfully.');
    }
}