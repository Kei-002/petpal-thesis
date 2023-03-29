<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Orderline;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;

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

    public function checkout(Request $request)
    {
        try {
            $test_cart = array();
            DB::beginTransaction();
            // $order = Order::create(['c_id' => auth()->user()->id]);
            $order = Order::create(['customer_id' => Auth::id(), "total_purchase" => $request->totalAmount]);

            foreach ($request->get('items') as $key => $item) {
                $orderline = new Orderline();

                $orderline->orderinfo_id = $order->id;
                $orderline->product_id = $item['id'];
                $orderline->quantity = $item['quantity'];
                // $fileName = time() . $request->file('img_path')->getClientOriginalName();
                // $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
                // $input["img_path"] = '/storage/' . $path;
                // $service->img_path = $input["img_path"];

                $orderline->save();
                // Orderline::create([
                //     'orderinfo_id' => $order->id,
                //     'product_id' => (int) $item->id,
                //     'quantity' => (int) $item->quantity,
                // ]);
                $test_cart[] = $item;
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response(['error' => $e->getMessage(), "order" => $order, "test_cart" => $test_cart]);
        }
        DB::commit();
        // $testing = Order::find($order->id)->with('orderlines');
        // $pdf = PDF::loadView('trans_pdf', [
        //     'customer' => Auth::user()->fname . " " . Auth::user()->lname,
        //     'trans' => $done
        // ]);
        // file_put_contents('storage/bills/transaction_no_' . $transaction->id . '.pdf', $pdf->output());

        // $pdf->stream('Reciept.pdf');
        // return response(['pdf' => 'storage/bills/transaction_no_' . $transaction->id . '.pdf']);


        return response()->json([
            'message' => "Order Placed",
            // 'user_id' => Auth::id()
            // 'categories' => $categories,
            // 'category_count' => $category_count,
            // 'test' => $test2,
        ]);
    }
}
