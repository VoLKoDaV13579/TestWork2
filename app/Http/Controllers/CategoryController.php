<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with(['children', 'parent', 'products'])->whereNull('parent_id')->get();
        return response()->json(['categories' => $categories], 200);
    }
}
