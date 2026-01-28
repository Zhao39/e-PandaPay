@use('\Illuminate\Support\Number', 'Number')
@use('\Illuminate\Support\Str', 'Str')
<div>
    <div class="mb-5">
        <h1 class="m-0 h2">
            Contact our Support
        </h1>
        <p class="">
            You can contact our support team if you have any questions or problems. We will get back to you as soon as
            possible.
        </p>
    </div>
    <x-danger-alert />
    <x-success-alert />
    <div class="row">
        <div class="col-md-12" x-data="{ showForm: false }">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center" x-show="!showForm">
                        <div class="col-lg-4">
                            <input type="text" wire:model.live='search'
                                class="mb-4 border-2 form-control form-control-lg border-primary rounded-pill"
                                placeholder="Write a question or problem">
                        </div>
                    </div> <!-- / .row -->
                    <div class="row justify-content-center" x-show="!showForm">
                        <div class="text-center col-lg-8 col-xl-6 mb-7">
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-bg-gray-300"
                                wire:click.prevent="$set('search', 'How secure is your Payment method?')">
                                How
                                secure is
                                your
                                Payment method?</a>
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-bg-gray-300"
                                wire:click.prevent="$set('search', 'How secure is my data?')">How
                                secure is
                                my
                                data?</a>
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-bg-gray-300"
                                wire:click.prevent="$set('search', 'How can I upgrade my plan?')">How
                                can I
                                upgrade
                                my plan?</a>
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-bg-gray-300"
                                wire:click.prevent="$set('search', 'Can I invite others?')">Can I
                                invite
                                others?</a>
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-bg-gray-300"
                                wire:click.prevent="$set('search', 'Where do I find my Profit history?')">Where
                                do I
                                find my
                                Profit history?</a>
                            <a href="javascript: void(0);" class="px-3 py-2 m-2 mb-1 badge fs-5 text-danger"
                                wire:click.prevent="$set('search', '')">
                                Clear Selection</a>
                        </div>
                    </div>
                    <div class="row justify-content-center" x-show="!showForm">
                        <div class="col-lg-10 col-xxl-9">
                            <h2 class="text-center h3">Frequently Asked Questions</h2>
                            <div class="mb-6 row">
                                @forelse ($faqs as $faq)
                                    <div class="col-xl-6">
                                        <div class="mb-6 d-flex">
                                            <div class="text-primary me-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                    height="20" width="20">
                                                    <path
                                                        d="M12,0A12,12,0,1,0,24,12,12,12,0,0,0,12,0Zm0,19a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,12,19Zm1.6-6.08a1,1,0,0,0-.6.92,1,1,0,0,1-2,0,3,3,0,0,1,1.8-2.75A2,2,0,1,0,10,9.25a1,1,0,0,1-2,0,4,4,0,1,1,5.6,3.67Z"
                                                        style="fill: currentColor" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="mb-0 h4">{{ $faq->question }}</h3>
                                                <p class="mb-0">{{ $faq->answer }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-4 col-12">
                                        <h2 class="text-center h4">No FAQs at the moment.</h2>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div
                            class="px-4 pt-6 text-center rounded d-flex align-items-end bg-primary position-relative min-h-200px">
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <h4 class="text-white h3">Can't find what you're looking for?</h4>
                                <!-- Link -->
                                <a class="btn btn-lg btn-white link-primary" href="#"
                                    @click.prevent="showForm = true">Contact Us</a>
                            </div>
                            <img src="https://d33wubrfki0l68.cloudfront.net/3b17577d9510ca8e973cf1ec6558bb69279745e7/40233/assets/images/illustrations/faq-illustration.svg"
                                class="img-fluid ms-auto d-none d-md-block" alt="..." width="150"
                                height="150">
                        </div>
                    </div>
                    <div class="row" x-show="showForm" style="display: none">
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
                                <div class="mb-3">
                                    <label for="" class="mb-2">Subject</label>
                                    <x-form.input name="subject" wire:model='subject' required />
                                </div>
                                <div class="mb-3">
                                    <label for="" class="mb-2">Message</label>
                                    <textarea name="message" wire:model='message' placeholder="Enter your message hre" class="form-control " rows="5"
                                        required></textarea>
                                </div>
                                <div class="mb-3">
                                    <x-ui.button>
                                        <x-spinner wire:loading wire:target='send' />
                                        Send
                                    </x-ui.button>
                                    <x-ui.button class="btn-info" x-on:click="showForm = false">
                                        Cancel
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
