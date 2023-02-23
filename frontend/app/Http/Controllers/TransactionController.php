<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Order;
use App\Models\Orderline;
use App\Models\Disease;
use App\Models\Consultation;
use App\Models\Customer;
use App\Models\Groomservices;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;

use Illuminate\Support\Facades\Auth;
use App\Cart;
use Session;
use Carbon;
use DB;
use View;
use App\DataTables\TransacDatatable;
use Illuminate\Support\Facades\Redirect;

class TransactionController extends Controller
{
    public function index(Request $request)
    {

        //$pet = Pet::has('consults')->get();
        $consultation = Consultation::with('disease')
            ->with('pets')
            ->get();

        // dd($consultation);
        // foreach($consultation as $consult){
        //     foreach($consult->pets as $pet) {
        //         dd($pet->pet_name);
        //     }
        // };

        // $value = $request->session()->get('key');
        // dd($value);
        return view('transaction.index', compact('consultation'));
    }

    public function cindex(Request $request)
    {

        //$pet = Pet::has('consults')->get();
        $order = Order::with('customer')
            ->with('orderlines.groomservices')
            ->get();

        // foreach($order as $orders){
        //         foreach($orders->orderlines as $orderrs){
        //             foreach($orderrs->groomservices as $grooms){
        //                 dd($grooms->groom_name);
        //             }
        //         }
        // };

        //dd($order);
        return view('transaction.cindex', compact('order'));
    }

    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Pet::class, function (ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('pet_name')
                    ->has('consults')
                    ->with('consults.disease');
            })->search($request->input('query'));
        //  dd($searchResults);

        //->registerModel(Consultation::class, ['comments', 'created_at'])
        //dd($searchResults);
        /*foreach($searchResults as $searchresult){
                foreach($searchresult->searchable->consults as $consult){
                dd($consult->comments);
            }
            }
            */



        return view('search', compact('searchResults'));
    }

    public function csearch(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Customer::class, function (ModelSearchAspect $modelSearchAspect) {
                $modelSearchAspect
                    ->addSearchableAttribute('customer_name')
                    ->has('orders')
                    ->with('orders.orderlines');
            })->search($request->input('query'));
        // dd($searchResults);

        //->registerModel(Consultation::class, ['comments', 'created_at'])
        //dd($searchResults);
        /*foreach($searchResults as $searchresult){
                foreach($searchresult->searchable->consults as $consult){
                dd($consult->comments);
            }
            }
            */



        return view('csearch', compact('searchResults'));
    }

    // Cart functions
    public function getIndex()
    {
        $services = Groomservices::all();
        //     $value = session()->get();
        // dd($value);
        return view('explore.index', compact('services'));
    }

    public function getAddToCart(Request $request, $id)
    {
        // dd($request->all());
        $item = Groomservices::find($id);
        $pet = Pet::find($request->pet_id);
        $oldCart = Session::has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->add($item, $pet, $item->id);
        $request->session()->put('cart', $cart);
        Session::put('cart', $cart);
        $request->session()->save();
        // dd(Session::all());
        return redirect()->route('explore');
    }

    //  public function getSelect() {
    //     $customers = Customer::all();
    //     return view('shop.select', compact('customers'));
    //  }

    public function getCart(Request $request)
    {
        if (!Session::has('cart')) {
            return redirect()->route('explore');
        }

        // $pets = Pet::where('customer_id', $request-> get('customer_id'))
        //         -> get();

        $oldCart = Session::get('cart');
        // $request->session()->put('customer_id',  $request->get('customer_id'));
        $customer = Customer::where('user_id', Auth::user()->id)
            ->with('pets')
            ->first();
        // $pets = Pet::where('customer_id', $customer->id)->get();
        $cart = new Cart($oldCart);
        // dd($cart->items);
        return view('explore.shopping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice], compact('customer'));
        // return view('explore.shopping-cart', ['items' => $cart->items, 'totalPrice' => $cart->totalPrice]);
    }




    public function getRemoveItem($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            Session::save();
        } else {
            Session::forget('cart');
        }
        //  return redirect()->route('item.shoppingCart');
        return redirect()->back();
    }

    public function getReduceByOne($id)
    {
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if (count($cart->items) > 0) {
            Session::put('cart', $cart);
            Session::save();
        } else {
            Session::forget('cart');
        }
        // return redirect()->route('item.shoppingCart');
        return redirect()->back();
    }

    public function postCheckout(Request $request)
    {
        // dd(session()->all(), $request -> all());
        if (!Session::has('cart')) {
            return redirect()->route('item.shoppingCart');
        }
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $input = $request->all();
        // dd($cart);
        try {
            DB::beginTransaction();
            $order = new Order();
            $customer =  Customer::where('user_id', Auth::user()->id)->first();
            $order->customer_id = $customer->id;
            // $order->transacation_date = Carbon::now();
            $order->status = 'Processing';
            $order->save();

            foreach ($cart->items as $items) {
                $id = $items['item']['id'];

                $orderline = new Orderline();
                $orderline->service_id = $id;
                // $order->transacation_date = Carbon::now();
                $orderline->pet_id = $items['pet']['id'];
                $orderline->quantity = $items['qty'];
                $orderline->save();
                // dd($orderline->id);
                $order->orderlines()->attach($orderline->id);
                // dd($id);
                // DB::table('transactionline')->insert(
                //     ['service_id' => $id, 
                //      'transac_id' => $order->id,
                //      'pet_id' => $request -> get('pet_id'.$id),
                //      'quantity' => $items['qty']
                //     ]
                //     );
                // dd($order, $orderline);
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            // dd($order, $orderline);
            return redirect()->route('item.shoppingCart')->with(throw $e);
        }


        // $purchases = DB::table('transactionline')
        //             -> join('pet','pet.id','transactionline.pet_id')
        //             ->join('groom_service','groom_service.id','transactionline.service_id')  
        //             -> select('transactionline.id', 'transactionline.transac_id','pet_name','groom_name', 'price', 'quantity',)
        //             -> where('transac_id', $order->id) ->get();
        // $customer = DB::table('customer')->where('id', $order->customer_id) ->first(); 

        $totalPurchase = $cart->totalPrice;
        DB::commit();


        // dd(compact('purchases', 'order', 'customer', 'totalPurchase'));
        Session::forget('cart');
        return View::make('explore.receipt', compact('order', 'totalPurchase'));
        // return redirect() -> route('explore');
    }

    // public function search(Request $request) 
    // {

    //     $search = $request->input('search');
    //     $transactions = DB::table('transactioninfo')
    //         ->join('transactionline','transactionline.transac_id','transactioninfo.id')
    //         ->join('pet','pet.id','transactionline.pet_id')
    //         ->join('groom_service','groom_service.id','transactionline.service_id')     
    //         ->join('customer','customer.id','transactioninfo.customer_id')
    //         ->select('transactioninfo.id', 'transactionline.id as tlID','fname', 'lname',
    //                 'pet.pet_name', 'groom_name', 'price','quantity', 'transacation_date', 'status')
    //         // ->toSql();
    //         ->where('fname','like', '' . $search . '')
    //         ->get();
    //     return View::make('shop.search',compact('transactions'));
    // }

    public function getReceipt()
    {
        return View::make('receipt');
    }

    // public function getTransac(TransacDatatable $dataTable)
    // {
    //     // $customers =  Customer::all();
    //     // dd(Customer::all());'
    //     // dd($dataTable);

    //     // dd($customers);
    //     return $dataTable->render('explore.transac');
    // }

    public function editpaid($id)
    {
        $order = new Order();
        $orderpaid = Order::find($id)->update(['status' => 'Paid']);
        //dd($orderpaid);

        return Redirect::route('transactions')->with('success', 'information updated!');
    }
}
