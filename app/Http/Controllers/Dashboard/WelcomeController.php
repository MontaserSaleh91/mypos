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

class WelcomeController extends Controller
{
    public function index()
    {  
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        $categories_count = Category::count();
        $products_count = Product::count();
        // $products_stock = Product::count()->where('stock',$s);
        $clients_count = Client::count();
        $users_count = User::whereRoleIs('admin')->count();

        $sales_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as sum')
        )->groupBy('month')->get();

        return view('dashboard.welcome', compact('categories_count','products_stock', 'products_count', 'clients_count', 'users_count', 'sales_data'));
    
    }//end of index
    
}//end of controller
