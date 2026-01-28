<div>
    @session('error')
        <div class="alert alert-dismissible fade show alert-danger" role="alert">
            <h5 class="alert-heading">Something went wrong</h5>
            <p>
                {{ $value }}
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    @session('success')
        <div class="alert alert-dismissible fade show alert-success" role="alert">
            <h5 class="alert-heading">Success</h5>
            <p>
                {{ $value }}
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
    @session('status')
        <div class="alert alert-dismissible fade show alert-info" role="alert">
            <p>
                {{ $value }}
            </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endsession
</div>
