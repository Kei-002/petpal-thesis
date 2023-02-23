<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use App\DataTables\EmployeeDataTable;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use View;
use Redirect;
use App\Events\SendMail;
use App\Imports\EmployeeImport;
use Event;
use Excel;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $input['password'] = bcrypt($request->password);

        $user = new User();
        $user->name = $input['employee_name'];
        $user->email = $input['email'];
        $user->password = $input['password'];
        $user->role = 'employee';

        $user->save();
        Event::dispatch(new SendMail($user));


        $requestData = $request->all();

        $employee = new Employee();

        $employee->employee_name = $input['employee_name'];
        $employee->user_id = $user->id;
        $employee->addressline = $input['addressline'];
        $employee->phone = $input['phone'];
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $requestData["img_path"] = '/storage/' . $path;
        $employee->img_path = $requestData["img_path"];

        $employee->save();


        //dd($customer);
        // Event::dispatch(new SendMail($listener));

        return Redirect::route('getEmployee')->with('success', 'Employee successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $employee = Employee::with('user')
            ->get()
            ->where('id', $id)
            ->first();
        // dd($employee->user);
        // $user = User::get()->where('id')
        // $roles = ['employee', 'vet', 'groomer'];
        return View::make('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $user = User::find($employee->user_id);

        $user->name = $request->employee_name;
        if ($request->role == 'admin') {
            $user->is_admin = 1;
        }
        $user->role = $request->role;
        $user->save();


        $employee->employee_name = $request->employee_name;
        $employee->addressline =  $request->addressline;
        $employee->phone =  $request->phone;

        if ($request->img_path != '') {
            $path = public_path();
            $newpath = '/storage/';

            //code for remove old file
            if ($employee->img_path != ''  && $employee->img_path != null) {
                $file_old = $path . $employee->img_path;
                unlink($file_old);
            }

            //upload new file
            $fileName = time() . $request->file('img_path')->getClientOriginalName();
            $npath = $request->file('img_path')->storeAs('images', $fileName, 'public');
            $newimage = '/storage/' . $npath;

            //for update in table
            $employee->update(['img_path' => $newimage]);
        }

        $employee->save();

        return Redirect::route('getEmployee')->with('success', 'Employee information updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);
        // $customer->pets()->delete();
        $user = User::find($employee->user_id);
        // $customer->user()->detach();
        $user->delete();
        // $employee->delete();
    }

    // public function getEmployee(EmployeeDataTable $dataTable)
    // {

    //     return $dataTable->render('employee.index');
    // }

    // public function import(Request $request)
    // {
    //     Excel::import(new EmployeeImport, request()->file('employee_upload'));
    //     return redirect()->back()->with('success', 'Excel file Imported Successfully');
    // }
}
