<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Event;
use App\Models\Customer;
use App\Models\User;
// use App\DataTables\CustomerDataTable;
// use Yajra\Datatables\Datatables;
// use Yajra\DataTables\Html\Builder;
use View;
use Redirect;
use App\Events\SendMail;
use Illuminate\Support\Facades\Auth;
use App\Imports\CustomerImport;
use Excel;
use Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'lname' => 'required|min:3',
            'fname' => 'required|min:3',
            'address' => 'required',
        ]);

        $input = $request->all();
        // Encrypt Password
        $input['password'] = bcrypt($request->password);


        // Create User first
        $user = new User();
        $user->name = $input['customer_name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->role = 'customer';

        $user->save();
        // Send email when user is created
        Event::dispatch(new SendMail($user));

        $requestData = $request->all();
        // Create Customer next
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


        return Redirect::route('getCustomer')->with('success', 'Customer successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
