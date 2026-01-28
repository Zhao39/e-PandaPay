@use('\Illuminate\Support\Str', 'Str')
<x-slot:header>
    <title>{{ $settings->site_name }} | {{ $settings->site_title }}</title>
    <meta name="description" content="{{ $page->description }}">
    <meta itemprop="name" content="{{ $settings->site_name }} - {{ $page->title }}">
    <meta itemprop="description" content="{{ $page->description }}">
    <meta name="keywords" content="{{ $page->keywords }}">
</x-slot:header>
<x-slot:styles>
    <link rel="stylesheet" href="{{ asset('dash/css/home2.css') }}" rel="preload">
</x-slot:styles>
<div>
    <section class="py-100 bg-primary" style="position: relative; overflow: hidden;">
        <div style="
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            width: 100%; height: 100%;
            z-index: 0;
            ">
            <video
                class="object-fit-cover"
                style="object-fit: cover; width: 100vw; height: 100%; min-height: 375px;"
                src="{{ asset('storage/media/home.mp4') }}"
                poster="{{ asset('storage/media/home_fallback.jpg') }}"
                autoplay
                muted
                loop
                playsinline
            >
                <img src="{{ asset('storage/media/home-fallback.jpg') }}" alt="Background" style="width:100%;height:100%;object-fit:cover">
            </video>
            <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(21,44,95,0.75);">
                <!-- Optional: Color overlay for better text contrast -->
            </div>
            <div style="position: absolute; top:0; left:0; right:0; bottom:0; background: url('data:image/svg+xml,<svg xmlns=&quot;http://www.w3.org/2000/svg&quot; viewBox=&quot;0 0 100 100&quot;><defs><pattern id=&quot;grain&quot; width=&quot;100&quot; height=&quot;100&quot; patternUnits=&quot;userSpaceOnUse&quot;><circle cx=&quot;50&quot; cy=&quot;50&quot; r=&quot;1&quot; fill=&quot;%23ffffff&quot; opacity=&quot;0.1&quot;/></pattern></defs><rect width=&quot;100&quot; height=&quot;100&quot; fill=&quot;url(%23grain)&quot;/></svg>'); pointer-events:none;"></div>
        </div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row">
                <div class="col-lg-6">
                    <span class="text-white text-big inter-semibold line-height-1">
                        {{ $contents->firstWhere('ref_key', 'Mnag31')->title }}
                    </span>
                    <div class="mt-4">
                        <p class="mb-3 text-white">
                            {{ $contents->firstWhere('ref_key', 'Mnag31')->description }}
                        </p>
                        <a href="{{ route('register') }}" class="text-white btn glass-button">
                            Create Your Account
                            <i class="bi bi-arrow-right"></i>
                        </a>
                        &nbsp;
                        <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Login</a>
                    </div>
                    <div class="text-white text-xs mt-4">
                        Bank-level security at your finger tips
                    </div>
                </div>
                <div class="mt-5 text-center col-lg-6 mt-lg-0">
                    <!-- illustration, can be omitted as bg video is present -->
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-[#eeeeee]">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain)\"/></svg></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="border" style="border-color: rgba(255,255,255,0.3) !important;"></div>
                        <p class="inter-bold text-primary">Why Us</p>
                        <div></div>
                    </div>
                    <h1 class="text-center inter-bold line-height-1 glass-text">
                        {{ $contents->firstWhere('ref_key', 'J23T0Y')->title }}</h1>
                    <h5 class="text-center glass-text-muted">{{ $contents->firstWhere('ref_key', 'J23T0Y')->description }}</h5>
                </div>
            </div>
            <div class="mt-5 row">
                <div class="flex mt-3 col-lg-3" style="display:flex">
                    <div class="glass-card p-4">
                        <div class="card-body">
                            <i class="text-primary bi bi-shield-check" style="font-size: 40px;"></i>
                            <h5 class="inter-bold">{{ $contents->firstWhere('ref_key', '9HOR1z')->title }}</h5>
                            <p class="text-muted">
                                {{ $contents->firstWhere('ref_key', '9HOR1z')->description }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex mt-3 col-lg-3" style="display:flex">
                    <div class="glass-card p-4">
                        <div class="card-body">
                            <i class="text-primary bi bi-graph-up-arrow" style="font-size: 40px;"></i>
                            <h5 class="inter-bold">{{ $contents->firstWhere('ref_key', 'Vg6Gy7')->title }}</h5>
                            <p class="text-muted">
                                {{ $contents->firstWhere('ref_key', 'Vg6Gy7')->description }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex mt-3 col-lg-3" style="display:flex">
                    <div class="glass-card p-4">
                        <div class="card-body">
                            <i class="text-primary bi bi-lightning" style="font-size: 40px;"></i>
                            <h5 class="inter-bold">{{ $contents->firstWhere('ref_key', 'YYqKx3')->title }}</h5>
                            <p class="text-muted">
                                {{ $contents->firstWhere('ref_key', 'YYqKx3')->description }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex mt-3 col-lg-3" style="display:flex">
                    <div class="glass-card p-4">
                        <div class="card-body">
                            <i class="text-primary bi bi-chat-left-text" style="font-size: 40px;"></i>
                            <h5 class="inter-bold"> {{ $contents->firstWhere('ref_key', 'xEWMho')->title }}</h5>
                            <p class="text-muted">
                                {{ $contents->firstWhere('ref_key', 'xEWMho')->description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="mt-5 mb-5 row">
                <div class="mt-5 col-lg-6">
                    @if (Str::endsWith($contents->firstWhere('ref_key', '9SOtK1')->img_path, 'mp4'))
                        <video src="{{ asset('storage/' . $contents->firstWhere('ref_key', '9SOtK1')->img_path) }}"
                            class="mx-auto roundedd img-fluid d-block" width="100%" height="100%" autoplay muted loop
                            playsinline></video>
                    @else
                        <img src="{{ asset('storage/' . $contents->firstWhere('ref_key', '9SOtK1')->img_path) }}"
                            class="img-fluid " alt="">
                    @endif
                </div>
                <div class="mt-5 col-lg-6">
                    <h2 class="inter-bold glass-text"> {{ $contents->firstWhere('ref_key', '9SOtK1')->title }}</h2>
                    <p class="glass-text-muted">
                        {{ $contents->firstWhere('ref_key', '9SOtK1')->description }}
                    </p>
                    <a href="{{ url('/about') }}" class="mt-3 btn btn-primary">
                        Find Out More
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="mt-10 row">
                <div class="mt-5 col-lg-6">
                    <h2 class="inter-bold glass-text"> {{ $contents->firstWhere('ref_key', '5Vg32I')->title }}</h2>
                    <p class="glass-text-muted">
                        {{ $contents->firstWhere('ref_key', '5Vg32I')->description }}
                    </p>
                    <a href="{{ url('/register') }}" class="mt-3 btn btn-primary">
                        Try now
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div class="mt-5 col-lg-6">
                    @if (Str::endsWith($contents->firstWhere('ref_key', '5Vg32I')->img_path, 'mp4'))
                        <video src="{{ asset('storage/' . $contents->firstWhere('ref_key', '5Vg32I')->img_path) }}"
                            class="mx-auto roundedd img-fluid d-block" width="100%" height="100%" autoplay muted
                            loop playsinline></video>
                    @else
                        <img src="{{ asset('storage/' . $contents->firstWhere('ref_key', '5Vg32I')->img_path) }}"
                            class="img-fluid w-100" alt="">
                    @endif
                </div>
            </div> --}}
        </div>
    </section>
    <section class="py-5 bg-primary">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain2\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain2)\"/></svg></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row mb-5">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2 class="inter-bold mb-2 text-white">How It Works</h2>
                    <p class="inter-normal text-white mb-4">Get started in three simple steps.</p>
                    <button type="button" class="btn glass-button btn-sm disabled" style="pointer-events:none;">
                        <i class="bi bi-play-circle"></i>
                        <span style="margin-left: 5px;">2-minute walkthrough <span class="badge rounded-pill bg-secondary" style="font-size: 10px;">Coming Soon</span></span>
                    </button>
                </div>
            </div>
            <div class="row text-center">
                <div class="flex col-md-4 mb-4" style="display:flex">
                    <div class="glass-card p-4 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-white" style="width:72px;height:72px;font-size:2.2rem;color:#3b32cc;margin: 0 auto 1rem;">
                                <i class="bi bi-person-plus"></i>
                            </span>
                            <h5 class="inter-bold mb-2 text-white">1. Create Your Account</h5>
                            <p class="text-white px-2">Sign up in seconds to get started with your journey. All you need is an email address.</p>
                        </div>
                    </div>
                </div>
                <div class="flex col-md-4 mb-4" style="display:flex">
                    <div class="glass-card p-4 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-white" style="width:72px;height:72px;font-size:2.2rem;color:#e11d48;margin: 0 auto 1rem;">
                                <i class="bi bi-cash-coin"></i>
                            </span>
                            <h5 class="inter-bold mb-2 text-white">2. Fund &amp; Choose Strategy</h5>
                            <p class="text-white px-2">Add funds easily and select the strategy that matches your goals.</p>
                        </div>
                    </div>
                </div>
                <div class="flex col-md-4 mb-4" style="display:flex">
                    <div class="glass-card p-4 text-center">
                        <div class="card-body">
                            <span class="d-inline-flex justify-content-center align-items-center rounded-circle bg-white" style="width:72px;height:72px;font-size:2.2rem;color:#059669;margin: 0 auto 1rem;">
                                <i class="bi bi-graph-up-arrow"></i>
                            </span>
                            <h5 class="inter-bold mb-2 text-white">3. Track in Daily Results</h5>
                            <p class="text-white px-2">Monitor your progress live and stay updated every day through your dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="py-5 bg-[#eeeeee]">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain3\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain3)\"/></svg></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row mb-4">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <h2 class="inter-bold mb-2 glass-text">Platform Snapshot</h2>
                    <p class="inter-normal glass-text-muted">Live platform metrics at a glance.</p>
                </div>
            </div>
            <div class="row text-center justify-content-center g-4" id="metrics-snapshot">
                <div class="col-6 col-md-3">
                    <div class="glass-metric py-4 px-2 text-center">
                        <span class="d-inline-block mb-2" style="color:#6366f1;font-size:2.2rem;">
                            <i class="bi bi-bar-chart-line"></i>
                        </span>
                        <h3 class="counter inter-bold mb-1 glass-text" data-target="48520000">$0</h3>
                        <p class="glass-text-muted mb-0 inter-normal" style="font-size:1rem;">Trading Volume</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-metric py-4 px-2 text-center">
                        <span class="d-inline-block mb-2" style="color:#16a34a;font-size:2.2rem;">
                            <i class="bi bi-stack"></i>
                        </span>
                        <h3 class="counter inter-bold mb-1 glass-text" data-target="163500">0</h3>
                        <p class="glass-text-muted mb-0 inter-normal" style="font-size:1rem;">Orders Filled</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-metric py-4 px-2 text-center">
                        <span class="d-inline-block mb-2" style="color:#f59e42;font-size:2.2rem;">
                            <i class="bi bi-clock-history"></i>
                        </span>
                        <h3 class="counter inter-bold mb-1 glass-text" data-target="99.98">0%</h3>
                        <p class="glass-text-muted mb-0 inter-normal" style="font-size:1rem;">Uptime</p>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="glass-metric py-4 px-2 text-center">
                        <span class="d-inline-block mb-2" style="color:#e11d48;font-size:2.2rem;">
                            <i class="bi bi-lightning-charge"></i>
                        </span>
                        <h3 class="counter inter-bold mb-1 glass-text" data-target="230">0 ms</h3>
                        <p class="glass-text-muted mb-0 inter-normal" style="font-size:1rem;">Median Exec Time</p>
                    </div>
                </div>
            </div>
        </div>
        <script>
        // Animate counters when section is in viewport
        document.addEventListener('DOMContentLoaded', function() {
            function animateCounter(counter, target, suffix = '', isCurrency = false) {
                let start = 0;
                let duration = 1500;
                let startTimestamp = null;
                let decPlaces = (target % 1 > 0) ? 2 : 0;

                function step(timestamp) {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    let val = Math.floor(progress * (target - start) + start);

                    if (decPlaces) {
                        val = (progress * (target - start) + start).toFixed(decPlaces);
                    }
                    if (isCurrency) {
                        counter.innerText = '$' + Number(val).toLocaleString();
                    } else if (suffix==='%' && !decPlaces) {
                        counter.innerText = val + suffix;
                    } else if (suffix==='ms') {
                        counter.innerText = val + ' ms';
                    } else {
                        counter.innerText = Number(val).toLocaleString() + suffix;
                    }
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                }
                window.requestAnimationFrame(step);
            }

            let triggered = false;
            function checkAndAnimate() {
                const metrics = document.getElementById('metrics-snapshot');
                if (metrics && !triggered) {
                    const rect = metrics.getBoundingClientRect();
                    const inView = rect.top < window.innerHeight && rect.bottom > 0;
                    if (inView) {
                        triggered = true;
                        metrics.querySelectorAll('.counter').forEach(function(el) {
                            const target = +el.getAttribute('data-target');
                            let suffix = '';
                            let isCurrency = false;
                            if (el.textContent.indexOf('$') !== -1) isCurrency = true;
                            if (el.textContent.indexOf('%') !== -1) suffix = '%';
                            if (el.textContent.indexOf('ms') !== -1) suffix = 'ms';
                            animateCounter(el, target, suffix, isCurrency);
                        });
                    }
                }
            }

            window.addEventListener('scroll', checkAndAnimate, { passive: true });
            checkAndAnimate();
        });
        </script>
    </section>

    <section class="section py-5 bg-light" id="security-compliance">
        <div class="container">
            <h2 class="mb-4 inter-bold glass-text text-center">Security First</h2>
            <div class="row align-items-center">
                <!-- Left: Headline & Bullets -->
                <div class="col-md-6 mb-4 mb-md-0">
                    
                    <ul class="list-unstyled">
                        <li class="mb-2 d-flex align-items-center glass-text-muted" style="font-size:20px;">
                            <span class="mr-2 text-primary" style="font-size:1.2rem;">
                                <i class="text-primary bi bi-shield-check" style="font-size: 40px;"></i>
                            </span> 
                            Encryption
                        </li>
                        <li class="mb-2 d-flex align-items-center glass-text-muted" style="font-size:20px;">
                            <span class="mr-2 text-primary" style="font-size:1.2rem;">
                                <i class="text-primary bi bi-person" style="font-size: 40px;"></i>
                            </span>
                            Segregated Accounts
                        </li>
                        <li class="mb-2 d-flex align-items-center glass-text-muted" style="font-size:20px;">
                            <span class="mr-2 text-primary" style="font-size:1.2rem;">
                                <i class="text-primary bi bi-fingerprint" style="font-size: 40px;"></i>
                            </span>
                            2FA
                        </li>
                    </ul>
                </div>
                <!-- Right: Compliance Badges/Logos -->
                <div class="col-md-6 text-center">
                    <div class="d-flex justify-content-center align-items-center flex-wrap gap-3">
                        <!-- Placeholder badges/logos. Replace SVGs/images as needed -->
                        <div class="mx-3">
                            <img src="{{ asset('front_assets/images/SOC2.png') }}" alt="SOC 2" height="200" style="max-width:200px;" onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ab/SOC_2_logo.png/120px-SOC_2_logo.png';">
                            <div class="small mt-2 text-muted">SOC 2</div>
                        </div>
                        <div class="mx-3">
                            <img src="{{ asset('front_assets/images/ISO.webp') }}" alt="ISO 27001" height="200" style="max-width:200px;" onerror="this.onerror=null;this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/ISO_IEC_27001_Certification_Label.svg/120px-ISO_IEC_27001_Certification_Label.svg.png';">
                            <div class="small mt-2 text-muted">ISO 27001</div>
                        </div>
                        <!-- More placeholders as needed -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-primary">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain4\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain4)\"/></svg></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="pb-2 mb-4 text-center section-title">
                        <h2 class="inter-bold mb-2 text-white">Frequently Ask Questions</h2>
                        <p class="inter-normal text-muted">Faq description</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="pt-2 mt-4 col-lg-9">
                    <div class="faq-content">
                        <div class="accordion" id="accordionExample">
                            @foreach ($faqs as $item)
                                <div class="mb-2 glass-card">
                                    <a data-toggle="collapse" href="#collapse{{ $item->id }}"
                                        class="faq position-relative" aria-expanded="true"
                                        aria-controls="collapse{{ $item->id }}">
                                        <div class="p-3 card-header"
                                            id="heading{{ $item->id }}">
                                            <h6 class="mb-0 title text-white">{{ $item->question }}</h6>
                                        </div>
                                    </a>
                                    <div id="collapse{{ $item->id }}" class="collapse show"
                                        aria-labelledby="heading{{ $item->id }}" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <p class="mb-0 text-white faq-ans"> {{ $item->answer }} </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="py-5"
        style="background: url('{{ asset('front_assets/images/reviews-bg.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat">
        <div class="container">
            <div class="row">
                <div class="mb-5 col-lg-6 offset-lg-3">
                    <h2 class="text-center inter-bold"> {{ $contents->firstWhere('ref_key', 'SMsJr1')->title }}</h2>
                    <p class="text-center inter-normal">
                        {{ $contents->firstWhere('ref_key', 'SMsJr1')->description }}
                    </p>
                </div>
                @foreach ($testimones as $testimony)
                    <div class="mb-3 col-lg-4 col-md-6">
                        <div class="border-0 rounded-md shadow-md card bg-light">
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $testimony->picture) }}"
                                        class="w-25 rounded-pill" alt="">
                                </div>
                                <h5 class="inter-bold"> {{ $testimony->name }}</h5>
                                <p class="inter-regular-italic text-muted">
                                    "{{ $testimony->what_is_said }}"
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @if ($settings->show_plans_on_home_page)
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="mb-5 col-lg-6 offset-lg-3">
                        <h2 class="text-center inter-bold">
                            {{ $contents->firstWhere('ref_key', 'vr6Xw0')->title }}
                        </h2>
                        <p class="mt-0 text-center text-muted inter-normal">
                            {{ $contents->firstWhere('ref_key', 'vr6Xw0')->description }}
                        </p>
                    </div>
                    @foreach ($plans as $plan)
                        <div class="mt-4 col-lg-4 col-md-6" wire:key='{{ $plan->id }}'>
                            <div class="p-4 border-0 rounded-md shadow card pricing-rates business-rate">
                                <div class="p-0 card-body">
                                    <span
                                        class="px-4 py-2 mb-0 rounded-lg d-inline-block bg-soft-primary h6 text-primary">
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
                                        <a href="{{ route('register') }}" class="btn btn-block btn-primary">
                                            Get started
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    @endforeach
                </div>
            </div>
        </section>
    @endif --}}
    <section class="py-5 bg-[#eeeeee]">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grain5\" width=\"100\" height=\"100\" patternUnits=\"userSpaceOnUse\"><circle cx=\"50\" cy=\"50\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grain5)\"/></svg></div>
        <div class="container" style="position: relative; z-index: 1;">
            <div class="p-4 roundedd glass-panel p-lg-5">
                <div class="row align-items-end">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="text-center">
                            <h2 class="mb-1 inter-bold glass-text">
                                {{ $contents->firstWhere('ref_key', 'Mnag31')->title }}
                            </h2>
                            <p class="mb-3 inter-regular glass-text-muted">
                                {{ $contents->firstWhere('ref_key', 'Mnag31')->description }}
                            </p>
                            <div class="mt-4">
                                <a href="{{ route('register') }}" class="text-white btn btn-primary">
                                    Create Your Account
                                    <i class="bi bi-arrow-right"></i>
                                </a>
                                &nbsp;
                                <a href="{{ route('login') }}" class="btn btn-secondary ms-2">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
        <!--end container-->
    </section>
</div>
