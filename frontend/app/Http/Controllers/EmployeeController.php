<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
// use App\DataTables\CustomerDataTable;
// use Yajra\Datatables\Datatables;
// use Yajra\DataTables\Html\Builder;
use View;
use Redirect;
use App\Events\SendMail;
use Illuminate\Support\Facades\Auth;


class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::all();
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
        $user->role = 'employee';
        $user->save();
        // Send email after user is created
        // Event::dispatch(new SendMail($user));

        // Check the role of user
        $account = new Employee();

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
            'message' => 'Employee Created Successfully.',
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
        $account = Employee::findOrFail($id);
        $user = $account->user;
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

    public function updateEmployee(Request $request, $id)
    {
        // $data = $request->all();
        // dd($request);
        $account = Employee::findOrFail($id);
        $user = User::where("id", $account->user_id)->firstOrFail();

        // $user = User::find($id);
        // $account = Customer::where("user_id", $id)->firstOrFail();

        $user->name = $request->fname . " " . $request->lname;
        $user->email = $request->email;
        $user->save();
        // $account->;

        $account->fname = $request->fname;
        $account->lname = $request->lname;
        $account->addressline = $request->addressline;
        $account->phone = $request->phone;
        $account->save();

        return response()->json([
            'message' => 'Employee updated successfully',
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
            $account = Employee::findOrFail($id);
            $user = User::where("id", $account->user_id)->firstOrFail();
            $user->delete();
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        return response()->json([
            'message' => 'Employee Deleted Successfully',
            'status' => 200,
        ]);
    }
}
