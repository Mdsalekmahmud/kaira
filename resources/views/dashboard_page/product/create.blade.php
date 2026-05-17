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
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
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
                                <input name="price" type="number" step="0.01" id="helperText" class="form-control"
                                    placeholder="Product Price">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="helperText">Product Sell Price</label>
                                <input name="s_price" type="number" step="0.01" id="helperText" class="form-control"
                                    placeholder="Product Sell Price">
                            </div>

                            <div class="form-group">
                                <label for="helperText">Product Rating</label>
                                <input name="rating" type="number" step="0.1" id="helperText" class="form-control"
                                    placeholder="Product Rating">
                            </div>
                            <div class="form-group">
                                <label for="helperText">Product Quantity</label>
                                <input name="quantity" type="number" id="helperText" class="form-control"
                                    placeholder="Product Quantity">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Description</label>
                            <textarea name="discription" type="text" class="form-control" id="helpInputTop"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="helpInputTop">Product Short Description</label>
                            <textarea name="s_discription" type="text" class="form-control" id="helpInputTop"></textarea>
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

                    <!-- Enable Variations Switch Section -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="enableVariations" 
                                    id="variationsSwitch" onchange="toggleVariationsSection()">
                                <label class="form-check-label" for="variationsSwitch">
                                    Enable Product Variations
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="variationsSection" style="display: none;">
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Variant Attribute Groups</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary"
                                onclick="addAttributeGroup()">+ Add Attribute</button>
                        </div>
                        <div class="card-body">
                            <div id="attributeGroupsContainer"></div>
                            <div class="mt-3 d-flex gap-2">
                                <button type="button" class="btn btn-primary"
                                    onclick="generateVariantsFromAttributes()">Generate Variants</button>
                                <button type="button" class="btn btn-secondary"
                                    onclick="resetAttributeGroups()">Reset Attributes</button>
                            </div>
                        </div>
                    </div>

                    <!-- Variations Section -->
                    <div class="card mt-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Product Variations</h5>
                        </div>
                        <div class="card-body">
                            <div id="variationsContainer">
                                <!-- Variations will be added here dynamically -->
                            </div>
                        </div>
                    </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-4">Create New Product</button>
                </form>
            </div>
        </div>
    </section>


    <script>
        let variationCount = 0;
        let attributeGroupCount = 0;

        function toggleVariationsSection() {
            const isEnabled = document.getElementById('variationsSwitch').checked;
            const variationsSection = document.getElementById('variationsSection');
            
            if (isEnabled) {
                variationsSection.style.display = 'block';
            } else {
                variationsSection.style.display = 'none';
            }
        }

        function previewSingleImage(input) {
            const preview = document.getElementById('previewSingleImage');
            preview.innerHTML = '';
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.height = '200px';
                    img.style.border = '1px solid #ccc';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImages(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            if (input.files) {
                Array.from(input.files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
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

       


        function addAttributeGroup(attributeName = '', attributeValues = '') {
            const container = document.getElementById('attributeGroupsContainer');
            const index = attributeGroupCount++;
            const html = `<div class="attribute-group border rounded p-3 mb-3" data-index="${index}">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0">Attribute ${index + 1}</h6>
                <small class="text-muted">Enter name and comma-separated values</small>
            </div>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="removeAttributeGroup(${index})">Remove</button>
        </div>
        <div class="row g-2">
            <div class="col-md-5">
                <label class="form-label">Attribute Name</label>
                <input type="text" class="form-control attribute-name" value="${escapeHtml(attributeName)}"
                    placeholder="e.g., Color">
            </div>
            <div class="col-md-7">
                <label class="form-label">Values</label>
                <input type="text" class="form-control attribute-values" value="${escapeHtml(attributeValues)}"
                    placeholder="e.g., Red, Blue, Green">
            </div>
        </div>
    </div>
    `;
            container.insertAdjacentHTML('beforeend', html);
        }

        function removeAttributeGroup(index) {
            const group = document.querySelector(`.attribute-group[data-index="${index}"]`);
            if (group) {
                group.remove();
            }
        }

        function resetAttributeGroups() {
            document.getElementById('attributeGroupsContainer').innerHTML = '';
            attributeGroupCount = 0;
            initializeDefaultAttributeGroups();
        }

        function getAttributeGroups() {
            const groups = [];
            document.querySelectorAll('.attribute-group').forEach(group => {
                const nameInput = group.querySelector('.attribute-name');
                const valuesInput = group.querySelector('.attribute-values');
                if (!nameInput || !valuesInput) return;

                const name = nameInput.value.trim();
                const values = valuesInput.value
                    .split(',')
                    .map(value => value.trim())
                    .filter(Boolean);

                if (name && values.length) {
                    groups.push({
                        name,
                        values
                    });
                }
            });
            return groups;
        }

        function cartesianProduct(arrays) {
            return arrays.reduce((acc, values) => acc.flatMap(prev => values.map(value => [...prev, value])), [
                []
            ]);
        }

        function buildVariantSku(productName, attributes) {
            const normalize = value => String(value || '')
                .trim()
                .toUpperCase()
                .replace(/[^A-Z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');

            const productPart = normalize(productName) || 'PRODUCT';
            const attrPart = attributes
                .map(attr => `${normalize(attr.name)}-${normalize(attr.value)}`)
                .filter(Boolean)
                .join('-');

            return attrPart ? `${productPart}-${attrPart}` : productPart;
        }

        function createVariantRow(variantData = {}) {
            const container = document.getElementById('variationsContainer');
            const variationIndex = variationCount++;
            const hiddenFields = [];
            const attributes = Array.isArray(variantData.attributes) ? variantData.attributes : [];

            attributes.forEach(attr => {
                const safeName = attr.name.replace(/\[|\]/g, '').trim();
                hiddenFields.push(
                    `<input type="hidden" name="variants[${variationIndex}][attributes][${escapeHtml(safeName)}]"
        value="${escapeHtml(attr.value)}">`
                );
            });

            const attributeSummary = attributes.length ?
                attributes.map(attr => `${escapeHtml(attr.name)}: ${escapeHtml(attr.value)}`).join(', ') :
                'No attributes';

            const variationHTML = `
    <div class="variation-item border rounded p-3 mb-3" id="variation-${variationIndex}">
        <div class="d-flex justify-content-between mb-3">
            <h6>Variation #${variationIndex + 1}</h6>
            <button type="button" class="btn btn-sm btn-danger"
                onclick="removeVariation(${variationIndex})">Remove</button>
        </div>
        <div class="row g-3">
            ${hiddenFields.join('')}
            <div class="col-12">
                <div class="form-group">
                    <label>Attributes</label>
                    <div class="form-control-plaintext">${attributeSummary}</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>SKU</label>
                    <input type="text" name="variants[${variationIndex}][sku]" class="form-control"
                        placeholder="Auto-generated SKU" value="${escapeHtml(variantData.sku || '')}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="variants[${variationIndex}][price]" class="form-control"
                        step="0.01" placeholder="Price" value="${escapeHtml(variantData.price || '')}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Stock</label>
                    <input type="number" name="variants[${variationIndex}][stock]" class="form-control"
                        placeholder="Stock Quantity" value="${escapeHtml(variantData.stock || '')}">
                </div>
            </div>
        </div>
    </div>
    `;

            container.insertAdjacentHTML('beforeend', variationHTML);
        }

        function addBlankVariation() {
            createVariantRow();
        }

        function generateVariantsFromAttributes() {
            const groups = getAttributeGroups();
            if (groups.length === 0) {
                addBlankVariation();
                return;
            }

            document.getElementById('variationsContainer').innerHTML = '';
            variationCount = 0;

            const combinations = cartesianProduct(groups.map(group => group.values.map(value => ({
                name: group.name,
                value
            }))));
            const productName = document.querySelector('input[name="name"]').value || 'PRODUCT';

            combinations.forEach(items => {
                const sku = buildVariantSku(productName, items);
                createVariantRow({
                    attributes: items,
                    sku
                });
            });
        }

        function escapeHtml(value) {
            return String(value || '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function removeVariation(index) {
            const element = document.getElementById(`variation-${index}`);
            if (element) {
                element.remove();
            }
        }

        function initializeDefaultAttributeGroups() {
            if (document.querySelectorAll('.attribute-group').length === 0) {
                addAttributeGroup('Color', 'Red, Blue');
                // addAttributeGroup('Size', 'S, M, L');
            }
            toggleVariationsSection();
        }

        document.addEventListener('DOMContentLoaded', initializeDefaultAttributeGroups);
    </script>


</x-dashboard>
