@inject('refs', 'App\Http\Controllers\Controller')
@php
    $array = \App\Models\User::isNotAdmin()->get();
@endphp
<div>
    <div class="page-title">
        <div class="row justify-content-between align-items-center">
            <div class="mb-3 col-md-6 mb-md-0">
                <h5 class="mb-0 text-white h3 font-weight-400">Refer users to {{ $settings->site_name }} community</h5>
            </div>
        </div>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row" x-data="{
                        copied: false,
                        url: '{{ auth()->user()->refferal_link }}',
                        username: '{{ Auth::user()->username }}',
                        copyToClipboard(text) {
                            if (!navigator.clipboard) {
                                return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                            }
                            navigator.clipboard.writeText(text)
                                .then(() => {
                                    Swal.fire({
                                        title: '',
                                        text: 'Copied',
                                        icon: 'success'
                                    });
                                })
                        },
                    }">
                        <div class="text-center col-md-8 offset-md-2">
                            <h6>You can refer users by sharing your referral link:</h6>
                            <div class="mb-3 input-group">
                                <input type="text" value="{{ auth()->user()->refferal_link }}" readonly
                                    class="form-control" placeholder="Recipient's username"
                                    aria-label="Recipient's username" aria-describedby="button-addon2">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-clipboard-target="#key-02"
                                        data-bs-toggle="tooltip" data-bs-title="Copy to clipboard"
                                        x-on:click="copyToClipboard(url)">
                                        <i class="bi bi-clipboard fs-3"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <h4 class="mt-3 mb-0 h6">or your Referral ID</h4>
                                <h4 class="text-primary h2 d-inline"> {{ auth()->user()->username }}</h4>
                                <button class="px-0 clipboard btn btn-link" data-clipboard-target="#key-02"
                                    data-bs-toggle="tooltip" data-bs-title="Copy to clipboard"
                                    x-on:click="copyToClipboard(username)">
                                    <i class="bi bi-clipboard fs-3"></i>
                                </button>
                            </div>
                            @if ($parent)
                                <div class="mt-2 text-center">
                                    <i class="bi bi-person-up"></i>
                                    <span>Parent</span>
                                    <h4 class="m-0 h3">{{ $parent->name }}</h4>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 col-lg-12">
                            <hr>
                            <h4 class="text-left font-weight-bold h5">Your Referrals.</h4>
                            <div class="table-responsive">
                                <table class="table UserTable table-hover ">
                                    <thead>
                                        <tr>
                                            <th>Client name</th>
                                            <th>Ref. level</th>
                                            <th>Parent</th>
                                            <th>Client status</th>
                                            <th>Date registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {!! $refs->getdownlines($array, auth()->user()->id) !!}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
