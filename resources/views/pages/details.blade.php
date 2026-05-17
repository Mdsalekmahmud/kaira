<x-app>
    {{-- @dd($variation) --}}
    <div class="container">
        <div class="row m-4">
            <div class="col-md-6" style="background-color: white;">
                <div style="height: 400px; overflow:hidden;" class="mb-3">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded w-100"
                        alt="{{ $product->name }}" style=" cursor: pointer;">
                </div>
                <div class="row">
                    @foreach ($product->images as $image)
                        <div class="col-md-3 mb-3 d-flex justify-content-center">
                            <img style="height:100%; width:100%; object-fit:cover; cursor:pointer;"
                                src="{{ asset('storage/' . $image) }}" class="img-fluid rounded border thumbnail-img"
                                alt="Product Image" onclick="changeImage(this)">
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6" style=" color:black;">
                {{-- @dd($product) --}}
                <h2>{{ $product->name }}</h2>
                <p>
                    {{ $product->discription }}
                </p>
                <h4 class="text-success">
                    ${{ $product->price }}
                </h4>
                <form action="{{ route('cartadd') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity:</label>
                        <input type="number" name="quantity" id="quantity" value="1" min="1"
                            class="form-control w-25">
                        <input type="hidden" name="product_add" value="{{ $product->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add to Cart</button>
            </div>
        </div>
    </div>

    <script>
        function changeImage(thumbnail) {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = thumbnail.src;
        }
    </script>
</x-app>
