<div class="mb-4 text-center">
    <form wire:submit='payWithPaystack'>
        <button class="btn btn-primary" type="submit">
            <x-spinner wire:loading wire:target="payWithPaystack" />
            <i class="bi bi-credit-card" wire:loading.remove wire:target="payWithPaystack"></i>
            Pay via Paystack
        </button>
    </form>
</div>
