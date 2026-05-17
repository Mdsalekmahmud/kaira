<?php
namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\attribute_values;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('variations')->latest()->paginate(15);
        return view('dashboard_page.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $attributes = Attribute::with('values')->get();
        return view('dashboard_page.product.create', compact('categories', 'attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            's_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'discription' => 'nullable|string',
            's_discription' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.attributes' => 'nullable|array',
            'variants.*.new_attribute_name' => 'nullable|string|max:255',
            'variants.*.new_attribute_value' => 'nullable|string|max:255',
        ]);

        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('images', 'public');
        }

        $multipleImages = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('images', 'public');
                $multipleImages[] = $path;
            }
        }

        $product = Product::create([
            'slug' => Str::slug($request->name) . '-' . Str::lower(Str::random(6)),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image' => $image ?? '',
            'images' => $multipleImages,
            'discription' => $request->discription ?? '',
            's_discription' => $request->s_discription ?? '',
            'quantity' => $request->quantity,
            'price' => $request->price,
            's_price' => $request->s_price ?? 0,
            'rating' => $request->rating ?? 0,
        ]);

        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $variantData) {
                $attributeIds = $this->resolveVariantAttributes($variantData);
                $variant = ProductVariation::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'] ?? $this->generateVariantSku($product->name, $variantData, $attributeIds),
                    'material' => $variantData['material'] ?? null,
                    'color' => $variantData['color'] ?? null,
                    'size' => $variantData['size'] ?? null,
                    'price' => $variantData['price'] ?? $product->price,
                    'stock' => $variantData['stock'] ?? 0,
                ]);

                if (!empty($attributeIds)) {
                    $variant->attributeValues()->sync($attributeIds);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $product->load('variants.attributeValues');
        $attributes = Attribute::with('values')->get();
        return view('dashboard_page.product.edit', compact('categories', 'product', 'attributes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            's_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|numeric|min:0',
            'discription' => 'nullable|string',
            's_discription' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.attributes' => 'nullable|array',
            'variants.*.new_attribute_name' => 'nullable|string|max:255',
            'variants.*.new_attribute_value' => 'nullable|string|max:255',
        ]);

        // Handle main image
        $image = $product->image;
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $image = $request->file('image')->store('images', 'public');
        }

        // Handle multiple images
        $multipleImages = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images if replacing
            if (!empty($multipleImages)) {
                foreach ($multipleImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }
            }
            $multipleImages = [];
            foreach ($request->file('images') as $img) {
                $path = $img->store('images', 'public');
                $multipleImages[] = $path;
            }
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image' => $image,
            'images' => $multipleImages,
            'discription' => $request->discription,
            's_discription' => $request->s_discription,
            'quantity' => $request->quantity,
            'price' => $request->price,
            's_price' => $request->s_price,
            'rating' => $request->rating ?? 0,
        ]);

        // Update variants
        if ($request->has('variants') && is_array($request->variants)) {
            $product->variations()->delete();
            foreach ($request->variants as $variantData) {
                $attributeIds = $this->resolveVariantAttributes($variantData);
                $variant = ProductVariation::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'] ?? $this->generateVariantSku($product->name, $variantData, $attributeIds),
                    'material' => $variantData['material'] ?? null,
                    'color' => $variantData['color'] ?? null,
                    'size' => $variantData['size'] ?? null,
                    'price' => $variantData['price'] ?? $product->price,
                    'stock' => $variantData['stock'] ?? 0,
                ]);

                if (!empty($attributeIds)) {
                    $variant->attributeValues()->sync($attributeIds);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    private function resolveVariantAttributes(array $variantData): array
    {
        $attributeIds = [];

        if (isset($variantData['attributes']) && is_array($variantData['attributes'])) {
            foreach ($variantData['attributes'] as $attributeName => $attributeValue) {
                if (is_numeric($attributeValue)) {
                    $value = attribute_values::find($attributeValue);
                    if ($value) {
                        $attributeIds[] = $value->id;
                        continue;
                    }
                }

                $attributeName = trim($attributeName);
                $attributeValue = trim((string) $attributeValue);
                if ($attributeName !== '' && $attributeValue !== '') {
                    $value = $this->findOrCreateAttributeValue($attributeName, $attributeValue);
                    if ($value) {
                        $attributeIds[] = $value->id;
                    }
                }
            }
        }

        if (!empty($variantData['new_attribute_name']) && !empty($variantData['new_attribute_value'])) {
            $newValue = $this->findOrCreateAttributeValue($variantData['new_attribute_name'], $variantData['new_attribute_value']);
            if ($newValue) {
                $attributeIds[] = $newValue->id;
            }
        }

        return array_values(array_unique($attributeIds));
    }

    private function findOrCreateAttributeValue(string $attributeName, string $value): ?attribute_values
    {
        $attributeName = trim($attributeName);
        $value = trim($value);

        if ($attributeName === '' || $value === '') {
            return null;
        }

        $attribute = Attribute::firstOrCreate(['name' => $attributeName]);

        return attribute_values::firstOrCreate([
            'attribute_id' => $attribute->id,
            'value' => $value,
        ]);
    }

    private function generateVariantSku(string $productName, array $variantData, array $attributeIds = []): string
    {
        $skuParts = [Str::upper(Str::slug($productName ?: 'product', '-'))];
        $attributeParts = [];

        if (!empty($attributeIds)) {
            $values = attribute_values::whereIn('id', $attributeIds)->with('attribute')->get();
            foreach ($values as $value) {
                if ($value->attribute) {
                    $attributeParts[] = Str::upper(Str::slug($value->attribute->name, '-'));
                }
                $attributeParts[] = Str::upper(Str::slug($value->value, '-'));
            }
        }

        if (!empty($attributeParts)) {
            $skuParts[] = implode('-', $attributeParts);
        }

        $baseSku = implode('-', $skuParts);
        $sku = $baseSku;
        $suffix = 1;

        while (ProductVariation::where('sku', $sku)->exists()) {
            $sku = $baseSku . '-' . sprintf('%02d', $suffix++);
        }

        return $sku;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        if ($product->images && is_array($product->images)) {
            foreach ($product->images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
