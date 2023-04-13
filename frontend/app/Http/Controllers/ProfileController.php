<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //

    public function getProfile()
    {
        $user = User::find(Auth::id());
        // $test = $user->customer();
        $customer = Customer::where('user_id', '=', Auth::id())->first();
        $pets = Pet::where('customer_id', '=', $customer->id)->get();

        return response()->json([
            'pets' => $pets,
            'user' => $user,
            'customer' => $customer,
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = User::find($id);
        $account = Customer::where('user_id', '=', $user->id)->first();
        $user->name = $request->fname . " " . $request->lname;
        $user->email = $request->email;
        $user->save();
        // $img_path = "none";

        if ($request->hasFile('img_path')) {
            $fileName = time() . $request->file('img_path')->getClientOriginalName();
            $path = $request->file('img_path')->storeAs('images', $fileName, 'public');
            $input["img_path"] = '/storage/' . $path;
            $account->img_path = $input["img_path"];
        }

        $account->fname = $request->fname;
        $account->lname = $request->lname;
        $account->addressline = $request->addressline;
        $account->phone = $request->phone;
        $account->save();
        // $account->;


        return response()->json([
            'message' => 'User updated successfully',
            // 'status' => $user,
            'changes' => $request->all(),
            'user' => $user,
            'account' => $account,
        ]);
    }
}
