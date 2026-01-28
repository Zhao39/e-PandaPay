<div class="pb-3 text-center">
    <form wire:submit='payViaRave'>
        <button class="py-2 btn btn-primary" type="submit">
            <x-spinner wire:loading wire:target="payViaRave" />
            <i class="bi bi-credit-card" wire:loading.remove wire:target="payViaRave"></i>
            Pay via Rave
        </button>
    </form>
</div>
