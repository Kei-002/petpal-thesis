<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroomServices;
use App\DataTables\GroomServicesDataTable;
use App\Imports\GroomServiceImport;
use App\Models\Servicesimage;
use Yajra\Datatables\Datatables;
use Yajra\DataTables\Html\Builder;
use View;
use Redirect;
use Illuminate\Support\Facades\File;
// use App\Imports\GroomServiceImport;
use Excel;

class GroomServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return View::make('grooming.index');
    }

    // public function getGservice(GroomServicesDataTable $dataTable)
    // {
    //     return $dataTable->render('grooming.index');
    // }

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

        $grooming = new GroomServices([
            "groom_name" => $request->groom_name,
            "price" => $request->price,
            "description" => $request->description,
        ]);
        $grooming->save();

        if ($request->hasFile("images")) {
            $files = $request->file("images");
            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $request['groomservices_id'] = $grooming->id;
                $request['image'] = $imageName;
                $file->move(\public_path("/storage/images"), $imageName);
                // Servicesimage::create($request->all());
            }
        }

        return Redirect::route('getGservice')->with('success', 'Grooming information updated!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(GroomServices $grooming)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $groomservices = GroomServices::findOrFail($id);
        return view('grooming.edit')->with('groomservices', $groomservices);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $grooming = GroomServices::findOrFail($id);

        $grooming->update([
            "groom_name" => $request->groom_name,
            "price" => $request->price,
            "description" => $request->description,
        ]);

        if ($request->hasFile("images")) {
            $files = $request->file("images");
            foreach ($files as $file) {
                $imageName = time() . '_' . $file->getClientOriginalName();
                $request["groomservices_id"] = $id;
                $request["image"] = $imageName;
                $file->move(\public_path("storage/images"), $imageName);
                Servicesimage::create($request->all());
            }
        }

        return Redirect::route('getGservice')->with('success', 'Grooming information updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $grooming = GroomServices::findOrFail($id);

        $images = Servicesimage::where("groomservices_id", $grooming->id)->get();
        foreach ($images as $image) {
            if (File::exists("images/" . $image->image)) {
                File::delete("images/" . $image->image);
            }
        }
        $grooming->delete();
        return back();
    }

    public function deleteimage($id)
    {

        $images = Servicesimage::findOrFail($id);
        if (File::exists("storage/images/" . $images->image)) {
            File::delete("storage/images/" . $images->image);
        }

        $images->delete();
        return back();
    }


    public function import(Request $request)
    {
        Excel::import(new GroomServiceImport, request()->file('service_upload'));
        return redirect()->back()->with('success', 'Excel file Imported Successfully');
    }
}
