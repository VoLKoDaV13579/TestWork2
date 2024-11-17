<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use League\CommonMark\Extension\Attributes\Node\Attributes;

class AttributesController extends Controller
{
    public function index()
    {
        $attributes = Attribute::all();
        return response()->json([
            'attributes' => $attributes,
        ], 200);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Attribute::create([
            'name'=>$request['name'],
        ]);
    }
    public function show(Attribute $attribute)
    {
        return response()->json([
            'attribute' => $attribute,
        ], 200);
    }
    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $attribute->update($request->only('name'));

        return response()->json([
            'attribute' => $attribute,
        ], 200);
    }
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return response()->json([
            'message' => 'Attribute deleted',
        ],200);
    }
    public function attachToProduct(Request $request, Product $product)
    {
        $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255',
        ]);

        $product->attributes()->attach($request->attribute_id, ['value' => $request->value]);

        return response()->json([
            'message' => 'Attribute attached to product successfully.'
        ], 200);
    }

    public function updateProductAttribute(Request $request, Product $product, Attribute $attribute)
    {
        $request->validate([
            'value' => 'required|string|max:255',
        ]);

        $product->attributes()->updateExistingPivot($attribute->id, ['value' => $request->value]);

        return response()->json([
            'message' => 'Product attribute value updated successfully.'
        ], 200);
    }

    public function detachFromProduct(Product $product, Attribute $attribute)
    {
        $product->attributes()->detach($attribute->id);

        return response()->json([
            'message' => 'Attribute detached from product successfully.'
        ], 200);
    }
}
