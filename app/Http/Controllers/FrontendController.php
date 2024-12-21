<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function index()
    {
        //return Inertia::render('Welcome');
        // return Inertia::render('Welcome', [
        //     'canLogin' => Route::has('login'),
        //    'canRegister' => Route::has('register'),
        //   'laravelVersion' => Application::VERSION,
        //  'phpVersion' => PHP_VERSION,
        //]);
        $products = Product::all(); // Fetch all products from the database
        return Inertia::render('Welcome', [
            'auth' => Auth::user(),
            'checkAuth' => Auth::check(),
            'products' => Product::all(),// Pass the products to the Welcome component
        ]);
    }
    public function about()
    {
        return Inertia::render('Frontend/About', [
            'title' => 'About Us Page'
        ]);
    }



    public function dashboard()
    {
        $user = auth()->user();
        $orderItems = OrderItem::where('user_id', $user->id)
            ->with('product') // Eager load the product relationship
            ->paginate(20);

        // Transform the data to include product_image directly on the order item
        $orderItems->getCollection()->transform(function ($item) {
            $item->price = (float) $item->price;
            $item->product_image = $item->product ? $item->product->product_image : null;
            return $item;
        });

        return Inertia::render('User/Dashboard', [
            'user' => $user,
            'orderItems' => $orderItems,
        ]);
    }





}
