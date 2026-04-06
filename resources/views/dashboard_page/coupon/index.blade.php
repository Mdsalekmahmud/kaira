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
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Min Amount</th>
                                <th>Expired At</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td style="color: black">{{ $coupon->code }}</td>
                                    <td style="color: black">{{ $coupon->type }}</td>
                                    <td style="color: black">{{ $coupon->value }}</td>
                                    <td style="color: black">{{ $coupon->min_amount }}</td>
                                    <td style="color: black">{{ $coupon->expired_at }}</td>
                                    <td style="color: black">{{ $coupon->status }}</td>

                                    <td>
                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-light-success">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('coupon.destroy', $coupon->id) }}"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

</x-dashboard>
