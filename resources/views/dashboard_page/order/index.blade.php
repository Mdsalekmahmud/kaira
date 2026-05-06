<x-dashboard>
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>DataTable</h3>
                    <p class="text-subtitle text-muted">For user to check they list</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">DataTable</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    Simple Datatable
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Product INFO</th>
                                <th>total_amount</th>
                                <th>status</th>
                                <th>payment_method</th>
                                <th>payment_status</th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                {{-- @dd($order->products) --}}
                                <tr>
                                    <td style="width: 250px;">

                                        
                                      @if($order->first_product)
                                            <div style="font-size: 16px; color: black;">
                                                <img src="{{ asset('storage/' . $order->first_product->image) }}"
                                                    alt="{{ $order->first_product->name }}" width="70">
                                                {{ $order->first_product->name }}
                                            </div>
                                        @endif

                                    </td>
                                    <td style="color: black">{{ $order->total_amount }}</td>
                                    <td style="color: black">{{ $order->status }}</td>
                                    <td style="color: black">{{ $order->payment_method }}</td>
                                    <td style="color: black">{{ $order->payment_status }}</td>
                                    {{-- <td style="color: black">{{ $order->transaction_id }}</td> --}}




                                    <td> <a href="{{ route('order.edit', $order->id) }}"
                                            class="btn btn-light-success">edit</a>
                                        <form method="POST" action="{{ route('order.destroy', $order->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
</x-dashboard>
