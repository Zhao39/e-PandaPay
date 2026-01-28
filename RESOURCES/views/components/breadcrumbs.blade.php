@props(['title', 'homeUrl' => route('admin.dashboard')])
<div class="page-header">
    <h4 class="page-title">{{ $title }}</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ url($homeUrl) }}" @if ($settings->spa_mode) wire:navigate @endif>
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        {{ $slot }}
    </ul>
</div>
