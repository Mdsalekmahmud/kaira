<x-app>

    <div class="untree_co-section before-footer-section">
        <div class="container">
            <div class="row mb-5">

                <div class="site-blocks-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="product-thumbnail">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quantity">Quantity</th>
                                <th class="product-total">Total</th>
                                <th class="product-remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $item)
                                <tr>
                                    <td class="product-thumbnail">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="Image"
                                            class="img-fluid">
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black">{{ $item->name }}</h2>
                                    </td>
                                    <td>{{ $item->price }}</td>
                                    <td>
                                        <form method="POST" id="cart-form-{{ $item->rowId }}"
                                            action="{{ route('cartupdate', $item->rowId) }}" class="cart-form">
                                            @csrf
                                            <input type="hidden" name="rowId" value="{{ $item->rowId }}">

                                            <div class="input-group mb-3 d-flex align-items-center quantity-container"
                                                style="max-width: 120px;">

                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-black decrease"
                                                        data-form-id="cart-form-{{ $item->rowId }}"
                                                        type="button">&minus;</button>
                                                </div>

                                                <input type="text" class="form-control text-center quantity-amount"
                                                    value="{{ $item->qty }}" min="1" name="qty" readonly>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-black increase"
                                                        data-form-id="cart-form-{{ $item->rowId }}"
                                                        type="button">&plus;</button>
                                                </div>
                                            </div>
                                        </form>


                                    </td>
                                    <td>${{ $item->price * $item->qty }}</td>
                                    <form method="GET" action="{{ route('cartdestroy', $item->rowId) }}">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="rowId" value="{{ $item->rowId }}">
                                        <td><button type="submit"
                                                style="border: none; background:none; btn btn-black btn-sm">X</button>
                                        </td>
                                    </form>
                                </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row mb-5">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <button class="btn btn-black btn-sm btn-block">Update Cart</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Coupon</label>
                            <p>Enter your coupon code if you have one.</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-black">Apply Coupon</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-black">Subtotal</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">${{ Cart::subtotal() }}</strong>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-black">Tax</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">${{ number_format(TaxService::calculate(),2) }}
                                    </strong>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Total</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong
                                        class="text-black">${{ number_format(TaxService::totalAmount(), 2) }}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <a class="btn btn-black btn-lg py-3 btn-block"
                                        href="{{ route('checkout') }}">Proceed To Checkout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.increase').forEach(button => {
                button.addEventListener('click', function() {

                    const formId = this.dataset.formId; // ✅ get ID
                    const form = document.getElementById(formId);
                    const input = form.querySelector('.quantity-amount');

                    let qty = parseInt(input.value) || 1;
                    input.value = qty;
                    form.submit();
                });
            });

            document.querySelectorAll('.decrease').forEach(button => {
                button.addEventListener('click', function() {

                    const formId = this.dataset.formId;
                    const form = document.getElementById(formId);
                    const input = form.querySelector('.quantity-amount');

                    let qty = parseInt(input.value) || 1;


                    if (qty > 0) {
                        input.value = qty;
                        console.log('Submitting:', formId);
                        form.submit();
                    }
                });
            });

        });
    </script>







</x-app>
