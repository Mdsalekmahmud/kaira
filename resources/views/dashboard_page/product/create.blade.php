<x-dashboard>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Products</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Product Category</label>
                                <select class="form-select" name="category_id" required
                                    aria-label="Default select example">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label for="basicInput">Product Name</label>
                                <input name="name" type="text" class="form-control" id="basicInput"
                                    placeholder="Enter Product Name">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Price</label>
                                <input name="price" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price">
                            </div>
                        </div>
                        <div class="col-md-6">
                            
                            <div class="form-group">
                                <label for="helperText">Product sell Price</label>
                                <input name="s_price" type="number" id="helperText" class="form-control"
                                    placeholder="Product sell Price">
                            </div>

                            <div class="form-group">
                                <label for="helperText">Product rating</label>
                                <input name="rating" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Quantity</label>
                                <input name="quantity" type="number" id="helperText" class="form-control"
                                    placeholder="Product Price">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Discription</label>
                            <textarea name="discription" type="text" class="form-control" id="helpInputTop"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Discription</label>
                            <textarea name="s_discription" type="text" class="form-control" id="helpInputTop"> </textarea>
                        </div>
                        <div class="form-group">
                            <label for="singleImageInput">Product Image</label>
                            <input name="image" type="file" class="form-control" id="singleImageInput"
                                onchange="previewSingleImage(this)">
                            <div id="previewSingleImage" style="margin-top:10px;"></div>
                        </div>

                        <div class="form-group">
                            <label for="multipleImagesInput">Product Images</label>
                            <input name="images[]" type="file" class="form-control" id="multipleImagesInput" multiple
                                onchange="previewImages(this)">
                            <div id="imagePreview" style="margin-top:10px;"></div>
                        </div>


                    </div>

                    <button type="submit" class="btn btn-primary">Create New Product</button>
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
