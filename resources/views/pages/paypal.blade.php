<x-app>
    <div class="row mb-5 justify-content-center">

        <div class="col-md-8">
            <h2 class="mb-3 text-black text-center">Paypal Payment</h2>
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

                <div class="border p-3 mb-3">
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
                </div>

                <div class="border p-3 mb-5">
                    <h3 class="h6 mb-0"><a class="d-block" data-bs-toggle="collapse" href="#collapsepaypal"
                            role="button" aria-expanded="false" aria-controls="collapsepaypal">Paypal</a></h3>

                    <div class="collapse" id="collapsepaypal">
                        <div class="py-2">
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
    </div>
    <script src="https://js.stripe.com/v3/"></script>
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
    </script>
</x-app>
