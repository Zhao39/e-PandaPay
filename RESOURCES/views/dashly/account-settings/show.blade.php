@use('\Illuminate\Support\Str', 'Str')
<div>
    <h1 class="h2">
        Account Settings
    </h1>
    <x-danger-alert />
    <x-success-alert />

    <div class="pr-0 row" style="padding-right: 0px">
        <div class="col-md-4 col-xxl-3">
            <!-- Card -->
            <div class="border-0 card sticky-md-top top-10px">
                @can('update their profile')
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <div class="mb-5 avatar avatar-xxl avatar-circle">
                                @include('dashly.account-settings.picture')
                            </div>
                            <h3 class="mb-0">{{ auth()->user()->name }}</h3>
                            <span class="small text-secondary fw-semibold">{{ auth()->user()->email }}</span>
                        </div>
                        <!-- Divider -->
                        <hr class="mb-0">
                    </div>
                @endcan

                <ul class="mb-5 scrollspy" id="account" data-scrollspy='{"offset": "30"}'>
                    @can('update their profile')
                        <li>
                            <a href="#basicInformationSection" class="py-3 d-flex align-items-center">
                                <svg viewBox="0 0 24 24" height="14" width="14" class="me-3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.750 6.000 A5.250 5.250 0 1 0 17.250 6.000 A5.250 5.250 0 1 0 6.750 6.000 Z"
                                        fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5" />
                                    <path d="M2.25,23.25a9.75,9.75,0,0,1,19.5,0" fill="none" stroke="currentColor"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                </svg>
                                Basic information
                            </a>
                        </li>
                    @endcan
                    @can('change their password')
                        <li>
                            <a href="#passwordSection" class="py-3 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" height="14"
                                    width="14" class="me-3">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M18.75 9.75H5.25C4.42157 9.75 3.75 10.4216 3.75 11.25V21.75C3.75 22.5784 4.42157 23.25 5.25 23.25H18.75C19.5784 23.25 20.25 22.5784 20.25 21.75V11.25C20.25 10.4216 19.5784 9.75 18.75 9.75Z" />
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1.5"
                                        d="M6.75 9.75V6C6.75 4.60761 7.30312 3.27226 8.28769 2.28769C9.27226 1.30312 10.6076 0.75 12 0.75C13.3924 0.75 14.7277 1.30312 15.7123 2.28769C16.6969 3.27226 17.25 4.60761 17.25 6V9.75" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M8.625 15C8.41789 15 8.25 14.8321 8.25 14.625C8.25 14.4179 8.41789 14.25 8.625 14.25" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M8.625 15C8.83211 15 9 14.8321 9 14.625C9 14.4179 8.83211 14.25 8.625 14.25" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M8.625 18.75C8.41789 18.75 8.25 18.5821 8.25 18.375C8.25 18.1679 8.41789 18 8.625 18" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M8.625 18.75C8.83211 18.75 9 18.5821 9 18.375C9 18.1679 8.83211 18 8.625 18" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M12 15C11.7929 15 11.625 14.8321 11.625 14.625C11.625 14.4179 11.7929 14.25 12 14.25" />
                                    <path stroke="currentColor" stroke-width="1.5"
                                        d="M12 15C12.2071 15 12.375 14.8321 12.375 14.625C12.375 14.4179 12.2071 14.25 12 14.25" />
                                    <g>
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M12 18.75C11.7929 18.75 11.625 18.5821 11.625 18.375C11.625 18.1679 11.7929 18 12 18" />
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M12 18.75C12.2071 18.75 12.375 18.5821 12.375 18.375C12.375 18.1679 12.2071 18 12 18" />
                                    </g>
                                    <g>
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M15.375 15C15.1679 15 15 14.8321 15 14.625C15 14.4179 15.1679 14.25 15.375 14.25" />
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M15.375 15C15.5821 15 15.75 14.8321 15.75 14.625C15.75 14.4179 15.5821 14.25 15.375 14.25" />
                                    </g>
                                    <g>
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M15.375 18.75C15.1679 18.75 15 18.5821 15 18.375C15 18.1679 15.1679 18 15.375 18" />
                                        <path stroke="currentColor" stroke-width="1.5"
                                            d="M15.375 18.75C15.5821 18.75 15.75 18.5821 15.75 18.375C15.75 18.1679 15.5821 18 15.375 18" />
                                    </g>
                                </svg>
                                Password
                            </a>
                        </li>
                    @endcan
                    @can('update their withdrawal payment options')
                        <li>
                            <a href="#paymentMethodsSection" class="py-3 d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" height="14" width="14"
                                    class="me-3">
                                    <defs>
                                        <style>
                                            .a {
                                                fill: none;
                                                stroke: currentColor;
                                                stroke-linecap: round;
                                                stroke-linejoin: round;
                                                stroke-width: 1.5px;
                                            }
                                        </style>
                                    </defs>
                                    <title>credit-card-1</title>
                                    <rect class="a" x="0.75" y="3.75" width="22.5" height="16.5" rx="1.5"
                                        ry="1.5" />
                                    <line class="a" x1="0.75" y1="8.25" x2="23.25" y2="8.25" />
                                    <line class="a" x1="5.25" y1="12.75" x2="13.5" y2="12.75" />
                                    <line class="a" x1="5.25" y1="15.75" x2="10.5" y2="15.75" />
                                </svg>
                                Withdrawal methods
                            </a>
                        </li>
                    @endcan
                    <li>
                        <a href="#privacyAndSafetySection" class="py-3 d-flex align-items-center">
                            <svg viewBox="0 0 24 24" height="14" width="14" class="me-3"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.749,9a8.25,8.25,0,0,1,13.5-6.364" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <path
                                    d="M19.687,6a8.23,8.23,0,0,1,.562,3v6A8.25,8.25,0,0,1,12,23.25a8.336,8.336,0,0,1-1.5-.136"
                                    fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="1.5" />
                                <path d="M6.751,21.365a8.234,8.234,0,0,1-3-6.365V12.75" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" />
                                <path d="M15.749,15V9a3.75,3.75,0,0,0-6-3" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                                <path d="M8.249,9v6A3.753,3.753,0,0,0,13.5,18.438" fill="none"
                                    stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="1.5" />
                                <path d="M11.999 9.75L11.999 14.25" fill="none" stroke="currentColor"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                            </svg>
                            Privacy and Safety
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col">
            <!-- Card -->
            @can('update their profile')
                <div class="border-0 card scroll-mt-3" x-ref="basicInformationSection" id="basicInformationSection">
                    <div class="card-header">
                        <h2 class="mb-0 h3">Basic information</h2>
                    </div>
                    @include('dashly.account-settings.profile')
                </div>
            @endcan
            @can('change their password')
                <!-- Card -->
                <div class="border-0 card scroll-mt-3" id="passwordSection">
                    <div class="card-header">
                        <h2 class="mb-0 h3">Password</h2>
                    </div>
                    @include('dashly.account-settings.password')
                </div>
            @endcan
            @can('update their withdrawal payment options')
                <!-- Card -->
                <div class="border-0 card scroll-mt-3" id="paymentMethodsSection">
                    <div class="card-header">
                        <h2 class="mb-0 h3">Withdrawal methods</h2>
                    </div>
                    @include('dashly.account-settings.withrdwal-method')
                </div>
            @endcan
            <div class="border-0 card scroll-mt-3" id="privacyAndSafetySection">
                <div class="card-header">
                    <h2 class="mb-0 h3">Privacy and Safety</h2>
                </div>
                <div class="card-body">
                    @include('dashly.account-settings.privacy')
                </div>
            </div>
        </div>
    </div>
</div>
