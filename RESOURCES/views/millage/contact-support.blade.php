@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <x-breadcrumbs title="24/7 Customer Support" :homeUrl="route('user.dashboard')">
        <li class="nav-item">
            <a href="#">Support</a>
        </li>
    </x-breadcrumbs>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="p-3 text-center col-12">
                            <h3 class="font-weight-bold">{{ $settings->site_name }} Support</h3>
                            <h4 class="h5">
                                For inquiries, suggestions or complains. Mail us or send us a message.
                            </h4>
                            <h1 class="mt-2 text-primary h4">
                                <a href="mailto:{{ $settings->contact_email }}">{{ $settings->contact_email }}</a>
                            </h1>
                        </div>
                        <div class="pb-3 col-md-8 offset-md-2">
                            <form wire:submit='send'>
                                <div class="form-group">
                                    <label for="">Subject</label>
                                    <x-form.input name="subject" wire:model='subject' required />
                                </div>
                                <div class="form-group">
                                    <label for="">Message</label>
                                    <textarea name="message" wire:model='message' placeholder="Enter your message hre" class="form-control " rows="5"
                                        required></textarea>
                                </div>
                                <div class="form-group">
                                    <x-ui.button class="btn-block">
                                        <x-spinner wire:loading wire:target='send' />
                                        Send
                                    </x-ui.button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
