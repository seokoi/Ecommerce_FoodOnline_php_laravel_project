<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
public function showStatistics()
{
    // Total number of orders
    $totalOrders = Order::count();

    // Total revenue from paid orders only
    $totalRevenue = Order::where('status', 'đã giao')->sum('total');

    // Count of orders grouped by status
    $ordersByStatus = Order::select('status', DB::raw('count(*) as count'))
        ->groupBy('status')
        ->get();

    return view('manager.statistics', compact('totalOrders', 'totalRevenue', 'ordersByStatus'));
}
}
