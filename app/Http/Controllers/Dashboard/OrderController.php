<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count(); 
        $orders = Order::whereHas('client', function ($q) use ($request) {

            return $q->where('name', 'like', '%' . $request->search . '%');

        })->orderBy('created_at', 'desc')->paginate(5);

        return view('dashboard.orders.index', compact('orders','products_stock'));

    }//end of index

    public function products(Order $order)
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count(); 
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products','products_stock'));

    }//end of products
    
    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);

        }//end of for each

        $order->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    
    }//end of order

}//end of controller
