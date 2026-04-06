<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products=Product::all();
        return view('dashboard_page.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('dashboard_page.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {

            $image = $request->file('image')->store('images', 'public');
        } else {
            $image = null;
        }

        $multipleImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                
                $path             = $img->store('images', 'public');
                $multipleImages[] = $path; 
            }
        }

        Product::create([
            'slug' => Str::slug($request->name) . '-' . Str::lower(Str::random(6)),
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'image'         => $image,
            'images'        => $multipleImages,
            'discription'   => $request->discription,
            's_discription' => $request->s_discription,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
            's_price'       => $request->s_price,
            'rating'        => $request->rating,

        ]);

         return redirect()->route('products.index');
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
         $categories=Category::all();
         return view('dashboard_page.product.edit',compact('categories','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        
        if ($request->hasFile('image')) {

            $image = $request->file('image')->store('images', 'public');
        } else {
           $image = $product->image;
        }

        $multipleImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                
                $path             = $img->store('images', 'public');
                $multipleImages[] = $path; 
            }
        }

        $product->update([
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'image'         => $image,
            'images'        => $multipleImages,
            'discription'   => $request->discription,
            's_discription' => $request->s_discription,
            'quantity'      => $request->quantity,
            'price'         => $request->price,
            's_price'       => $request->s_price,
            'rating'        => $request->rating,

        ]);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->image && Storage::disk('public')-> exists($product->image ));
        Storage::disk('public')->delete($product->image);


        if ($product->images && is_array($product->images)) {
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
    }

        $product->delete();
        return redirect()->route('products.index');
    }
}
