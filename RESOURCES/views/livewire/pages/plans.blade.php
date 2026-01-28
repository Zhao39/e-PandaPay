<x-slot:header>
    <title>{{ $settings->site_name }} | {{ $page->title }}</title>
    <meta name="description" content="{{ $page->description }}">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{ $settings->site_name }} - {{ $page->title }}">
    <meta itemprop="description" content="{{ $page->description }}">
    <meta name="keywords" content="{{ $page->keywords }}">
</x-slot:header>
<div>
    <section class="bg-half bg-light d-table w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="text-center col-lg-12">
                    <div class="page-next-level">
                        <h4 class="title">
                            {{ $contents->firstWhere('ref_key', 'vr6Xw0')->title }}
                        </h4>
                        @if ($page->show_breadcrumbs)
                            <div class="page-next">
                                <nav aria-label="breadcrumb" class="d-inline-block">
                                    <ul class="mb-0 bg-white rounded shadow breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="/">{{ $settings->site_name }}</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Plans</li>
                                    </ul>
                                </nav>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container">
            <div class="row align-items-center">
                @foreach ($plans as $plan)
                    <div class="pt-2 mt-4 col-lg-4 col-md-6" wire:key='{{ $plan->id }}'>
                        <div class="p-4 border-0 rounded-md shadow card pricing-rates business-rate">
                            <div class="p-0 card-body">
                                <span class="px-4 py-2 mb-0 rounded-lg d-inline-block bg-soft-primary h6 text-primary">
                                    {{ $plan->name }}
                                </span>
                                <h2 class="mt-3 mb-0 font-weight-bold">
                                    {{ $settings->currency }}{{ $plan->price }}
                                </h2>
                                <p class="text-muted">{{ $plan->duration }}</p>
                                <ul class="pt-3 list-unstyled border-top">
                                    <li class="mb-0 h6 text-muted">
                                        <span class="mr-2 text-primary h5">
                                            <i class="align-middle uil uil-check-circle"></i>
                                        </span>
                                        Minimum Deposit
                                        {{ $settings->currency }}{{ $plan->min_price }}
                                    </li>
                                    <li class="mb-0 h6 text-muted">
                                        <span class="mr-2 text-primary h5">
                                            <i class="align-middle uil uil-check-circle"></i>
                                        </span>
                                        Returns {{ $plan->max_return }} %
                                    </li>
                                    <li class="mb-0 h6 text-muted">
                                        <span class="mr-2 text-primary h5">
                                            <i class="align-middle uil uil-check-circle"></i>
                                        </span>{{ $settings->currency }}{{ $plan->bonus }}
                                        Bonus
                                    </li>
                                </ul>
                                <div class="mt-4">
                                    <a href="{{ route('login') }}" class="btn btn-block btn-primary">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                @endforeach
            </div>
        </div>
    </section>
</div>
