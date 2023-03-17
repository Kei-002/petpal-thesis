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
        $data = Customer::all();
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
        // dd($request->album_id);


        // Check if password and confirmPassword field match
        if ($input['password1'] !== $input['password2']) {
            return response($message = 'Passwords does not match');
        }

        // Encrypt password
        $input['password1'] = bcrypt($request->password1);

        $user = new User();
        $user->name = $input['fname'] . ' ' . $input['lname'];
        $user->email = $input['email'];
        $user->password = $input['password1'];
        $user->role = 'customer';
        $user->save();
        // Send email after user is created
        // Event::dispatch(new SendMail($user));

        // Check the role of user
        $account = new Customer();

        $account->fname = $input['fname'];
        $account->lname = $input['lname'];
        $account->user_id = $user->id;
        $account->addressline = $input['addressline'];
        $account->phone = $input['phone'];
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $input["img_path"] = '/storage/' . $path;
        $account->img_path = $input["img_path"];

        $account->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'User Created Successfully.',
            'user' => $user,
            'status' => 200,
        ]);
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
        $user = User::findOrFail($id);
        $account = Customer::where("user_id", $user->id)->firstOrFail();
        return response()->json([
            'user' => $user,
            'account' => $account,
            'status' => 200,
        ]);
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

    public function updateCustomer(Request $request, $id)
    {
        // $data = $request->all();


        $user = User::find($id);
        $account = Customer::where("user_id", $id)->firstOrFail();

        $user->name = $request->fname . " " . $request->lname;
        $user->email = $request->email;
        $user->save();
        // $account->;

        $account->fname = $request->fname;
        $account->lname = $request->lname;
        $account->addressline = $request->addressline;
        $account->phone = $request->phone;




        return response()->json([
            'message' => 'Customer updated successfully',
            // 'status' => $user,
            'changes' => $request->all(),
            'user' => $user,
            'account' => $account,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->role === 'customer') {
                $customer = Customer::where("user_id", $user->id)->firstOrFail();
                $customer->pets()->delete();
            }
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        $user->delete();
        return response()->json([
            'message' => 'Customer Deleted Successfully',
            'status' => 200,
        ]);
    }
}
