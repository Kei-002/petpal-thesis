<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function getProductPageDetails()
    {
        $products = Product::with('category')->get();
        $products1 = Product::all();
        $categories = Category::all();
        $category_count = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.category_id as id', DB::raw('count("category_id") as total'))
            ->groupBy('category_id')
            // ->orderBy('products.category_id')
            ->get();
        $test = $products1->groupBy('category_id')->map->count();
        // ->pluck('total', 'category_id');
        $test2 = Product::select('category_id', DB::raw("count(id) as total"))->with('category')->groupBy('category_id')->get();
        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'category_count' => $category_count,
            'test' => $test2,
        ]);
    }
}
