<x-slot:title>
    Cron Job
</x-slot:title>
<div>
    <x-breadcrumbs title="Cron Job">
        <li class="nav-item">
            <a href="{{ route('admin.platform.index') }}" @if ($settings->spa_mode) wire:navigate @endif>
                Platform Administration
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Cron Job</a>
        </li>
    </x-breadcrumbs>
    <div class="row">
        <div class="col-lg-8 offset-lg-2" x-data="{
            copied: false,
            path: '{{ $path }}',
            copyToClipboard(text) {
                if (!navigator.clipboard) {
                    return alert('Copying to clipboard only works on secure sites viewed through a modern browser.')
                }
                navigator.clipboard.writeText(text)
                    .then(() => {
                        this.copied = true
                        setTimeout(() => {
                            this.copied = false
                        }, 3000)
                    })
            },
        }">
            <div class="card">
                <div class="card-body">
                    <h5 class="font-weight-bold">
                        Cronjob allow you to automate certain commands or scripts on your site.
                    </h5>
                    <div>
                        <div class="mb-4 input-group">
                            <input type="text" class="form-control" value="{{ $path }}" readonly>
                            <div class="input-group-append">
                                <button class="btn"
                                    x-bind:class="copied ? 'btn-outline-success' : 'btn-outline-secondary'"
                                    x-on:click="copyToClipboard(path)" type="button" id="button-addon2">
                                    <i class="bi bi-copy" x-show="!copied"></i>
                                    <i class="bi bi-check-lg" x-show="copied" style="display: none"
                                        x-transition.scale.origin.right.opacity></i>
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <strong>
                                To run the cronjob, follow the instructions below.
                            </strong>
                        </div>
                        <hr>
                        <h3 class="font-weight-bold">Setting up the Cronjob</h3>
                        <ol type="1">
                            <li>
                                Login to your server
                            </li>
                            <li>Search and open the cron option on your server</li>
                            <li>
                                Add the above command to the crontab file and save it.
                                {{-- <strong>Note:</strong>
                                change the username and "path-to-your-project" to your server username and the actual
                                path to your project respectively. --}}
                            </li>
                            <li>The cronjob will now run at minute you entered and execute the specified command.</li>
                        </ol>
                        <hr>
                        <p>
                            You can learn more about how to set up cronjob from
                            <a href="https://app.getonlinetrader.pro/doc/Cron-Job" target="_blank">our documentation</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
