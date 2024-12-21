<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderBy('id', 'asc')->paginate(5); // Order by 'id' and paginate

        return Inertia::render('Frontend/Product/Index', [
            'products' => $products, // Pass the paginated and ordered products
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Frontend/Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'category' => 'required|string',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation
        ]);

        // Create a new product and assign the validated values
        $product = new Product();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->quantity = $validated['quantity'];
        $product->category = $validated['category'];

        // Handle the file upload
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $filename = $image->getClientOriginalName();  // Get the original filename
            $imagePath = $image->storeAs('products', $filename, 'public'); // Save the image with the original filename in the 'products' directory
            $product->product_image = $imagePath; // Store the file path in the database
        }

        // Save the product to the database
        $product->save();

        // Redirect or return a response
        return redirect()->route('product.index')->with('message', 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Inertia::render('Frontend/Product/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return Inertia::render('Frontend/Product/Edit', [
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'quantity' => 'required|integer',
            'category' => 'required|string',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // image validation (nullable for updates)
        ]);

        $product = Product::findOrFail($id);

        // Update other product fields
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->description = $validated['description'];
        $product->quantity = $validated['quantity'];
        $product->category = $validated['category'];


        // Handle the file upload if there is a new image
        if ($request->hasFile('product_image')) {
            // Delete the old image if it exists (optional but recommended)
            if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
                Storage::disk('public')->delete($product->product_image);
            }

            // Store the new image
            $image = $request->file('product_image');
            $filename = $image->getClientOriginalName();  // Get the original filename
            $imagePath = $image->storeAs('products', $filename, 'public'); // Save the image in the 'products' directory
            $product->product_image = $imagePath; // Update the product with the new image path
        }

        // Save the product to the database
        $product->save();

        return redirect()->route('product.index')->with('message', 'Product updated successfully');
    }





    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index')->with('message', 'Deleted successfully');
    }


}
