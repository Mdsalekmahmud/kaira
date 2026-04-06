<x-app>
    <div class="container my-5">

        <!-- Profile Section -->
        <div class="card mb-4 shadow-sm" style="border-radius:14px; border:none;">
            <div class="card-body d-flex align-items-center">

                <div
                    style="
                width:90px;
                height:90px;
                border-radius:50%;
                background:#3b5d50;
                color:white;
                display:flex;
                align-items:center;
                justify-content:center;
                font-size:32px;
                font-weight:bold;">
                </div>

                <div class="ms-4">
                    <h4 class="mb-1">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h4>
                    <p class="mb-0 text-muted">{{ auth()->user()->email }}</p>
                </div>

            </div>
        </div>

        <!-- Orders Section -->
        <div class="card shadow-sm" style="border-radius:14px; border:none;">
            <div class="card-header text-white" style="background:#3b5d50; border-radius:14px 14px 0 0;">
                <h5 class="mb-0">
                    <i class="fa-solid fa-couch me-2"></i>
                    My Orders
                </h5>
            </div>

            <div class="card-body">

                <!-- Single Order -->
                <div class="mb-4 p-3" style="border:1px solid #eaeaea; border-radius:10px;">


                    @forelse ($orders as $order)
                       
                        <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
                            <div>
                                <strong>Order #{{ $order->id }}</strong><br>
                                <small class="text-muted">{{$order->created_at->format('d M Y')}}</small>
                            </div>

                            <span class="badge px-3 py-2" style="background:#ffc107; color:#000;">
                                Pending
                            </span>
                        </div>
                        @forelse ($order->products as $product)
                            <div class="row align-items-center mb-3">
                                <div class="col-md-2 col-4">
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid"
                                        style="border-radius:8px; height:70px; object-fit:cover;">
                                </div>

                                <div class="col-md-4 col-8">
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">
                                        Qty: {{ $product->pivot->quantity }}
                                    </small>
                                </div>

                                <div class="col-md-3 text-md-center">
                                    ৳{{ $product->pivot->price }}
                                </div>

                                <div class="col-md-3 text-md-end fw-bold">
                                    ৳{{ $product->pivot->total }}
                                </div>
                            </div>

                        @empty
                            <p class="text-muted">No products in this order.</p>
                        @endforelse

                        <hr>

                        <div class="text-end mt-3 border-bottom">
                            <strong>Total:</strong>
                            <span style="font-size:18px; color:#8b5e3c;">
                                ৳{{ $order->total_amount }}
                            </span>
                        </div>

                    @empty
                        <p class="text-center text-muted">You have no orders yet.</p>
                    @endforelse




                </div>

            </div>
        </div>

    </div>


</x-app>
