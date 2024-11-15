<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $order_counts = Order::count();
        $customers_count = User::count();
        $total_sale = Order::where('status', 'delivered')->sum('total_charge');
        $total_products = Product::count();
        $total_sale_on_curr_month = Order::where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total_charge');
        $total_sale_last_month = Order::where('status', 'delivered')
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total_charge');
            $last_month_name = Carbon::now()->subMonth()->format('M');
        return view('admin.home.index', compact('order_counts', 'customers_count', 'total_sale', 'total_products', 'total_sale_on_curr_month','total_sale_last_month','last_month_name'));
    }
}
