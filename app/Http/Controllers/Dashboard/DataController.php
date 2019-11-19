<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Client;
use App\Order;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class DataController extends Controller
{
    public function index(){
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        

        $sales_data_day = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('SUM(total_price) as price'),
            DB::raw('SUM(total_profit) as profit'),
            DB::raw('SUM(total_purchase) as purchase')
        )->groupBy('year','month','day')->get();

        $sales_data_month = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('SUM(total_price) as price'),
            DB::raw('SUM(total_profit) as profit'),
            DB::raw('SUM(total_purchase) as purchase')
        )->groupBy('year','month')->get();

        $sales_data_year = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('SUM(total_price) as price'),
            DB::raw('SUM(total_profit) as profit'),
            DB::raw('SUM(total_purchase) as purchase')
        )->groupBy('year')->get();

        return view('dashboard.data',compact('sales_data_day','sales_data_month','sales_data_year','products_stock'));
    }
}
