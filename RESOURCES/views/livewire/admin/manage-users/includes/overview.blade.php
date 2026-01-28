<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-primary">
                <i class="fas fa-money-bill"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b> {{ Number::currency($user->account_bal, $settings->s_currency) }}</b>
                </h5>
                <small class="text-muted">Account Balance</small>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-success">
                <i class="fa fa-file-invoice-dollar"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b> {{ Number::currency($user->roi, $settings->s_currency) }}</b>
                </h5>
                <small class="text-muted">Total Profit</small>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-warning">
                <i class="fas fa-gift"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b> {{ Number::currency($user->bonus, $settings->s_currency) }}</b>
                </h5>
                <small class="text-muted">Total Bonus</small>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-info">
                <i class="fas fa-money-check-alt"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b> {{ Number::currency($user->ref_bonus, $settings->s_currency) }}</b>
                </h5>
                <small class="text-muted">Total Referral Bonus</small>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-primary">
                <i class="fas fa-retweet"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b>{{ count($this->referrals) }}</b>
                </h5>
                <small class="text-muted">Total Refferals</small>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-6 col-lg-4">
    <div class="p-3 card">
        <div class="d-flex align-items-center">
            <span class="mr-3 stamp stamp-md bg-danger">
                <i class="fas fa-user-plus"></i>
            </span>
            <div>
                <h5 class="mb-1">
                    <b>
                        @if ($this->referral)
                            <a href="{{ route('admin.users.singleUser', ['user' => $this->referral]) }}"
                                @if ($settings->spa_mode) wire:navigate @endif>
                                {{ $this->referral->name }}
                            </a>
                        @else
                            No One
                        @endif
                    </b>
                </h5>
                <small class="text-muted">Reffered By</small>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Fulname</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->name }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Username</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->username }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Email Address</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->email }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Phone Number</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->phone_number }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Country</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->country }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Date of Birth</h5>
                    <h4 class="m-0 font-weight-bolder">
                        {{ is_null($user->date_of_birth) ? 'Not Set' : $user->date_of_birth->format('d M, Y') }}</h4>
                </div>
                <div class="mb-3 col-lg-6">
                    <h5 class="m-0 font-weight-light">Created At</h5>
                    <h4 class="m-0 font-weight-bolder">{{ $user->created_at->toDayDateTimeString() }}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
