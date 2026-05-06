<x-app>
    {{-- <div class="row mb-5 justify-content-center">

        <div class="col-md-8">
            <h2 class="mb-3 text-black text-center">Stripe Payment</h2>
            <div class="p-3 p-lg-5 border bg-white">
                <table class="table site-block-order-table mb-5">
                    <thead>
                        <th>Product</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $item)
                            <tr>
                                <td>{{ $item->name }} <strong class="mx-2">x</strong>{{ $item->qty }}</td>
                                <td>${{ $item->price }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
                            <td class="text-black">${{ $order->sub_total }}</td>
                        </tr>
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Tax</strong></td>

                            <td class="text-black">${{ $order->tax }}</td>

                        </tr>
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Delivery Charge</strong></td>

                            <td class="text-black">${{ $order->delivery_crg }}</td>

                        </tr>
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Discount</strong></td>

                            <td class="text-black">${{ $order->discount }}</td>

                        </tr>
                        <tr>
                            <td class="text-black font-weight-bold"><strong>Order Total</strong></td>

                            <td class="text-black">${{ $order->total_amount }}</td>

                        </tr>
                    </tbody>
                </table>

                {{-- <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsebank" role="button"
                            aria-expanded="false" aria-controls="collapsebank">Direct Bank Transfer</a></h3>

                    <div class="collapse" id="collapsebank">
                        <div class="py-2">
                            <p class="mb-0">Make your payment directly into our bank account. Please
                                use your Order ID as the payment reference. Your order won’t be shipped
                                until the funds have cleared in our account.</p>
                        </div>
                    </div>
                </div>

                <div class="border p-3 mb-3">
                    <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsecheque"
                            role="button" aria-expanded="false" aria-controls="collapsecheque">Cheque Payment</a></h3>

                    <div class="collapse" id="collapsecheque">
                        <div class="py-2">
                            <p class="mb-0">Make your payment directly into our bank account. Please
                                use your Order ID as the payment reference. Your order won’t be shipped
                                until the funds have cleared in our account.</p>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="border p-3 mb-5">
                    <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsepaypal"
                            role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3> --}}

                    {{-- <div class="collapse" id="collapsepaypal"> --}}
                        {{-- <div class="py-2">
                            <form method="POST" action="{{route('stripe.payment')}}" id="stripe-form">
                                @csrf
                                <input type="hidden" name="price" value="200">
                                <input type="hidden" name="stripeToken" id="stripe-token">
                                <div class="m-3" id="card-element"></div>
                                <button class="btn btn-primary" onclick="createToken()" type="button">payment</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
   
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-black">Secure Payment</h2>
                    <p class="text-muted">Complete your order with Stripe secure checkout</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-bag me-2"></i>Order Summary</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    @foreach( $order->orderProducts as $item ) 
                                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                        <div>
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 100px;">
                                            <h6 class="mb-0">{{ $item->product->name }}</h6>
                                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                        </div>
                                        <span class="fw-semibold">${{ $item->total }}</span>
                                    </div>
                                    @endforeach
                                </div>
                              

                                <div class="price-breakdown">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Subtotal</span>
                                        <span class="fw-medium">${{ $order->sub_total }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Tax</span>
                                        <span class="fw-medium">${{ $order->tax }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Delivery</span>
                                        <span class="fw-medium">${{ $order->delivery_crg }}</span>
                                    </div>
                                    @if($order->discount > 0)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Discount</span>
                                        <span class="fw-medium text-success">-${{ $order->discount }}</span>
                                    </div>
                                    @endif
                                    <div class="border-top pt-3 mt-3">
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">Total</span>
                                            <span class="fw-bold fs-5 text-primary">${{ $order->total_amount }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h5 class="fw-bold mb-0"><i class="bi bi-credit-card me-2"></i>Payment Details</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="POST" action="{{route('stripe.payment')}}" id="stripe-form">
                                    @csrf
                                    <input type="hidden" name="price" value="{{ $order->total_amount }}">
                                    <input type="hidden" name="stripeToken" id="stripe-token">

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Card Number</label>
                                        <div class="stripe-card-element p-3 border rounded bg-white mb-3" id="card-number-element"></div>
                                        <div class="row g-2">
                                            <div class="col">
                                                <label class="form-label">Expiry Date</label>
                                                <div class="stripe-card-element p-3 border rounded bg-white" id="card-expiry-element"></div>
                                            </div>
                                            <div class="col">
                                                <label class="form-label">CVC</label>
                                                <div class="stripe-card-element p-3 border rounded bg-white" id="card-cvc-element"></div>
                                            </div>
                                        </div>
                                        <div class="form-text">Your card details are secured with Stripe</div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-shield-lock text-success"></i>
                                            <small class="text-muted">SSL Encrypted</small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/ba/Stripe_Logo%2C_revised_2016.svg" alt="Stripe" height="24">
                                        </div>
                                    </div>

                                    <button class="btn btn-primary w-100 py-3 fw-semibold" onclick="createToken()" type="button" id="pay-btn">
                                        <span class="btn-text"><i class="bi bi-lock me-2"></i>Pay ${{ $order->total_amount }}</span>
                                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                    </button>
                                </form>

                                <div class="alert alert-danger mt-3 d-none" id="card-errors" role="alert"></div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-muted small mb-2">Trusted by thousands of customers</p>
                            <div class="d-flex justify-content-center gap-3">
                                <div class="text-center">
                                    <i class="bi bi-shield-check fs-4 text-muted"></i>
                                    <small class="d-block text-muted">Secure</small>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-credit-card-2-front fs-4 text-muted"></i>
                                    <small class="d-block text-muted">All Cards</small>
                                </div>
                                <div class="text-center">
                                    <i class="bi bi-globe fs-4 text-muted"></i>
                                    <small class="d-block text-muted">Global</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stripe-card-element { min-height: 50px; transition: border-color 0.2s, box-shadow 0.2s; }
        .stripe-card-element:focus-within { border-color: #0d6efd; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); }
        .btn-primary { transition: all 0.3s ease; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3); }
        .btn-primary:disabled { transform: none; box-shadow: none; }
    </style>

    <script src="https://js.stripe.com/v3/"></script>
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();

        var style = {
            base: { color: '#32325d', fontFamily: '"Nunito", sans-serif', fontSmoothing: 'antialiased', fontSize: '16px', '::placeholder': { color: '#aab7c4' } },
            invalid: { color: '#fa755a', iconColor: '#fa755a' }
        };

        var cardNumber = elements.create('cardNumber', {style: style});
        var cardExpiry = elements.create('cardExpiry', {style: style});
        var cardCvc = elements.create('cardCvc', {style: style});

        cardNumber.mount('#card-number-element');
        cardExpiry.mount('#card-expiry-element');
        cardCvc.mount('#card-cvc-element');

        function setError(message) {
            var displayError = document.getElementById('card-errors');
            if (message) {
                displayError.textContent = message;
                displayError.classList.remove('d-none');
            } else {
                displayError.classList.add('d-none');
            }
        }

        cardNumber.on('change', function(event) { setError(event.error ? event.error.message : null); });
        cardExpiry.on('change', function(event) { setError(event.error ? event.error.message : null); });
        cardCvc.on('change', function(event) { setError(event.error ? event.error.message : null); });

        function createToken() {
            var btn = document.getElementById('pay-btn');
            var btnText = btn.querySelector('.btn-text');
            var spinner = btn.querySelector('.spinner-border');

            btn.disabled = true;
            btnText.classList.add('d-none');
            spinner.classList.remove('d-none');

            stripe.createToken(cardNumber).then(function(result) {
                if (result.error) {
                    setError(result.error.message);
                    btn.disabled = false;
                    btnText.classList.remove('d-none');
                    spinner.classList.add('d-none');
                } else {
                    document.getElementById('stripe-token').value = result.token.id;
                    document.getElementById('stripe-form').submit();
                }
            });
        }
    </script>


    {{-- <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var cardElement = elements.create('card');
        cardElement.mount('#card-element');

        function createToken() {
            stripe.createToken(cardElement).then(function(result) {
                console.log(result);
                if(result.token){
                    document.getElementById("stripe-token").value = result.token.id;
                    document.getElementById("stripe-form").submit();

                }
            });
        }
    </script> --}}
</x-app>
