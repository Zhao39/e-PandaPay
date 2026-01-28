@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            KYC Application
        </h1>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="py-5 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="text-center">
                                <h2 class="font-weight-bold">KYC Verification</h2>
                                <p>
                                    To comply with regulation, each participant will have to go through identity
                                    verification (KYC/AML) to prevent fraud causes.
                                </p>
                            </div>
                            <div class="p-2 text-center shadow-sm p-md-5">
                                <i class="p-4 mb-3 bi bi-clipboard-data rounded-pill" style="font-size: 35px"></i>
                                <p>You have not submitted your necessary documents to verify your identity. In order to
                                    enjoy our investment system, please verify your identity.</p>

                                @if (Auth::user()->account_verify == 'verified' or Auth::user()->account_verify == 'under review')
                                    <button class="mt-2 btn btn-primary btn-sm" disabled>
                                        Click here to complete your
                                        KYC
                                    </button>
                                    <div>
                                        <small class="text-success">
                                            Your previous application is under review, please wait
                                        </small>
                                    </div>
                                @else
                                    <a href="{{ route('user.kyc.form') }}" class="mt-2 btn btn-primary btn-sm"
                                        @if ($settings->spa_mode) wire:navigate @endif>
                                        Click here to complete your KYC
                                    </a>
                                @endif
                            </div>
                            @can('contact support')
                                <div class="p-2 mt-5 shadow-sm p-lg-4">
                                    <div class="d-md-flex justify-content-between">
                                        <div class="p-2">
                                            <i class="bg-light rounded-pill bi bi-envelope-open-fill"
                                                style="font-size: 30px"></i>
                                        </div>
                                        <div class="p-2">
                                            <h4 class="font-weight-bold">We’re here to help you!</h4>
                                            <p>
                                                Ask a question, manage request, report an issue. Our support team will get
                                                back
                                                to you by email.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <a href="{{ route('user.contactsupport') }}" class="btn btn-primary btn-sm"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            Get Support
                                        </a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
