<x-app>
    <div class="untree_co-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="border p-4 rounded" role="alert">
                        Returning customer? <a href="#">Click here</a> to login
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">

                        <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                        <div class="p-3 p-lg-5 border bg-white">
                            <form id="couponForm" method="POST" action="{{ route('coupon.apply') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <label class="text-black mb-3">
                                    Enter your coupon code if you have one
                                </label>

                                <div class="input-group w-75 couponcode-wrap">
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-control me-2"
                                        placeholder="Coupon Code">

                                    <button id="coupon_btn" class="btn btn-black btn-sm" type="submit">
                                        Apply
                                    </button>
                                </div>
                            </form>

                            <div id="coupon_msg"></div>


                        </div>

                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('orderStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Billing Details</h2>
                        <div class="p-3 p-lg-5 border bg-white">

                            <div class="form-group">
                                <label for="c_country" class="text-black">Country <span
                                        class="text-danger">*</span></label>
                                <select name="country" id="c_country" class="form-control">
                                    <option value="1">Select a country</option>
                                    <option value="2">bangladesh</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Ghana</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Bahrain</option>
                                    <option value="8">Colombia</option>
                                    <option value="9">Dominican Republic</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="c_fname" class="text-black">First Name <span
                                            class="text-danger">*</span></label>
                                    <input name="fname" type="text" class="form-control" id="c_fname"
                                        name="c_fname">
                                </div>
                                <div class="col-md-6">
                                    <label for="c_lname" class="text-black">Last Name <span
                                            class="text-danger">*</span></label>
                                    <input name="lname" type="text" class="form-control" id="c_lname"
                                        name="c_lname">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_companyname" class="text-black">Company Name </label>
                                    <input name="companyname" type="text" class="form-control" id="c_companyname"
                                        name="c_companyname">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="c_address" class="text-black">Address <span
                                            class="text-danger">*</span></label>
                                    <input name="address" type="text" class="form-control" id="c_address"
                                        name="c_address" placeholder="Street address">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <input name="Apartment" type="text" class="form-control"
                                    placeholder="Apartment, suite, unit etc. (optional)">
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="c_state_country" class="text-black">State / Country <span
                                            class="text-danger">*</span></label>
                                    <select name="state_country" id="state_country" class="form-control">
                                        <option value="">Select state/country</option>
                                        @foreach ($deliveryCrgs as $deliveryCrg)
                                            <option value="{{ $deliveryCrg->id }}"
                                                data-charge="{{ $deliveryCrg->delivery_charge }}">
                                                {{ $deliveryCrg->location }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="c_postal_zip" class="text-black">Posta / Zip <span
                                            class="text-danger">*</span></label>
                                    <input name="postal_zip" type="text" class="form-control" id="c_postal_zip"
                                        name="c_postal_zip">
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-6">
                                    <label for="c_email_address" class="text-black">Email Address <span
                                            class="text-danger">*</span></label>
                                    <input name="email_address" type="text" class="form-control"
                                        id="c_email_address" name="c_email_address">
                                </div>
                                <div class="col-md-6">
                                    <label for="c_phone" class="text-black">Phone <span
                                            class="text-danger">*</span></label>
                                    <input name="phone" type="text" class="form-control" id="c_phone"
                                        name="c_phone" placeholder="Phone Number">
                                </div>
                            </div>






                            <div class="form-group">
                                <label for="c_order_notes" class="text-black">Order Notes</label>
                                <textarea name="order_notes" id="c_order_notes" cols="30" rows="5" class="form-control"
                                    placeholder="Write your notes here..."></textarea>
                            </div>


                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black">Your Order</h2>
                                <div class="p-3 p-lg-5 border bg-white">
                                    <table class="table site-block-order-table mb-5">
                                        <thead>
                                            <th>Product</th>
                                            <th>Total</th>
                                        </thead>
                                        <tbody>
                                            @foreach (Cart::content() as $item)
                                                <tr>
                                                    <td>{{ $item->name }} <strong
                                                            class="mx-2">x</strong>{{ $item->qty }}</td>
                                                    <td>${{ $item->price }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Cart Subtotal</strong>
                                                </td>
                                                <td id="subtotal" class="text-black">${{ Cart::subtotal() }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Tax</strong></td>
                                                <td id="tax" class="text-black font-weight-bold">
                                                    <strong>${{ TaxService::calculate(), 2 }}</strong>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Discount</td>
                                                <td class="text-black font-weight-bold">
                                                    <strong>$<span id="discount">
                                                            {{ session('coupon.discount') ?? '0.00' }}
                                                        </span>
                                                    </strong>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Delivery
                                                        Charge</strong>
                                                </td>
                                                <td class="text-black font-weight-bold">
                                                    <strong>$<span id="delivery_charge">0.00</span></strong>
                                                    <input type="hidden" name="delivery_crg"
                                                        id="delivery_charge_input" value="0">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Order Total</strong>
                                                </td>
                                                <td class="text-black font-weight-bold">
                                                    <strong>$<span
                                                            id="order_total">{{ number_format($total, 2) }}</span></strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-black btn-lg py-3 btn-block"
                                onclick="window.location='thankyou.html'">Place Order</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

</x-app>


<script>
    let currentDiscount = parseFloat(
        document.getElementById('discount')?.innerText.replace(/[^0-9.]/g, '')
    ) || 0;



    function calculateTotal() {

        let subTotal = parseFloat(document.getElementById('subtotal')?.innerText.replace(/[^0-9.]/g, '')) || 0;
        let tax = parseFloat(document.getElementById('tax')?.innerText.replace(/[^0-9.]/g, '')) || 0;
        let delivery = parseFloat(document.getElementById('delivery_charge')?.innerText.replace(/[^0-9.]/g, '')) || 0;

        let finalTotal = subTotal + tax + delivery - currentDiscount;

        if (finalTotal < 0) finalTotal = 0;
        document.getElementById('order_total').innerText = finalTotal.toFixed(2);
    }



    document.getElementById('state_country')?.addEventListener('change', function() {

        let selectedOption = this.options[this.selectedIndex];
        let charge = parseFloat(selectedOption.getAttribute('data-charge')) || 0;

        document.getElementById('delivery_charge').innerText = charge.toFixed(2);

        let input = document.getElementById('delivery_charge_input');
        if (input) input.value = charge;

        calculateTotal();
    });


document.getElementById('couponForm')?.addEventListener('submit', function(e) {

    e.preventDefault();

    let code = document.getElementById('coupon_code').value.trim();
    let btn  = document.getElementById('coupon_btn');
    let msg  = document.getElementById('coupon_msg');

    // 🔥 যদি already applied থাকে → remove coupon
    if (btn && btn.getAttribute('data-applied') === 'true') {

        fetch("{{ route('coupon.remove') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        })
        .then(res => res.json())
        .then(data => {

            currentDiscount = 0;
            document.getElementById('discount').innerText = "$0.00";

            if (btn) {
                btn.innerText = "Apply";
                btn.removeAttribute('data-applied');
            }

            if (msg) msg.innerHTML = `<span style="color:red">Coupon Removed</span>`;

            calculateTotal();
        });

        return; 
    }

    // 🔥 Apply coupon
    fetch("{{ route('coupon.apply') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            coupon_code: code
        })
    })
    .then(res => res.json())
    .then(data => {

        if (!data.status) {

            if (msg) msg.innerHTML = `<span style="color:red">${data.message}</span>`;

            currentDiscount = 0;
            document.getElementById('discount').innerText = "0.00";

            if (btn) {
                btn.innerText = "Apply";
                btn.removeAttribute('data-applied');
            }

            calculateTotal();

        } else {

            currentDiscount = parseFloat(data.discount) || 0;

            document.getElementById('discount').innerText = currentDiscount.toFixed(2);

            if (btn) {
                btn.innerText = "Remove Coupon";
                btn.setAttribute('data-applied', 'true');
            }

            if (msg) msg.innerHTML = `<span style="color:green">${data.message}</span>`;

            calculateTotal();
        }

    })
    .catch(err => {
        console.log("Coupon Error:", err);
    });

});

    const initialCouponBtn = document.getElementById('coupon_btn');
    if (currentDiscount > 0 && initialCouponBtn) {
        initialCouponBtn.innerText = 'Remove Coupon';
        initialCouponBtn.setAttribute('data-applied', 'true');
    }

    calculateTotal();
</script>
