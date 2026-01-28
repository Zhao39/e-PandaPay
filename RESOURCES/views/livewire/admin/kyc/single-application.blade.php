@use('\Illuminate\Support\Str', 'Str')
<x-slot:title>
    Process Application
</x-slot:title>
<div>
    <x-breadcrumbs title="Process Application">
        <li class="nav-item">
            <a href="{{ route('admin.kycApplications') }}" @if ($settings->spa_mode) wire:navigate @endif> KYC
                Applications</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href=""> Process Application</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-12">
            <p>
                <a href="{{ route('admin.kycApplications') }}">
                    <i class="p-2 rounded-lg fa fa-arrow-circle-left fa-2x bg-light"></i>
                </a>
            </p>
            <div class="mt-2 mb-4 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="title1 ">{{ $kyc->user->name }} KYC Application</h1>
                    @if ($status == 'verified')
                        <span class="badge badge-success">Verified</span>
                    @else
                        <span class="badge badge-danger">{{ $status }}</span>
                    @endif
                </div>
                @can('process kyc applications')
                    <a href="#" data-toggle="modal" data-target="#action" class="btn btn-primary btn-sm">Action</a>
                @endcan
            </div>
            <div id="action" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content" data-background-color="light">
                        <div class="modal-header ">
                            <h3 class="mb-2 d-inline ">Process KYC</h3>
                            <button type="button" class="close " data-dismiss="modal" aria-h6="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" x-data="{ action: @entangle('action') }">
                            <form method="post" wire:submit='submit'>
                                <div class="form-row">
                                    <div class="form-group col-12">
                                        <label>Action</label>
                                        <x-form.select name="action" wire:model='action' :options="[
                                            'verified' => 'Accept and verify user',
                                            'reject' => 'Reject and remain unverified',
                                        ]" required />
                                    </div>
                                </div>
                                <div class="form-row" style="display: none" x-show="action == 'reject'">
                                    <div class="form-group col-12">
                                        <label>Reason</label>
                                        <textarea wire:model="reason" placeholder="Enter Reason" class="form-control" rows="3"
                                            x-bind:required="sendEmail">
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="mb-3 text-right col-12">
                                        <x-ui.button>Submit</x-ui.button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="p-2 card p-md-4 ">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-12 border-bottom">
                            <small class="text-primary">Personal Information</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->first_name }}</h2>
                            <small class="text-muted">First name</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->last_name }}</h2>
                            <small class="text-muted">Last name</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->email }}</h2>
                            <small class="text-muted">Email</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->phone_number }}</h2>
                            <small class="text-muted">Phone Number</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->dob }}</h2>
                            <small class="text-muted">Date of Birth</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->social_media }}</h2>
                            <small class="text-muted">Social Media username</small>
                        </div>
                        <div class="my-3 border-bottom col-md-12">
                            <small class="text-primary">Address Information</small>
                        </div>

                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->address }}</h2>
                            <small class="text-muted">Address Line</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->city }}</h2>
                            <small class="text-muted">City</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->state }}</h2>
                            <small class="text-muted">State</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <h2 class="">{{ $kyc->country }}</h2>
                            <small class="text-muted">Nationality</small>
                        </div>
                        <div class="my-3 border-bottom col-md-12">
                            <small class="text-primary">Document Information</small>
                        </div>
                        <div class="mb-5 col-md-12">
                            <h2 class="">{{ $kyc->document_type }}</h2>
                            <small class="text-muted">Document type</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <x-ui.button type="button" class="btn-sm" wire:click="downloadFile('front')">
                                <i class="bi bi-download" wire:loading.remove wire:target="downloadFile('front')"></i>
                                <x-spinner wire:loading wire:target="downloadFile('front')" />
                                Download
                            </x-ui.button>
                            <small class="text-muted d-block">Front View of {{ $kyc->document_type }}</small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <x-ui.button type="button" class="btn-sm" wire:click="downloadFile('back')">
                                <i class="bi bi-download" wire:loading.remove wire:target="downloadFile('back')"></i>
                                <x-spinner wire:loading wire:target="downloadFile('back')" />
                                Download
                            </x-ui.button>
                            <small class="text-muted d-block">Back View of {{ $kyc->document_type }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
