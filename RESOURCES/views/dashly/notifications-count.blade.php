<div>
    @if ($notificationsCount > 0)
        <span class="top-0 position-absolute start-100 translate-middle badge rounded-pill text-bg-danger">
            {{ $notificationsCount }}<span class="visually-hidden">unread
                messages</span>
        </span>
    @endif
</div>
