<?php

namespace App\Http\Controllers;

use App\Events\SendMail;
use App\Models\Appointment;
use App\Models\Consultation;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $consultations = Consultation::with('appointments')->get();
        $appointments = Appointment::with('consultation', 'customer')->get();

        // $pet = Pet::where('id', $appointments->consultation->id)->first();
        return response()->json(
            $appointments,
        );
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
        // if ($input['password1'] !== $input['password2']) {
        //     return response($message = 'Passwords does not match');
        // }
        $customer = Customer::where('user_id', Auth::id())->first();
        $consultation = new Consultation();
        $consultation->pet_id = $input['this-pet'];
        $consultation->save();

        $appointment = new Appointment();
        $appointment->consultation_id = $consultation->id;
        $appointment->customer_id = $customer->id;
        $appointment->appointment_date = $input['startDate'];
        $appointment->description = $input['description'];
        $appointment->save();

        // return response($message = 'User Successfully Created', $status = 200);
        return response()->json([
            'message' => 'Appointment Placed! Please wait for confirmation.',
            'appointment' => $appointment,
            'consultation' => $consultation,
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


    public function confirmAppointment($id)
    {
        $appointment = Appointment::with('consultation')->where('id', $id)->first();
        $appointment->appointment_status = "Confirmed";
        $appointment->save();
        // $consultation = $appointment->consultation->pet_id;
        $customer = Customer::where('id', $appointment->customer_id)->first();
        $user = User::where('id', $customer->user_id)->first();
        $pet = Pet::where('id', $appointment->consultation->pet_id)->first();

        $data = [
            "pet" => $pet,
            "user" => $user,
            "customer" => $customer,
            "date_today" => Carbon::now(),
            "appointment" => $appointment,
            // "consultation" => $consultation
        ];

        // Event::dispatch(new SendMail($data));
        SendMail::dispatch($data);
        // $user = 
        return response()->json([
            'message' => 'Appointment Confirmed! Email Sent to Customer.',
            'appointment' => $appointment,
            'data' => $data,
            'status' => 200,
        ]);
    }
    
}
