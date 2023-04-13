<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\GroomServices;
use App\Models\Order;
use App\Models\Orderline;
use App\Models\Pet;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\Receiptline;
use App\Models\Transaction;
use App\Models\Transactionline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function getAllProducts()
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

        $button_state = 'disabled';
        if (Auth::check() && Auth::user()->role == 'customer') {
            $button_state = '';
        }
        // ->pluck('total', 'category_id');
        $test2 = Product::select('category_id', DB::raw("count(id) as total"))->with('category')->groupBy('category_id')->get();
        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'category_count' => $category_count,
            'test' => $test2,
            'button_state' => $button_state
        ]);
    }

    public function getAllServices()
    {
        $services = GroomServices::all();
        return response()->json([
            'services' => $services
        ]);
    }

    public function getOwnedPets()
    {
        // $services = GroomServices::all();
        $customer = Customer::where('user_id', '=', Auth::id())->first();
        $pets = Pet::where('customer_id', '=', $customer->id)->get();
        if (count($pets) <= 0) {
            return response()->json([
                'pets' => null,
                'message' => 'No pets found'
            ]);
        }
        return response()->json([
            'pets' => $pets,
            'customer' => $customer
        ]);
    }

    public function checkout(Request $request)
    {
        try {
            $item_cart = array();
            $service_cart = array();
            DB::beginTransaction();
            // Get customer 
            $customer = Customer::where('user_id', Auth::id())->first();

            // Store receipt informatin to database
            $receipt = Receipt::create(['total_purchase' => $request->totalAmount, "receipt_path" => "/storage/receipts/default.pdf"]);

            // Create receipt path
            $receipt_path = 'storage/receipt/(' . time() . ')receipt_no-' . $receipt->id . '.pdf';

            // Check if item object is not empty
            if ($request->get('items') != []) {
                $order = Order::create(['customer_id' => $customer->id]);

                $receiptline = new Receiptline();
                $receiptline->receipt_id = $receipt->id;
                $receiptline->item_id = $order->id;
                $receiptline->is_order = true;
                $receiptline->save();

                foreach ($request->get('items') as $key => $item) {
                    $orderline = new Orderline();
                    $orderline->orderinfo_id = $order->id;
                    $orderline->product_id = $item['id'];
                    $orderline->quantity = $item['quantity'];
                    $orderline->save();

                    $item_cart[] = $item;
                }
            }

            if ($request->get('services') != []) {
                $transaction = Transaction::create(['customer_id' => $customer->id]);

                $receiptline = new Receiptline();
                $receiptline->receipt_id = $receipt->id;
                $receiptline->item_id = $transaction->id;
                $receiptline->is_order = false;
                $receiptline->save();

                foreach ($request->get('services') as $key => $service) {
                    $pet = Pet::where("id", $service['pet_id'])->first();
                    $transactionline = new Transactionline();
                    $transactionline->transactioninfo_id = $transaction->id;
                    // $transactionline->pet_id = $service['pet_id'];
                    $transactionline->pet_id = $service['pet_id'];
                    $transactionline->service_id = $service['id'];
                    $transactionline->save();
                    $service['pet_name'] = $pet->pet_name;
                    $service_cart[] = $service;
                }
            }

            // create pdf object with order/transaction information
            $pdf = PDF::loadView('items.receipt', [
                'customer' => $customer,
                'items' => $request->get('items'),
                'services' => $service_cart,
                'receipt' => $receipt,
            ]);
            $content = $pdf->download()->getOriginalContent();

            // store the receipt in public path
            Storage::put($receipt_path, $content);

            // Update receipt path information in database
            Receipt::where('id', $receipt->id)->update(['receipt_path' => $receipt_path]);


            // $test_order = $order;
        } catch (\Exception $e) {
            DB::rollback();
            return response(['error' => $e->getMessage()]);
        }
        DB::commit();
        
        return response()->json([
            'message' => "Order Placed",
            'total' => $request->totalAmount,
            // 'pdf' => 'storage/bills/transaction_no_' . $order->id . '.pdf'
            'customer' => $customer,
            'orderlines' => $item_cart,
            'transactions' => $service_cart,
            'receipt' => $receipt,
            'test' => $request->all(),
        ]);
    }

    public function getReceipt($id)
    {
        // $data = $request->all();
        $orderlines = Orderline::where('orderinfo_id', "=",  $id)->with('products')->get();
        $customer = Customer::find(Auth::id())->first();

        return response()->json([
            // 'request' => $order,
            // 'user' => Auth::user(),
            'customer' => $customer, 'orderlines' => $orderlines,
            
            // 'categories' => $categories,
            // 'category_count' => $category_count,
            // 'test' => $test2,
        ]);
    }

    public function getProductDetails($id)
    {
        // $data = $request->all();
        $product = Product::where('id', "=",  $id)->with('category')->first();
        // $customer = Customer::find(Auth::id())->first();
        $button_state = 'disabled';
        if (Auth::check() && Auth::user()->role == 'customer') {
            $button_state = '';
        }
        return response()->json([
            // 'request' => $order,
            // 'user' => Auth::user(),
            'product' => $product,
            'category' => $product->category->category_name,
            'button_state' => $button_state
            // 'categories' => $categories,
            // 'category_count' => $category_count,
            // 'test' => $test2,
        ]);
    }

    // public function printReceipt($id)
    // {
    //     // $data = $request->all();
    //     $orderlines = Orderline::where('orderinfo_id', "=",  $id)->with('products')->get();
    //     $customer = Customer::find(Auth::id())->first();

    //     return response()->json([
    //         // 'request' => $order,
    //         // 'user' => Auth::user(),
    //         'customer' => $customer,
    //         'orderlines' => $orderlines
    //         // 'categories' => $categories,
    //         // 'category_count' => $category_count,
    //         // 'test' => $test2,
    //     ]);
    // }



    public function getAllOrders()
    {
        $orders = Order::with('orderlines')->get();
        // return response($data, $status = 200);

        // $receipts = Receipt::where('is_order', true)->get();
        $receipts = DB::table('receiptinfos')
        ->join('receiptlines', 'receiptlines.receipt_id', '=', 'receiptinfos.id')
        ->join('orderinfos', 'receiptlines.item_id', '=', 'orderinfos.id')
        ->join('customers', 'orderinfos.customer_id', '=', 'customers.id')
        ->select('receiptinfos.id', 'total_purchase', 'receipt_path', 'receiptlines.item_id', 'orderinfos.payment_status', 'customers.fname', 'customers.lname', 'customers.addressline')
        ->where('receiptlines.is_order', '=', true)
            ->get();
        return response()->json([
            'orders' => $orders,
            'receipts' => $receipts,
        ]);
    }

    public function getAllTransactions()
    {
        $transactions = Transaction::with('transactionlines')->get();
        // return response($data, $status = 200);

        // $receipts = Receipt::where('is_order', true)->get();
        $receipts = DB::table('receiptinfos')
        ->join('receiptlines', 'receiptlines.receipt_id', '=', 'receiptinfos.id')
        ->join('transactioninfos', 'receiptlines.item_id', '=', 'transactioninfos.id')
        ->join('customers', 'transactioninfos.customer_id', '=', 'customers.id')
            ->select('receiptinfos.id', 'total_purchase', 'receipt_path', 'receiptlines.item_id', 'transactioninfos.payment_status', 'customers.fname', 'customers.lname', 'customers.addressline')
        ->where('receiptlines.is_order', '=', false)
            ->get();
        return response()->json([
            'transactions' => $transactions,
            'receipts' => $receipts,
        ]);
    }


    public function updateOrderStatus($id)
    {
        // $orders = Order::with('orderlines')->get();
        $order = Order::findOrFail($id);
        $order->payment_status = "Paid";
        $order->save();
        return response()->json([
            'message' => 'Payment updated successfully',
            // 'status' => $user,
            'order' => $order,
        ]);
    }

    public function updateTransactionStatus($id)
    {
        // $orders = Order::with('orderlines')->get();
        $order = Transaction::findOrFail($id);
        $order->payment_status = "Paid";
        $order->save();
        return response()->json([
            'message' => 'Payment updated successfully',
            // 'status' => $user,
            'order' => $order,
        ]);
    }
}
