<div class="py-5 text-center">
    <form action="" wire:submit='payWithPayPal'>
        <x-ui.button>
            <x-spinner wire:loading wire:target="payWithPayPal" />
            <i class="bi bi-paypal" wire:loading.remove wire:target="payWithPayPal"></i>
            Pay with PayPal
        </x-ui.button>
    </form>
</div>
