<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Pet::with('customer')->get();
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

        $pet = new Pet();

        $pet->pet_name = $input['pet_name'];
        $pet->age = $input['age'];
        $pet->customer_id = $request->owner;
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $input["img_path"] = '/storage/' . $path;
        $pet->img_path = $input["img_path"];

        $pet->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'Pet Created Successfully.',
            'pet' => $pet,
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
        $pet = Pet::findOrFail($id);
        $owners = Customer::all();
        // $user = User::where("id", $account->user_id)->firstOrFail();
        // $account = Customer::where("user_id", $user->id)->firstOrFail();
        return response()->json([
            'pet' => $pet,
            'owners' => $owners,
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

    public function updatePet(Request $request, $id)
    {
        $pet = Pet::findOrFail($id);
        $owner = Customer::where("id", $request->owner)->first();
        $pet->pet_name = $request->pet_name;
        $pet->age = $request->age;
        $pet->customer()->associate($owner);
        $pet->save();
        return response()->json([
            'message' => 'Pet updated successfully',
            // 'status' => $user,
            'changes' => $request->all(),
            'pet' => $pet,
            'owner' => $owner,
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
            $pet = Pet::findOrFail($id);
            $pet->customer()->dissociate();
            $pet->delete();
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        return response()->json([
            'message' => 'Pet Deleted Successfully',
            'status' => 200,
        ]);
    }


    public function customerAddPet(Request $request)
    {
        $input = $request->all();

        $pet = new Pet();

        $customer = Customer::where('user_id', Auth::id())->first();
        $pet->pet_name = $input['pet_name'];
        $pet->age = $input['age'];
        $pet->customer_id = $customer->id;
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $input["img_path"] = '/storage/' . $path;
        $pet->img_path = $input["img_path"];

        $pet->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'Pet Added Successfully.',
            'pet' => $pet,
            'status' => 200,
        ]);
    }
}
