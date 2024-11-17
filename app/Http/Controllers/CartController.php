<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);


        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart',
            'cart' => $this->formatCart($cart),
        ], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getUserCart();

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $request->quantity]);

            return response()->json([
                'message' => 'Product updated in cart',
                'cart' => $this->formatCart($cart),
            ], 200);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $cart = $this->getUserCart();

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->delete();

            return response()->json([
                'message' => 'Product removed from cart',
                'cart' => $this->formatCart($cart),
            ], 200);
        }

        return response()->json(['message' => 'Product not found in cart'], 404);
    }

    protected function getUserCart()
    {
        $cart = Auth::user()->cart()->with('items.product')->first();
        if (!$cart) {
            abort(404, 'Cart not found');
        }
        return $cart;
    }

    protected function formatCart($cart)
    {
        return [
            'id' => $cart->id,
            'items' => $cart->items->map(fn($item) => [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price ?? 0,
            ]),
        ];
    }
}

