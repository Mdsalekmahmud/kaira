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
                                <input name="price" type="number" step="0.01" id="helperText" class="form-control"
                                    placeholder="Product Price" value="{{ $product->price }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="helperText">Product Sell Price</label>
                                <input name="s_price" type="number" step="0.01" id="helperText" class="form-control"
                                    placeholder="Product Sell Price" value="{{ $product->s_price }}">
                            </div>

                            <div class="form-group">
                                <label for="helperText">Product Rating</label>
                                <input name="rating" type="number" step="0.1" id="helperText" class="form-control"
                                    placeholder="Product Rating" value="{{ $product->rating }}">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Quantity</label>
                                <input name="quantity" type="number" id="helperText" class="form-control"
                                    placeholder="Product Quantity" value="{{ $product->quantity }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Description</label>
                            <textarea name="discription" type="text" class="form-control" id="helpInputTop">{{ $product->discription }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Short Description</label>
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
                                                style="border:1px solid #ccc; padding:3px; margin:5px;">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Variant Attribute Selection</h5>
                        </div>
                        <div class="card-body">
                            @if($attributes->count() > 0)
                                @foreach($attributes as $attribute)
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">{{ $attribute->name }}</label>
                                        <div>
                                            @foreach($attribute->values as $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input variant-attribute-checkbox" type="checkbox"
                                                        data-attribute-name="{{ strtolower($attribute->name) }}"
                                                        data-attribute-id="{{ $attribute->id }}"
                                                        data-value="{{ $value->value }}"
                                                        value="{{ $value->id }}"
                                                        id="variant-attr-{{ $attribute->id }}-{{ $value->id }}">
                                                    <label class="form-check-label" for="variant-attr-{{ $attribute->id }}-{{ $value->id }}">{{ $value->value }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-info">No attribute values available to generate variants.</div>
                            @endif

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Attribute Name (optional)</label>
                                        <input type="text" class="form-control" id="newAttributeName" placeholder="e.g., Color">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>New Attribute Values (comma separated)</label>
                                        <input type="text" class="form-control" id="newAttributeValues" placeholder="e.g., Red, Blue">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary" onclick="generateVariantsFromAttributes()">Generate Variants</button>
                            <button type="button" class="btn btn-secondary ms-2" onclick="addBlankVariation()">Add Blank Variation</button>
                        </div>
                    </div>

                    <!-- Variations Section -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Product Variations</h5>
                            <button type="button" class="btn btn-sm btn-primary" onclick="addVariation()">+ Add Variation</button>
                        </div>
                        <div class="card-body">
                            <div id="variationsContainer">
                                @if($product->variations->count() > 0)
                                    @foreach($product->variations as $index => $variation)
                                        <div class="variation-item border rounded p-3 mb-3" id="variation-{{ $index }}">
                                            <div class="d-flex justify-content-between mb-3">
                                                <h6>Variation #{{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="removeVariation({{ $index }})">Remove</button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>SKU</label>
                                                        <input type="text" name="variants[{{ $index }}][sku]" class="form-control" value="{{ $variation->sku }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Price</label>
                                                        <input type="number" name="variants[{{ $index }}][price]" class="form-control" step="0.01" value="{{ $variation->price }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Stock</label>
                                                        <input type="number" name="variants[{{ $index }}][stock]" class="form-control" value="{{ $variation->stock }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Color</label>
                                                        <input type="text" name="variants[{{ $index }}][color]" class="form-control" value="{{ $variation->color }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Size</label>
                                                        <input type="text" name="variants[{{ $index }}][size]" class="form-control" value="{{ $variation->size }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Material</label>
                                                        <input type="text" name="variants[{{ $index }}][material]" class="form-control" value="{{ $variation->material }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>New Attribute Name</label>
                                                        <input type="text" name="variants[{{ $index }}][new_attribute_name]" class="form-control" placeholder="e.g., Color">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>New Attribute Value</label>
                                                        <input type="text" name="variants[{{ $index }}][new_attribute_value]" class="form-control" placeholder="e.g., Red">
                                                    </div>
                                                </div>
                                                @if($attributes->count() > 0)
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Product Attributes</label>
                                                        @foreach($attributes as $attribute)
                                                            <div class="mb-2">
                                                                <label class="form-label">{{ $attribute->name }}</label>
                                                                @foreach($attribute->values as $value)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="variants[{{ $index }}][attributes][]" value="{{ $value->id }}" 
                                                                            {{ $variation->attributeValues->contains('id', $value->id) ? 'checked' : '' }}
                                                                            id="attr-{{ $index }}-{{ $value->id }}">
                                                                        <label class="form-check-label" for="attr-{{ $index }}-{{ $value->id }}">
                                                                            {{ $value->value }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-4">Edit Product</button>
                </form>
            </div>
        </div>
    </section>
    <script>
        let variationCount = {{ $product->variations->count() ?? 0 }};

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

        function addVariation() {
            generateVariantsFromAttributes();
        }

        function getSelectedAttributeGroups() {
                <div class="variation-item border rounded p-3 mb-3" id="variation-${variationIndex}">
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Variation #${variationIndex + 1}</h6>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeVariation(${variationIndex})">Remove</button>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SKU</label>
                                <input type="text" name="variants[${variationIndex}][sku]" class="form-control" placeholder="e.g., PROD-001">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Price</label>
                                <input type="number" name="variants[${variationIndex}][price]" class="form-control" step="0.01" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" name="variants[${variationIndex}][stock]" class="form-control" placeholder="Stock Quantity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Color</label>
                                <input type="text" name="variants[${variationIndex}][color]" class="form-control" placeholder="e.g., Red, Blue">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Size</label>
                                <input type="text" name="variants[${variationIndex}][size]" class="form-control" placeholder="e.g., M, L, XL">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Material</label>
                                <input type="text" name="variants[${variationIndex}][material]" class="form-control" placeholder="e.g., Cotton, Wool">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Attribute Name</label>
                                <input type="text" name="variants[${variationIndex}][new_attribute_name]" class="form-control" placeholder="e.g., Color">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>New Attribute Value</label>
                                <input type="text" name="variants[${variationIndex}][new_attribute_value]" class="form-control" placeholder="e.g., Red">
                            </div>
                        </div>
                        @if($attributes->count() > 0)
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Product Attributes</label>
                                @foreach($attributes as $attribute)
                                    <div class="mb-2">
                                        <label class="form-label">{{ $attribute->name }}</label>
                                        @foreach($attribute->values as $value)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variants[\${variationIndex}][attributes][]" value="{{ $value->id }}" id="attr-\${variationIndex}-{{ $value->id }}">
                                                <label class="form-check-label" for="attr-\${variationIndex}-{{ $value->id }}">
                                                    {{ $value->value }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', variationHTML);
        }

        function removeVariation(index) {
            const element = document.getElementById(`variation-${index}`);
            if (element) {
                element.remove();
            }
        }
    </script>
</x-dashboard>
