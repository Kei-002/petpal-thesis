<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Employee;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public $successStatus = 200;

    public function index()
    {
        $data = User::all();
        // return response($data, $status = 200);
        return response()->json($data);
        // return response()->json(['error' => $validator->errors()], 401)
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
        $user->role = $input['role'];
        $user->save();
        // Send email after user is created
        // Event::dispatch(new SendMail($user));

        // Check the role of user
        if ($input['role'] === 'customer') {
            $account = new Customer();
        } else {
            $account = new Employee();
        }

        $account->customer_name = $input['customer_name'];
        $account->user_id = $user->id;
        $account->addressline = $input['addressline'];
        $account->phone = $input['phone'];
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $requestData["img_path"] = '/storage/' . $path;
        $account->img_path = $requestData["img_path"];

        $account->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'success' => 'User Created Successfully.',
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
        //
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

        if ($user->role === "customer") {
            $account = Customer::find($user->id);
        } else {
            $account = Employee::find($user->id);
        }

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        // $customer = Customer::find($id);
        // $customer->pets()->delete();
        // $user = User::find($customer->user_id);
        // $user->delete();
        try {
            $user = User::findOrFail($id);
            if ($user->role === 'customer') {
                $customer = Customer::findOrFail($user->id);
                $customer->pets()->delete();
            }
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }
        $user = User::find($id);
        if ($user->role === 'customer') {
            $customer = Customer::find($user->id);
            $customer->pets()->delete();
        }

        $user->delete();
        return response($message = "User Successfully Deleted", $status = 200);
    }
}
