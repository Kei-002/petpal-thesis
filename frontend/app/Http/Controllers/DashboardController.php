<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Pet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function getCounterInfo()
    {
        $customer_total = Customer::all()->count();
        $pet_total = Pet::all()->count();
        $order_total = Order::all()->count();
        $transaction_total =
            Transaction::where('payment_status', "Paid")->count();
        $appointment_total = Appointment::where('appointment_status', "Done")->count();

        $order_pending_total = Order::where('payment_status', "!=", "Paid")->count();
        $transaction_pending_total = Transaction::where('payment_status', "!=", "Paid")->count();

        $appointment_pending_total = Appointment::where('appointment_status', '!=', "Done")->count();

        return response()->json([
            'data' => ['customer_total' => $customer_total, 'pet_total' => $pet_total, 'order_total' => $order_total, 'transaction_total' => $transaction_total, 'appointment_total' => $appointment_total, 'order_pending_total' => $order_pending_total, 'transaction_pending_total' => $transaction_pending_total, 'appointment_pending_total' =>  $appointment_pending_total],
            'status' => 200,
        ]);
    }


    public function getChartInfo()
    {
        $cpm = Customer::select(
            DB::raw('COUNT(*) as info'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
            DB::raw('max(created_at) as createdAt')
        )
            ->where("created_at", ">", \Carbon\Carbon::now()->subMonths(6))
            ->orderBy('createdAt', 'desc')
            ->groupBy('months')
            ->get();


        $opm = Order::select(
            DB::raw('COUNT(*) as info'),
            DB::raw("DATE_FORMAT(created_at,'%M %Y') as months"),
            DB::raw('max(created_at) as createdAt')
        )
            ->where("created_at", ">", \Carbon\Carbon::now()->subMonths(6))
            ->orderBy('createdAt', 'desc')
            ->groupBy('months')
            ->get();

        return response()->json(
            ['customer_per_month' => $cpm, 'order_per_month' => $opm],
        );
    }
}
