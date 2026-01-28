<x-guest-layout>
    <x-slot:title>
        Two factor authentication
    </x-slot:title>
    <div x-data="{ recovery: false }">
        <!--begin::Form-->
        <form class="form w-100" method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <!--begin::Heading-->
            <div class="mb-10 text-center">
                <!--begin::Title-->
                <h1 class="mb-3 text-dark fw-bolder">
                    Twofactor Authentication
                </h1>

                <div class="text-gray-500 fw-semibold fs-6" x-show="! recovery">
                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                </div>

                <div class="text-gray-500 fw-semibold fs-6" x-cloak x-show="recovery">
                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                </div>

            </div>
            <!--begin::Heading-->

            <div class="row">
                <!--begin::Input group--->
                <div class="mb-8 col-12" x-show="! recovery">
                    <x-form.input id="code" type="text" placeholder="Code" inputmode="numeric" name="code"
                        autofocus autocomplete="one-time-code" />
                </div>
                <div class="mb-8 col-12" x-show="recovery">
                    <x-form.input id="recovery_code" type="text" placeholder="Recovery Code" inputmode="numeric"
                        name="recovery_code" autofocus autocomplete="one-time-code" />
                </div>
            </div>

            <!--begin::Actions-->
            <div class="flex-wrap d-flex justify-content-center pb-lg-0">
                <x-ui.button class="me-4">
                    Submit
                </x-ui.button>
                <div>
                    <x-ui.link href="#" class="btn btn-light" label="{{ __('Use a recovery code') }}"
                        x-show="! recovery"
                        x-on:click.prevent="
                        recovery = true;
                        $nextTick(() => { $refs.recovery_code.focus() })
                    " />
                    <x-ui.link href="#" class="btn btn-light" label=" {{ __('Use an authentication code') }}"
                        x-cloak x-show="recovery"
                        x-on:click.prevent="
                        recovery = false;
                        $nextTick(() => { $refs.code.focus() })
                    " />
                </div>
            </div>
            <!--end::Actions-->
        </form>
    </div>
</x-guest-layout>
