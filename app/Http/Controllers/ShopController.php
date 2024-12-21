<?php
namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    // Show the products in the shop
    public function index()
    {
        $products = Product::all(); // Fetch all products
        return Inertia::render('User/Shop', [
            'userId' => auth()->id(), // Pass the current user's ID
            'products' => $products, // Pass the products to the view
        ]);
    }

    
    public function shops()
    {
        $products = Product::all(); // Fetch all products
        return Inertia::render('User/Shop2', [
            'userId' => auth()->id(), // Pass the current user's ID
            'products' => $products, // Pass the products to the view
        ]);
    }

    public function checkout(Request $request)
    {
        if ($request->has('checkoutData')) {
            // This is the summary request
            $checkoutData = json_decode($request->input('checkoutData'), true);
            
            return Inertia::render('User/Checkout', [
                'userId' => auth()->id(),
                'checkoutData' => $checkoutData,
            ]);
        } else {
            // This is the initial checkout page request
            $products = Product::all(); // Fetch all products
            return Inertia::render('User/Checkout', [
                'userId' => auth()->id(), // Pass the current user's ID
                'products' => $products, // Pass the products to the view
            ]);
        }
    }
}
