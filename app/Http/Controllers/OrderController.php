<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Cart empty.'], 400);
        }

        $totalPrice = $cart->items->sum(fn($item) => $item->product->price * $item->quantity);

        if ($totalPrice <= 0) {
            return response()->json(['message' => 'Invalid total price'], 400);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'contact_email' => $user->email,
            'contact_phone' => $user->phone,
            'price' => $totalPrice,
        ]);

        $orderItems = $cart->items->map(fn($item) => [
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ])->toArray();

        OrderItem::insert($orderItems);

        $cart->delete();

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);
    }

    public function userOrders()
    {
        $orders = Auth::user()->orders()->with('items.product')->get();
        return response()->json(['orders' => $orders], 200);
    }

}
