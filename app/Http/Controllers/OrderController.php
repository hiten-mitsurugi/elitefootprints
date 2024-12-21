<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Show all orders for the authenticated user
    public function index()
    {
        // Eager load 'items' (the related OrderItems) with each order
        $orders = Order::with('items')->paginate(10);

        return Inertia::render('User/Orders/CheckoutList', [
            'orders' => $orders,
        ]);
    }


    // Show the details of a specific order and its items
    public function show($orderId)
    {
        // Retrieve the order by its ID
        $order = Order::findOrFail($orderId);

        // Retrieve the related order items, including product and user
        $orderItems = OrderItem::with(['product', 'user'])
            ->where('order_id', $orderId)
            ->get()
            ->map(function ($item) {
                // Ensure price is always a float
                $item->price = floatval($item->price ?? 0);

                // Add a total calculation field for convenience
                $item->total = $item->price * $item->quantity;

                return $item;
            });

        // Return data to the Inertia view
        return Inertia::render('User/Orders/OrderDetails', [
            'order' => $order,
            'orderItems' => $orderItems,
        ]);
    }




    // Delete an order item
    public function destroy($orderItemId)
    {
        // Implement your deletion logic here
        $orderItem = OrderItem::findOrFail($orderItemId);
        $orderItem->delete();

        return redirect()->route('orders.index')->with('flash', ['message' => 'Item deleted successfully']);
    }

    // Handle payment
    public function pay($orderItemId)
    {
        // Implement payment logic here
        return redirect()->route('orders.index')->with('flash', ['message' => 'Payment successful']);
    }


    public function purchase(Request $request)
    {
        \Log::info('Purchase request received', $request->all());

        try {
            $request->validate([
                'userId' => 'required|exists:users,id',
                'cart' => 'required|array',
                'cart.*.product_id' => 'required|exists:products,id',
                'cart.*.quantity' => 'required|integer|min:1',
                'cart.*.price' => 'required|numeric|min:0',
            ]);

            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $request->userId,
                'order_number' => 'ORD-' . uniqid(),
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $totalAmount = 0;

            foreach ($request->cart as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'user_id' => $request->userId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $totalAmount += $item['quantity'] * $item['price'];
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            \Log::info('Order created successfully', ['order_id' => $order->id]);

            return response()->json(['message' => 'Order created successfully', 'order_id' => $order->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to create order', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create order: ' . $e->getMessage()], 500);
        }
    }



}
