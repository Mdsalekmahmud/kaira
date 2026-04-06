<x-dashboard>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit Products</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Product Category</label>
                                <select class="form-select" name="category_id" required
                                    aria-label="Default select example">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="basicInput">Product Name</label>
                                <input name="name" type="text" class="form-control" id="basicInput"
                                    placeholder="Enter Product Name" value="{{ $product->name }}">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Price</label>
                                <input name="price" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price"value="{{ $product->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="helperText">Product sell Price</label>
                                <input name="s_price" type="number" id="helperText" class="form-control"
                                    placeholder="Product sell Price"value="{{ $product->s_price }}">
                            </div>

                            <div class="form-group">
                                <label for="helperText">Product rating</label>
                                <input name="rating" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price"value="{{ $product->rating }}">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Quantity</label>
                                <input name="quantity" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price" value="{{ $product->quantity }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Discription</label>
                            <textarea name="discription" type="text" class="form-control" id="helpInputTop">{{ $product->discription }} </textarea>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Short Discription</label>
                            <textarea name="s_discription" type="text" class="form-control" id="helpInputTop">{{ $product->s_discription }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="singleImageInput">Product Image</label>
                            <input name="image" type="file" class="form-control" id="singleImageInput"
                                onchange="previewSingleImage(this)">

                            <div id="previewSingleImage" style="margin-top:10px;">
                                @if ($product->image)
                                    <img src="{{ asset('storage/'. $product->image) }}" width="100"
                                        alt="Product Image">
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="multipleImagesInput">Product Images</label>
                            <input name="images[]" type="file" class="form-control" id="multipleImagesInput" multiple
                                onchange="previewImages(this)">
                            <div id="imagePreview" class="d-flex" style="margin-top:10px;">
                                @if ($product->images)
                                    @foreach ($product->images as $image)
                                        <div style="position:relative;">
                                            <img src="{{ asset('storage/' . $image) }}" width="80"
                                                style="border:1px margin-top:1px solid #ccc; padding:3px;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Edit Product</button>
                </form>
            </div>
        </div>
    </section>
    <script>
        function previewSingleImage(input) {
            let preview = document.getElementById('previewSingleImage');
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.height = '200px';
                    img.style.border = '1px solid #ccc';
                    preview.appendChild(img);

                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImages(input) {
            let preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.height = '120px';
                        img.style.margin = '5px';
                        img.style.border = '1px solid #ccc';
                        preview.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</x-dashboard>
