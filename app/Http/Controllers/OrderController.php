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


        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return response()->json(['message' => 'Ваша корзина пуста.'], 400);
        }


        $totalPrice = 0;
        $items = [];

        foreach ($cart->items as $cartItem) {
            $product = $cartItem->product;
            $totalPrice += $product->price * $cartItem->quantity;


            $items[] = [
                'product_id' => $product->id,
                'quantity' => $cartItem->quantity,
                'price' => $product->price,
            ];
        }



        if ($totalPrice <= 0) {
            return response()->json(['message' => 'Ошибка в расчетах общей стоимости заказа.'], 400);
        }


        $order = Order::create([
            'user_id' => $user->id,
            'contact_email' => $user->email,
            'contact_phone' => $user->phone,
            'price' => $totalPrice,
        ]);


        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }


        $cart->items()->delete();

        return response()->json([
            'message' => 'Заказ успешно создан.',
            'order' => $order,
        ], 201);
    }

    public function userOrders(Request $request)
    {
        $user = Auth::user();
        $orders = $request->user()->orders()->with('item.product')->get();
        return response()->json(['order' => $orders], 200);
    }
}
