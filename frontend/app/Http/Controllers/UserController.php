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
        return response()->json(['message' => 'User Created Successfully.',
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
            $account =
                Customer::where("user_id", $user->id)->firstOrFail();
        } else {
            $account = Employee::where("user_id", $user->id)->firstOrFail();
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
        // $data = $request->all();

        $user = User::find($id);

        if ($user->role == "customer") {
            $account = Customer::where("user_id", $id)->firstOrFail();
        } else {
            $account = Employee::where("user_id", $id)->firstOrFail();
        }
        $user->name = $request->fname . " " . $request->lname;
        $user->save();
        // $account->;

        //
        // $customer = Customer::find($id);
        // $customer = $customer->update($request->all());
        // // $customer = Customer::find($id);
        // return response()->json($customer);



        return response()->json([
            'message' => 'User Update Test',
            // 'status' => $user,
            'changes' => $request->all(),
            'user' => $user,
            // 'account' => $account,
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
            'message' => 'User Deleted Successfully',
            'status' => 200,
        ]);
    }
}
