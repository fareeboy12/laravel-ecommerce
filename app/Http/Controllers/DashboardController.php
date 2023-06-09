<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $orders = $user->orders()->with(['orderItems.product'])->get();

        return view('accounts', compact('user', 'orders'));
    }

    public function getStatistics()
    {
        $totalOrders = Order::count();
        $creditCardOrders = Order::where('payment_method', 'credit_card')->sum('total');
        $cashOnDeliveryOrders = Order::where('payment_method', 'cash_on_delivery')->sum('total');

        $processingOrders = Order::where('order_status', 'processing')->count();
        $dispatchedOrders = Order::where('order_status', 'dispatched')->count();
        $finishedOrders = Order::where('order_status', 'finished')->count();
    
        $yesterday = Carbon::yesterday();
        $yesterdayOrders = Order::whereDate('created_at', $yesterday)->count();
        $yesterdayCreditCardOrders = Order::where('payment_method', 'credit_card')
            ->whereDate('created_at', $yesterday)
            ->sum('total');
        $yesterdayCashOnDeliveryOrders = Order::where('payment_method', 'cash_on_delivery')
            ->whereDate('created_at', $yesterday)
            ->sum('total');
    
        $currentMonth = Carbon::now()->startOfMonth();
        $currentMonthSales = Order::where('created_at', '>=', $currentMonth)->sum('total');
    
        $allTimeSales = Order::sum('total');
    
        // Retrieve the sales data for each day
        // Retrieve the sales data for each day
        $salesData = Order::selectRaw('DATE(created_at) AS date, COUNT(*) AS orders, SUM(total) AS sales')
        ->groupBy('date')
        ->get();
    
        // Retrieve the number of orders by date
        $chartData = [];
        foreach ($salesData as $data) {
            $formattedDate = Carbon::parse($data->date)->format('d F Y');
            $chartData[] = [
                'date' => $formattedDate,
                'sales' => $data->sales,
                'orders' => $data->orders,
            ];
        }
    
        $data = [
            'totalOrders' => $totalOrders,
            'processingOrders' => $processingOrders,
            'dispatchedOrders' => $dispatchedOrders,
            'finishedOrders' => $finishedOrders,
            'creditCardOrders' => $creditCardOrders,
            'cashOnDeliveryOrders' => $cashOnDeliveryOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'yesterdayCreditCardOrders' => $yesterdayCreditCardOrders,
            'yesterdayCashOnDeliveryOrders' => $yesterdayCashOnDeliveryOrders,
            'currentMonthSales' => $currentMonthSales,
            'allTimeSales' => $allTimeSales,
            'chartData' => $chartData,
        ];
    
        return View::make('dashboard', $data);
    }
    


}
