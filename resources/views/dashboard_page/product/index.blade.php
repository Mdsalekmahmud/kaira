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
                                <th>ID</th>
                                <th>image</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>discription</th>
                                <th>s_discription</th>
                                <th>quantity</th>
                                <th>price</th>
                                <th>s_price</th>
                                <th>rating</th>
                                <th>action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>

                                        <img style="width:50px; height:50px;"
                                            src="{{ asset('storage/' . $product->image) }}" alt="">
                                    </td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->discription }}</td>
                                    <td>{{ $product->s_discription }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->s_price }}</td>
                                    <td>{{ $product->rating }}</td>

                                    <td class="">
                                        <div class="d-flex aling-item-center"><a
                                                href="{{ route('products.edit', $product->id) }}"
                                                class="me-2 btn btn-light-success btn-sm ">edit</a>
                                            <x-action.delete :route="route('products.destroy', $product->id)">
                                                Delete
                                            </x-action.delete>
                                        </div>
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
