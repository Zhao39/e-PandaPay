@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="py-3">
        <div class="mb-0 font-weight-bold">
            {{ $title }}
        </div>
        <div class="text-sm text-muted">
            {{ $content }}
        </div>
    </div>

    <div>
        {{ $footer }}
    </div>
</x-modal>
