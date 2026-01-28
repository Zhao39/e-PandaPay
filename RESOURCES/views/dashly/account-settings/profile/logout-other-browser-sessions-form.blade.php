<div>
    <h4 class="mb-0 font-weight-bold"> {{ __('Browser Sessions') }}</h4>
    <p class="text-muted">
        {{ __('Manage and log out your active sessions on other browsers and devices.') }}
    </p>
    <div>
        @if (count($this->sessions) > 0)
            <div class="mt-2">
                <table class="table table-hover">
                    <thead>
                        <th> User Agent</th>
                        <th> IP Address</th>
                        <th> Last Active</th>
                    </thead>
                    <tbody>
                        @foreach ($this->sessions as $session)
                            <tr>
                                <td>
                                    <span class="text-sm text-muted">
                                        @if ($session->agent->isDesktop())
                                            <i class="bi bi-display"></i>
                                        @else
                                            <i class="bi bi-phone"></i>
                                        @endif
                                        {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }}
                                        -
                                        {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                    </span>
                                </td>
                                <td>
                                    {{ $session->ip_address }}
                                </td>
                                <td>
                                    @if ($session->is_current_device)
                                        <span class="font-weight-bold text-success">{{ __('This device') }}</span>
                                    @else
                                        {{ $session->last_active }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        <div>
            <div class="mt-2 d-flex align-items-center">
                <x-ui.button class="btn-sm" wire:click="confirmLogout" wire:loading.attr="disabled">
                    {{ __('Log Out Other Browser Sessions') }}
                </x-ui.button>

                <x-action-message class="ms-3" on="loggedOut">
                    {{ __('Done.') }}
                </x-action-message>
            </div>
            <!-- Log Out Other Devices Confirmation Modal -->
            <x-dialog-modal wire:model.live="confirmingLogout">
                <x-slot name="title">
                    {{ __('Log Out Other Browser Sessions') }}
                </x-slot>

                <x-slot name="content">
                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}

                    <div class="mt-2" x-data="{}"
                        x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                        <x-form.input type="password" autocomplete="current-password"
                            placeholder="{{ __('Password') }}" x-ref="password" wire:model="password"
                            wire:keydown.enter="logoutOtherBrowserSessions" />

                        <x-input-error for="password" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <x-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-ui.button class="ms-3" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled">
                        {{ __('Log Out Other Browser Sessions') }}
                    </x-ui.button>
                </x-slot>
            </x-dialog-modal>
        </div>
    </div>
</div>
