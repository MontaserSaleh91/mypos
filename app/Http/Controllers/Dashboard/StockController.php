<?php

namespace App\Http\Controllers\Dashboard;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class StockController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products_out =  Product::where('stock', '<', 1)->get();
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        return view('dashboard.products.stock',compact('products_out','products_stock','categories'));
    }
}
