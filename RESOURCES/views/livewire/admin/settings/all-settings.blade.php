<x-slot:title>
    Settings
</x-slot:title>
<div>
    <x-breadcrumbs title="Settings">
        <li class="nav-item">
            <a href="#">Settings</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class=" font-weight-bolder">Common</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('update general settings')
                            <div class="col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-gear-wide"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.general') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">General Settings</h5>
                                    </a>
                                    <small>View and update your general settings.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update email settings')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-envelope-fill"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.email') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Email</h5>
                                    </a>
                                    <small>View and update your email settings</small>
                                </div>
                            </div>
                        @endcan

                        @can('update email templates')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-envelope-plus"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.emailTemplates') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Email templates</h5>
                                    </a>
                                    <small>Email templates using HTML & system variables.</small>
                                </div>
                            </div>
                        @endcan

                        @can('update dashboard appearance')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-brilliance"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.appearance') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Website/Dashboard Appearance</h5>
                                    </a>
                                    <small>View and update dashboard theme and appearance</small>
                                </div>
                            </div>
                        @endcan

                        @can('update modules settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-border-all"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.modules') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Modules Settings</h5>
                                    </a>
                                    <small>View and update your modules setting for users</small>
                                </div>
                            </div>
                        @endcan

                        @can('update preference')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-columns-gap"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.sitePreference') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Preferences</h5>
                                    </a>
                                    <small>Setup app usage preference</small>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class=" font-weight-bolder">Payment</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('view payment methods')
                            <div class="mt-lg-0 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-credit-card"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.methods') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Payment Methods</h5>
                                    </a>
                                    <small>View and update your payment methods</small>
                                </div>
                            </div>
                        @endcan

                        @can('update payment preference')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-gear-wide-connected"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.preference') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Payment Preference</h5>
                                    </a>
                                    <small>View and update your payment preference </small>
                                </div>
                            </div>
                        @endcan
                        @can('update coinpayment settings')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-coin"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.coinpayment') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Coinpayment Gateway</h5>
                                    </a>
                                    <small>View and update your coinpayment API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update stripe settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-stripe"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.stripe') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Stripe</h5>
                                    </a>
                                    <small>View and update your stripe API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update paypal settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-paypal"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.paypal') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Paypal</h5>
                                    </a>
                                    <small>View and update your Paypal API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update paystack settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-wallet-fill"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.paystack') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Paystack</h5>
                                    </a>
                                    <small>View and update your Paystack API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update flutterwave settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-snow2"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.flutterwave') }}"
                                        class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Flutterwave (Rave)</h5>
                                    </a>
                                    <small>View and update your Flutterwave API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update binance settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="fas fa-draw-polygon"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.binance') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Binance</h5>
                                    </a>
                                    <small>View and update your Binance API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update coinbase settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans">
                                        <i class="bi bi-coin"></i>
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.coinbase') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Coinbase</h5>
                                    </a>
                                    <small>View and update your Coinbase API keys.</small>
                                </div>
                            </div>
                        @endcan
                        @can('update fund transfer settings')
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-arrow-down-up"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.payment.transfer') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Fund Transfer</h5>
                                    </a>
                                    <small>Enable/Disable fund transfer between users</small>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        @can('update ref & other bonuses')
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class=" font-weight-bolder">Bonus</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mt-lg-0 col-lg-6">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-link-45deg"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.bonus.ref') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Referral Bonus</h5>
                                    </a>
                                    <small>View and update 5 level referral bonus </small>
                                </div>
                            </div>

                            <div class="mt-5 col-lg-6 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-gift-fill"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.bonus.others') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Reg & Deposit Bonuses</h5>
                                    </a>
                                    <small>View and update registraion and deposit bonus </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        @can('update website settings')
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class=" font-weight-bolder">Website</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mt-lg-0 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-patch-question"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.faqs') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Faq</h5>
                                    </a>
                                    <small>Manage all your Frequestly asked questions.</small>
                                </div>
                            </div>

                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-emoji-smile"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.testimonies') }}"
                                        class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Testimony</h5>
                                    </a>
                                    <small>Manage all your client's testimonies.</small>
                                </div>
                            </div>

                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-globe"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.pages') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Web Pages</h5>
                                    </a>
                                    <small>View and update your website pages & contents.</small>
                                </div>
                            </div>

                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-card-image"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.media') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Media</h5>
                                    </a>
                                    <small>Manage your media (Images).</small>
                                </div>
                            </div>
                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-sliders2-vertical"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.settings') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Website Settings</h5>
                                    </a>
                                    <small>View and update site settings.</small>
                                </div>
                            </div>

                            <div class="mt-5 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-geo"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.website.ipaddress') }}"
                                        class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Blacklist IP Address</h5>
                                    </a>
                                    <small>Blacklist IP Address from accessing your website.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class=" font-weight-bolder">Others</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @can('update social login settings')
                            <div class="mt-lg-0 col-lg-4">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-google "></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.socialLogin') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Social Login</h5>
                                    </a>
                                    <small>View and update your social login settings</small>
                                </div>
                            </div>
                        @endcan
                        @can('update communication settings')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-bell-fill"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.communication') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Communication</h5>
                                    </a>
                                    <small>Make Annoucements and more with your users</small>
                                </div>
                            </div>
                        @endcan
                        @can('update control center')
                            <div class="mt-5 col-lg-4 mt-lg-0">
                                <div class="mb-2">
                                    <span class="p-2 bg-light bg-drk-trans"><i class="bi bi-ui-checks"></i></span>
                                </div>
                                <div>
                                    <a href="{{ route('admin.settings.center') }}" class="text-decoration-none"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        <h5 class="text-primary font-weight-bold">Control Center</h5>
                                    </a>
                                    <small>View and basic settings on your system.</small>
                                </div>
                            </div>
                        @endcan
                        {{-- <div class="mt-5 col-lg-4 mt-lg-0">
                            <div class="mb-2">
                                <span class="p-2 bg-light bg-drk-trans"><i class="fas fa-users"></i></span>
                            </div>
                            <div>
                                <a href="" class="text-decoration-none">
                                    <h5 class="text-primary font-weight-bold">Contact</h5>
                                </a>
                                <small>Settings for contact plugin</small>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
