<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groomservices;
use App\Models\GroomComments;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Askedio\Laravel5ProfanityFilter\ProfanityFilter;

class ExploreController extends Controller
{
    public function index()
    {
        // $customer = Customer::all();
        $grooming = Groomservices::with('images')->get();
        $currentuserid = Auth::user()->id;
        $pet = Customer::where('user_id', $currentuserid)
            ->with('pets')
            ->first();

        //dd($pet);

        return view('explore.index', compact('grooming', 'pet'));
    }

    public function moreinfo($id)
    {
        $grooming = Groomservices::with('images')->find($id);
        $comment = GroomComments::where('groomservices_id', $id)
            ->orderBy('created_at')
            ->get();
        //dd($comment);
        return view('explore.info', compact('grooming', 'comment'));
    }

    public function newcomment(Request $request)
    {
        try {
            $comms = app('profanityFilter')->filter($request->input('comment'));
            $comm = new GroomComments;

            $comm->groomservices_id = $request->input('groom_id');
            $comm->guestname = $request->input('guest_name');
            $comm->comments = $comms;

            $comm->save();
        } catch (\Exception $e) {

            throw $e;
            // dd($groom);

        }

        return redirect()->back()->with('status', 'Comment Added Successfully');
    }
}
