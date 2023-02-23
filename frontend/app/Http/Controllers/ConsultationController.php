<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Employee;
use App\Models\Disease;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Redirect;
use App\Events\ConsultMail;
use Carbon\Carbon;
use Event;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Customer::has('pets')->get();
        $diseases = Disease::all();
        return view('consult.index', compact('customer', 'diseases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dropdowns(Request $request)
    {
        if ($request->customerId) {
            $pets = Pet::where('customer_id', $request->customerId)->get();
            if ($pets) {
                return response()->json(['status' => 'success', 'data' => $pets], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'No pets found'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Please select pet'], 500);
    }

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
        // dd($request->all(), Auth::id());
        DB::beginTransaction();

        try {
            $input = $request->all();
            $user_id = Employee::where('user_id', Auth::id())
                ->first();

            //dd($user_id);
            $consult = new Consultation();
            // $consults = new Consultation(); 

            $data = [
                "pet_id" => $input['pet'],
                "disease_id" =>  $input['disease'],
                "employee_id" => $user_id->id,
                "fee" => $input['fee'],
                "created_at" => Carbon::now(),
                "comments" => $input['comment']
            ];
            // $consult->pet_id = $input['pet'];
            // $consult->disease_id = $input['disease'];
            // $consult->employee_id = $user_id->id;
            // $consult->fee = $input['fee'];
            // $consult->comments = $input['comment'];

            $consult->pets()->attach(
                $data['pet_id'],
                [
                    'disease_id' => $data['disease_id'],
                    'employee_id' =>  $data['employee_id'],
                    'fee' => $data['fee'],
                    'comments' => $data['comments']
                ]
            );
            // $consult->save();
            // dd($consult);
            // Consultation::create($input);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return Redirect::to('consult')->with('error', $e->getMessage());
        }

        DB::commit();
        Event::dispatch(new ConsultMail($data));
        // dd('testWon');
        return Redirect::to('consult')->with('success', 'Consultation success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function show(Consultation $consultation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultation $consultation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultation $consultation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultation  $consultation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultation $consultation)
    {
        //
    }
}
