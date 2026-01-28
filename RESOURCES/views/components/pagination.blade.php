@if (!is_null($previousPageUrl) || !is_null($nextPageUrl))
    <div class="mt-3 col-12">
        @php
            $nextPage = intval($page) + 1;
            $prevPage = intval($page) - 1;
        @endphp
        <nav aria-label="pagination">
            @if ($previousPageUrl)
                <a class="btn btn-primary btn-sm" href="{{ route($route, ['page' => $prevPage, 'id' => $id ?? null]) }}"
                    @if ($settings->spa_mode) wire:navigate @endif>
                    <i class="bi bi-arrow-left"></i>
                    Previous
                </a>
            @else
                <button class="btn btn-light btn-sm" disabled>
                    <i class="bi bi-arrow-left"></i>
                    Previous
                </button>
            @endif

            @if ($nextPageUrl)
                <a class="btn btn-primary btn-sm" href="{{ route($route, ['page' => $nextPage, 'id' => $id ?? null]) }}"
                    @if ($settings->spa_mode) wire:navigate @endif>
                    Next
                    <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <button class="btn btn-light btn-sm" disabled>
                    Next
                    <i class="bi bi-arrow-right"></i>
                </button>
            @endif
        </nav>
    </div>
@endif
