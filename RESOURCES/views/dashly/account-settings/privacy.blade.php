<div x-data="{ privacy: 'twofactor' }">
    <ul class="nav nav-tabs nav-fill">
        @can('use two-factor authentication')
            <li class="nav-item">
                <a class="nav-link" x-bind:class="privacy == 'twofactor' ? 'active' : ''"
                    @click.prevent="privacy = 'twofactor'" href="#">Twofactor Authentication</a>
            </li>
        @endcan
        @can('manage browser sessions')
            <li class="nav-item">
                <a class="nav-link" x-bind:class="privacy == 'browser_sessions' ? 'active' : ''" href="#"
                    @click.prevent="privacy= 'browser_sessions'">Browser Sessions</a>
            </li>
        @endcan
        @can('delete their account')
            <li class="nav-item">
                <a class="nav-link" x-bind:class="privacy == 'delete_account' ? 'active' : ''" href="#"
                    @click.prevent="privacy= 'delete_account'">Delete Account</a>
            </li>
        @endcan
    </ul>
    @can('use two-factor authentication')
        <hr class="mb-3">
        <div class="twofactor" x-show="privacy === 'twofactor'">
            @livewire('profile.two-factor-authentication-form')
        </div>
    @endcan
    <div class="session" x-show="privacy === 'browser_sessions'" style="display: none">
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

    <div class="delete" x-show="privacy === 'delete_account'" style="display: none">
        @livewire('profile.delete-user-form')
    </div>
</div>
