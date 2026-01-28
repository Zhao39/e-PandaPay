<div class="card" style="display: none" x-show="showfilters" x-transition.duration.500ms>
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <p>Filters</p>
            <div>
                <a href="" @click.prevent="showfilters = false">
                    <span class="p-2 bg-light"><i class="fas fa-times"></i></span>
                </a>
            </div>
        </div>
        <div class="d-flex flex-column flex-md-row justify-content-around">
            <div class="mb-2">
                <x-form.label label="Status" />
                <x-form.select wire:model.live='status' :options="[
                    'All' => 'All',
                    'active' => 'Active',
                    'blocked' => 'Blocked',
                ]" />
            </div>

            <div class="mb-2">
                <x-form.label label="Record per Page" />
                <x-form.select wire:model.live='pagenum' :options="[
                    '10' => '10',
                    '20' => '20',
                    '50' => '50',
                    '100' => '100',
                ]" />
            </div>

            <div class="mb-2">
                <x-form.label label="Order By" />
                <x-form.select wire:model.live='orderby' :options="[
                    'id' => 'ID',
                    'name' => 'Fullname',
                    'email' => 'Emaill Address',
                    'created_at' => 'Date Registered',
                ]" />
            </div>

            <div class="mb-2">
                <x-form.label label="Order Direction" />
                <x-form.select wire:model.live='orderdirection' :options="[
                    'desc' => 'Descending',
                    'asc' => 'Ascending',
                ]" />
            </div>

            <div class="mb-2">
                <x-form.label label="From" />
                <x-form.input type="date" wire:model.live="fromDate" />
            </div>
            <div class="mb-2">
                <x-form.label label="To" />
                <x-form.input type="date" wire:model.live="toDate" />
            </div>
        </div>
    </div>
    <div class="card-footer d-lg-flex justify-content-between align-items-center">
        <div class="mb-2 mb-lg-0">
            <x-ui.button type="button" class="btn-sm" wire:click='downloadFile'>
                <x-spinner wire:loading wire:target='downloadFile' />
                Download import doc sample
            </x-ui.button>
        </div>
        <div>
            <x-ui.button type="button" class="btn-sm" wire:click='resetFilter'>
                Reset filter
            </x-ui.button>
        </div>
    </div>
</div>
