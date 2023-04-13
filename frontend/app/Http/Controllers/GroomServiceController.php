<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroomServices;
// use App\Models\Pet;

class GroomServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = GroomServices::all();
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

        $service = new GroomServices();

        $service->groom_name = $input['groom_name'];
        $service->price = $input['price'];
        $service->description = $request->description;
        $fileName = time() . $request->file('img_path')->getClientOriginalName();
        $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
        $input["img_path"] = '/storage/' . $path;
        $service->img_path = $input["img_path"];

        $service->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'Service Created Successfully.',
            'service' => $service,
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
        $service = GroomServices::findOrFail($id);
        // $owners = Customer::all();
        // $user = User::where("id", $account->user_id)->firstOrFail();
        // $account = Customer::where("user_id", $user->id)->firstOrFail();
        return response()->json([
            'service' => $service,
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

    public function updateService(Request $request, $id)
    {
        // $data = $request->all();
        // dd($request);
        $service = GroomServices::findOrFail($id);
        $service->groom_name = $request->groom_name;
        $service->price = $request->price;
        $service->description = $request->description;
        $img_path = "none";
        if ($request->hasFile('img_path')) {
            $fileName = time() . $request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
            $input["img_path"] = '/storage/' . $path;
            $service->img_path = $input["img_path"];
        }

        $service->save();
        return response()->json([
            'message' => 'Service updated successfully',
            // 'status' => $user,
            'changes' => $request->all(),
            'service' => $service,
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
            $service = GroomServices::findOrFail($id);
            $service->delete();
        } catch (\Exception $error) {
            return response($error, $status = 400);
        }

        return response()->json([
            'message' => 'Service Deleted Successfully',
            'status' => 200,
        ]);
    }
}
