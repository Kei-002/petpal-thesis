<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Product::with('category')->get();
        // return response($data, $status = 200);
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();

        $product = new Product();

        $product->product_name = $input['product_name'];
        $product->cost_price = $input['cost_price'];
        $product->sell_price = $input['sell_price'];
        $product->description = $request->description;

        $product->category_id = $request->category;

        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $input["img_path"] = '/storage/' . $path;
        $product->img_path = $input["img_path"];

        $product->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'Product Created Successfully.',
            'product' => $product,
            'status' => 200,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        // $owners = Customer::all();
        $category = Category::all();
        // $user = User::where("id", $account->user_id)->firstOrFail();
        // $account = Customer::where("user_id", $user->id)->firstOrFail();
        return response()->json([
            'product' => $product,
            'category' => $category,
            'status' => 200,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function updateProduct(Request $request, $id)
    {
        // $data = $request->all();
        // dd($request);
        $product = Product::findOrFail($id);
        $category = Category::where("id", $request->category)->first();
        $product->product_name = $request->product_name;
        $product->cost_price = $request->cost_price;
        $product->sell_price = $request->sell_price;
        $product->description = $request->description;
        $product->category()->associate($category);
        $product->save();
        return response()->json([
            'message' => 'Product updated successfully',
            // 'status' => $user,
            'changes' => $request->all(),
            'product' => $product,
            'category' => $category,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->category()->dissociate();
            $product->delete();
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        return response()->json([
            'message' => 'Product Deleted Successfully',
            'status' => 200,
        ]);
    }
}
