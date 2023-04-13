<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    //

    public function getProfile()
    {
        $user = User::find(Auth::id());
        // $test = $user->customer();
        $customer = Customer::where('user_id', '=', Auth::id())->first();
        $pets = Pet::where('customer_id', '=', $customer->id)->get();

        $appointments = Appointment::with('consultation', 'customer')->where('customer_id', $customer->id)->get();
        $orders = Order::with('orderlines')->where('customer_id', $customer->id)->get();
        $transactions = Transaction::with('transactionlines')->where('customer_id', $customer->id)->get();
        return response()->json([
            'pets' => $pets,
            'user' => $user,
            'customer' => $customer,
            'appointments' => $appointments,
            'orders' => $orders,
            'transactions' => $transactions,
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

    public function getOwnedAppointments()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $appointments = Appointment::with('consultation', 'customer')->where('customer_id', $customer->id)->get();

        // $pet = Pet::where('id', $appointments->consultation->id)->first();
        return response()->json(
            $appointments,
        );
    }

    public function getOwnedOrders()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $orders = Order::with('orderlines')->where('customer_id', $customer->id)->get();

        $receipts = DB::table('receiptinfos')
        ->join('receiptlines', 'receiptlines.receipt_id', '=', 'receiptinfos.id')
        ->join('orderinfos', 'receiptlines.item_id', '=', 'orderinfos.id')
        ->join('customers', 'orderinfos.customer_id', '=', 'customers.id')
        ->select('receiptinfos.id', 'total_purchase', 'receipt_path', 'receiptlines.item_id', 'orderinfos.payment_status', 'customers.fname', 'customers.lname', 'customers.addressline')
        ->where([['receiptlines.is_order', '=', true], ['orderinfos.customer_id', '=', $customer->id]])
        ->get();
        // $pet = Pet::where('id', $appointments->consultation->id)->first();
        return response()->json(
            [
                'orders' => $orders,
                'receipts' => $receipts,
            ]
        );
    }

    public function getOwnedTransactions()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        $transactions = Transaction::with('transactionlines')->where('customer_id', $customer->id)->get();
        $receipts = DB::table('receiptinfos')
        ->join('receiptlines', 'receiptlines.receipt_id', '=', 'receiptinfos.id')
        ->join('transactioninfos', 'receiptlines.item_id', '=', 'transactioninfos.id')
        ->join('customers', 'transactioninfos.customer_id', '=', 'customers.id')
        ->select('receiptinfos.id', 'total_purchase', 'receipt_path', 'receiptlines.item_id', 'transactioninfos.payment_status', 'customers.fname', 'customers.lname', 'customers.addressline')
        ->where([['receiptlines.is_order', '=', false], ['transactioninfos.customer_id', '=', $customer->id]])
        ->get();
        // $pet = Pet::where('id', $appointments->consultation->id)->first();
        return response()->json(
            [
                'transactions' => $transactions,
                'receipts' => $receipts,
            ]
        );
    }
}
