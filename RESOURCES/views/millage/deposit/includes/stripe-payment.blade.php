@assets
    @push('styles')
        <link rel="stylesheet" href="{{ asset('dash/css/stripeglobal.css') }}">
        <link rel="stylesheet" href="{{ asset('dash/css/stripenormalize.css') }}">
    @endpush
@endassets
<div class="py-5 text-center">
    <form id="payment-form" class="sr-payment-form">
        @csrf
        <div class="mb-3 sr-combo-inputs-row">
            <div class="sr-input sr-card-element" id="card-element">
            </div>
        </div>

        <button id="stripesubmit" class="button">
            <div class="spinner d-none" id="spinner"></div>
            <span id="buttontext" class="">Pay</span>
        </button>
    </form>

    <div class="hidden row" id="stripesuccess">
        <div class="col-lg-12">
            <span>Payment Completed, redirecting.....</span>
        </div>
    </div>

    <form id="selectform" method="POST" action="javascript:void(0)">
        @csrf
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="method" value="{{ $method->name . '(Stripe)' }}">
    </form>
</div>
@script
    @push('scripts')
        <script type="text/javascript">
            var stripe = Stripe("{{ $settings->s_p_k }}");
            var elements = stripe.elements();
            var style = {
                base: {
                    color: "{{ $settings->website_theme }}",
                }
            };
            const paybtn = document.querySelector('#stripesubmit');
            paybtn.disabled = true;

            var card = elements.create("card", {
                style: style
            });

            card.mount("#card-element");

            function checkcardforerrors() {
                card.on('change', function(event) {
                    if (event.error) {
                        Swal.fire({
                            title: 'Error!',
                            text: event.error.message,
                            icon: 'error',
                        });
                        paybtn.disabled = true;
                    } else {
                        paybtn.disabled = false;
                    }
                });
            }
            checkcardforerrors();

            var form = document.getElementById('payment-form');

            form.addEventListener('submit', function(ev) {
                paybtn.disabled = true;
                ev.preventDefault();
                checkcardforerrors();
                document.getElementById('spinner').classList.remove('d-none');
                document.getElementById('buttontext').classList.add('d-none');

                var clientSecret = "{{ $client_secret }}";
                stripe.confirmCardPayment(clientSecret, {
                    payment_method: {
                        card: card,
                        billing_details: {
                            name: "{{ auth()->user()->name }}"
                        }
                    }
                }).then(function(result) {
                    if (result.error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error processing your payment, Please try depositing again.',
                            icon: 'error',
                        });
                        paybtn.disabled = false;
                        document.getElementById('spinner').classList.add('d-none');
                        document.getElementById('buttontext').classList.remove(
                            'd-none');
                        console.log(result.error.message);
                    } else {
                        // The payment has been processed!
                        if (result.paymentIntent.status === 'succeeded') {
                            $.ajax({
                                url: "{{ route('user.deposit.savestripepayment') }}",
                                type: 'POST',
                                data: $('#selectform').serialize(),
                                success: function(data) {
                                    Swal.fire({
                                        title: 'Success!',
                                        text: data.success,
                                        icon: 'success',
                                    });
                                    setTimeout(function() {
                                        window.location.replace(
                                            "{{ route('user.deposit.make') }}");
                                    }, 3000);
                                },
                                error: function(error) {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error Submiting Payment Data',
                                        icon: 'error',
                                        confirmButtonText: 'Okay'
                                    });
                                    console.log(error);
                                },
                            });
                        }
                    }
                });

            });
        </script>
    @endpush
@endscript
