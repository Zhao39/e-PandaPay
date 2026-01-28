<div>
    @if ($settings->home_theme == 'home2')
        <footer class="py-4 py-md-5 bg-light">
            {{-- <div>
                <div class="container pb-4 border-bottom border-dark">
                    <div class="row gy-3 align-items-sm-center">
                        <div class="col-12 col-sm-6">
                            <div class="footer-logo-wrapper text-start">
                                <a class="logo" href="/" @if ($settings->spa_mode) wire:navigate @endif>
                                    <img src="{{ asset('storage/' . $settings->logo) }}"
                                        width="{{ $settings->website_logo_size }}" alt="" class="img-fluid">
                                </a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="social-media-wrapper">
                                <ul class="gap-2 m-0 list-unstyled d-flex justify-content-sm-end">
                                    <li>
                                        <a href="#!" class="btn btn-outline-light bsb-btn-circle">
                                            <i class="bi bi-facebook text-lightx"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!" class="btn btn-outline-light bsb-btn-circle">
                                            <i class="bi bi-twitter-x"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#!" class="btn btn-outline-light bsb-btn-circle">
                                            <i class="bi bi-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Widgets Link - Bootstrap Brain Component -->
            <section class="py-4 py-md-5 py-xl-7 py-xxl-10">
                <div class="container">
                    <div class="row gy-4 gy-md-0">
                        <div class="col-lg-6">
                            <div class="link-wrapper">
                                <h5 class="footer-head">Useful Links</h5>
                                <ul class="list-unstyled footer-list">
                                    <li class="mb-2">
                                        <a href="{{ route('home.Terms') }}"
                                            @class(['text-foot text-dark'])
                                            <i class="mr-1 mdi mdi-chevron-right"></i>
                                            Terms Of Service
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('home.Privacy') }}"
                                            @class(['text-foot text-dark'])
                                            <i class="mr-1 mdi mdi-chevron-right"></i>
                                            Privacy Policy
                                        </a>
                                    </li>
                                    <li class="mb-2">
                                        <a href="{{ route('home.Risk') }}"
                                            @class(['text-foot text-dark'])
                                            <i class="mr-1 mdi mdi-chevron-right"></i>
                                            Risk Disclaimer
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="link-wrapper">
                                <h5 class="footer-head">Contact Us</h5>
                                <div class="mt-2">
                                    <h6 class="text-foot">
                                        <i class="mr-1 mdi mdi-home"> </i>
                                        Head Office
                                    </h6>
                                    <p>{{ $contents->firstWhere('ref_key', '52GPRA')->description }}
                                    </p>
                                    <h6><i class="mr-1 mdi mdi-email"> </i>Email Address</h6>
                                    <p>
                                        {{ $contents->firstWhere('ref_key', 'HLgyaQ')->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Copyright & Links - Bootstrap Brain Component -->
            <div>
                <div class="container pt-4 border-top border-dark">
                    <div class="row gy-3 align-items-lg-center">
                        <div class="order-1 col-12 col-lg-6 order-lg-0">
                            <div class="mb-1 copyright-wrapper d-block fs-7 text-start">
                                © Copyright {{ date('Y') }} {{ $settings->site_name }} All
                                Rights Reserved.
                            </div>
                        </div>
                        @if ($settings->use_terms)
                            <div class="col-12 col-lg-6">
                                <div class="link-wrapper">
                                    <ul
                                        class="gap-2 m-0 list-unstyled d-flex justify-content-centerX justify-content-lg-end gap-md-3">
                                        <li>
                                            <a href="{{ route('home.Terms') }}"
                                                class=" link-underline-opacity-0 link-opacity-75-hover link-offset-1 link-light fs-8 d-flex align-items-center pe-2 pe-md-3 bsb-sep bsb-sep-border">
                                                Terms & Privacy Policy
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </footer>
    @else
        <footer class="footer bg-primary">
            <div class="container">
                <div class="row">
                    <div class="pb-0 mb-0 col-lg-4 col-12 mb-md-4 pb-md-2">
                        <h5 class="text-light footer-head">{{ $settings->site_name }}</h5>
                        <p class="mt-4">{{ $settings->description }}</p>

                        <ul class="mt-4 mb-0 list-unstyled social-icon social">
                            <li class="list-inline-item">
                                <a href="{{ $settings->facebook_social_link }}" target="_blank" class="rounded">
                                    <i class="fea icon-sm fea-social bi bi-facebook"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ $settings->instagram_social_link }}" target="_blank" class="rounded">
                                    <i class="fea icon-sm fea-social bi bi-instagram"></i>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="{{ $settings->x_social_link }}" target="_blank" class="rounded">
                                    <i class="fea icon-sm fea-social bi bi-twitter"></i>
                                </a>
                            </li>
                        </ul>
                        <!--end icon-->
                    </div>
                    <!--end col-->
                    <div class="pt-2 mt-4 col-lg-4 col-md-4 mt-sm-0 pt-sm-0">
                        <h5 class="text-light footer-head">Useful Links</h5>
                        <ul class="mt-4 list-unstyled footer-list">
                            @foreach ($pages as $page)
                                @if ($page->name != 'Footer' && $page->name != 'Home' && $page->name != 'Auth' && $page->status == 'active')
                                    <li>
                                        <a href="{{ route('home.' . $page->name) }}" class="text-foot"
                                            @if ($settings->spa_mode) wire:navigate @endif>
                                            <i class="mr-1 mdi mdi-chevron-right"></i>
                                            {{ $page->link_name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <!--end col-->

                    <div class="pt-2 mt-4 col-lg-4 col-md-4 mt-sm-0 pt-sm-0">
                        <h5 class="text-light footer-head">Contact Details</h5>
                        <div class="mt-2">
                            <h6 class="text-foot"><i class="mr-1 mdi mdi-home"> </i>
                                Head Office</h6>
                            <p>{{ $contents->firstWhere('ref_key', '52GPRA')->description }}</p>
                            <h6><i class="mr-1 mdi mdi-email"> </i>Email Address</h6>
                            <p>{{ $contents->firstWhere('ref_key', 'HLgyaQ')->description }}</p>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </footer>

        <!--end footer-->
        <footer class="footer footer-bar bg-primary">
            <div class="container text-center">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="text-sm-left">
                            <p class="mb-0">
                                © Copyright {{ date('Y') }} {{ $settings->site_name }} All
                                Rights Reserved.
                            </p>
                        </div>
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end container-->
        </footer>
        <!--end footer-->
    @endif
    <!-- Footer Start -->
</div>
