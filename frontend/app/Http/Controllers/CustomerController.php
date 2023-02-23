<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\CustomerDataTable;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use View;
use Redirect;
use App\Events\SendMail;
use Event;
use Illuminate\Support\Facades\Auth;
use App\Imports\CustomerImport;
use Excel;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getProfile', 'editProfile', 'updateProfile']]);
    }

    public function index()
    {
        return View::make('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $input = $request->all();
        // dd($request->album_id);
        $input['password'] = bcrypt($request->password);

        $user = new User();
        $user->name = $input['customer_name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->role = 'customer';

        $user->save();
        Event::dispatch(new SendMail($user));


        $requestData = $request->all();

        $customer = new Customer();

        $customer->customer_name = $input['customer_name'];
        $customer->user_id = $user->id;
        $customer->addressline = $input['addressline'];
        $customer->phone = $input['phone'];
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $requestData["img_path"] = '/storage/' . $path;
        $customer->img_path = $requestData["img_path"];

        $customer->save();


        //dd($customer);
        // Event::dispatch(new SendMail($listener));

        return Redirect::route('getCustomer')->with('success', 'Customer successfully created!');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::get()->where('id', $id)->first();
        return View::make('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);

        $user->name = $request->customer_name;
        $user->save();


        $customer->customer_name = $request->customer_name;
        $customer->addressline =  $request->addressline;
        $customer->phone =  $request->phone;

        if ($request->img_path != '') {
            $path = public_path();
            $newpath = '/storage/';

            //code for remove old file
            if ($customer->img_path != ''  && $customer->img_path != null) {
                $file_old = $path . $customer->img_path;
                unlink($file_old);
            }

            //upload new file
            $fileName = time() . $request->file('img_path')->getClientOriginalName();
            $npath = $request->file('img_path')->storeAs('images', $fileName, 'public');
            $newimage = '/storage/' . $npath;

            //for update in table
            $customer->update(['img_path' => $newimage]);
        }

        $customer->save();

        return Redirect::route('getCustomer')->with('success', 'Customer information updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer = Customer::find($id);
        $customer->pets()->delete();
        $user = User::find($customer->user_id);
        // $customer->user()->detach();
        $user->delete();
    }

    // public function getCustomer(CustomerDataTable $dataTable)
    // {
    //     // $customers =  Customer::all();
    //     // dd(Customer::all());'
    //     // dd($dataTable);

    //     // dd($customers);
    //     return $dataTable->render('customer.index');
    // }

    public function getProfile()
    {
        $currentuserid = Auth::user()->id;

        //dd($currentuserid);

        //$id = Customer::find($currentuserid)->user_id;

        //dd($id);

        $customer = Customer::where('user_id', $currentuserid)
            ->with('user')
            ->with('pets')
            ->first();

        // dd($customer);
        // foreach($customer->pets as $pet){
        // dd($customer->pets);
        // }



        return view('customer.profile', compact('customer'));
    }

    public function editProfile($id)
    {
        $customer = Customer::get()->where('id', $id)->first();
        return View::make('customer.editprofile', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $id)
    {
        $customer = Customer::find($id);
        $user = User::find($customer->user_id);

        $user->name = $request->customer_name;
        $user->save();


        $customer->customer_name = $request->customer_name;
        $customer->addressline =  $request->addressline;
        $customer->phone =  $request->phone;

        if ($request->img_path != '') {
            $path = public_path();
            $newpath = '/storage/';

            //code for remove old file
            if ($customer->img_path != ''  && $customer->img_path != null) {
                $file_old = $path . $customer->img_path;
                unlink($file_old);
            }

            //upload new file
            $fileName = time() . $request->file('img_path')->getClientOriginalName();
            $npath = $request->file('img_path')->storeAs('images', $fileName, 'public');
            $newimage = '/storage/' . $npath;

            //for update in table
            $customer->update(['img_path' => $newimage]);
        }

        $customer->save();

        return Redirect::route('getProfile')->with('success', 'Customer information updated!');
    }

    // public function import(Request $request)
    // {
    //     Excel::import(new CustomerImport, request()->file('customer_upload'));
    //     return redirect()->back()->with('success', 'Excel file Imported Successfully');
    // }
}
