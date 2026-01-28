<div x-data="{ open: false }" class="p-3">
    <button type="button" class="btn btn-primary btn-sm" x-on:click="open = true" x-show="!open">
        Mark as Completed
    </button>

    <div x-show="open" style="display: none">
        <form action="{{ route('user.deposit.submitpayment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Upload Screenshot</label>
                <x-form.input type="file" name="proof" :required="true" />
                <x-form.input type="hidden" name="amount" value="{{ $amount }}" />
                <x-form.input type="hidden" name="method_name" value="{{ $method->name }}" />
                <small> <strong>NOTE:</strong> Only Images and PDF are allowed. </small>
                <small class="text-info">
                    If you encounter an error asking you to select an image even though you have already chosen one,
                    please click the 'Complete Deposit' button again.
                </small>
            </div>
            <div class="m-0 modal-footer">
                <button type="submit" class="btn btn-primary btn-sm">
                    <x-spinner wire:loading wire:target="savePayment" />
                    <i class="bi bi-upload" wire:loading.remove wire:target="savePayment"></i>
                    Submit
                </button>
                <button type="button" class="btn btn-dark btn-sm" x-on:click="open = false">Cancel</button>
            </div>
        </form>
    </div>
</div>
