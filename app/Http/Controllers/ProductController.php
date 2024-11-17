<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category_id')) {

            $query->where('category_id', $request->get('category_id'));
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

//        if ($request->has('attributes')) {
//            foreach ($request->get('attributes') as $key => $value) {
//                $query->whereHas('attributes', function ($query) use ($key, $value) {
//                    $query->where('name', $key)->orWhere('value', $value);
//                });
//            }
//        }
        $products = $query->get();
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        // $product = Product::where('slug', $slug)->with('attributes')->firstOrFail();
        return response()->json([
            'product' => $product
        ], 200);
    }
}
