<ul class="pl-3 nav nav-tabs nav-line nav-color-secondary w-100" role="tablist">
    <li class="nav-item">
        <a class="nav-link" :class="{ 'active': tab === 'overview' }" x-on:click.prevent="tab = 'overview'"
            href="">Overview</a>
    </li>
    @can('edit user')
        <li class="nav-item">
            <a class="nav-link" :class="{ 'active': tab === 'settings' }" x-on:click.prevent="tab = 'settings'"
                href="">Profile Settings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ 'active': tab === 'security' }" x-on:click.prevent="tab = 'security'"
                href="">Security</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ 'active': tab === 'session' }" x-on:click.prevent="tab = 'session'"
                href="">Session</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ 'active': tab === 'refferals' }" x-on:click.prevent="tab = 'refferals'"
                href="">Referrals</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="{ 'active': tab === 'account' }" x-on:click.prevent="tab = 'account'"
                href="">Account</a>
        </li>
    @endcan

</ul>
