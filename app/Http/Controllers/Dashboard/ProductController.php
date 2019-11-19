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

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();

        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->category_id, function ($q) use ($request) {

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(10);

        return view('dashboard.products.index', compact('categories', 'products_stock','products'));

    }//end of index

    public function create()
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories','products_stock'));

    }//end of create

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
        ]);

      

        $request_data = $request->all();

        if ($request->image) {

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if
     
        Product::create([
            'category_id'=>request('category_id'),
            'name'=>request('name'),
            'unit'=>request('unit'),
            'description'=>request('description'),
            'purchase_price'=>request('purchase_price'),
            'sale_price'=>request('sale_price'),
            'stock'=>request('stock'),
        ]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of store

    public function edit(Product $product)
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'products_stock','product'));

    }//end of edit

    public function update(Request $request, Product $product)
    {

        $request->validate([
            'name' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required'
        ]);

       

        
        $request_data = $request->all();

        if ($request->image) {

            if ($product->image != 'default.png') {

                Storage::disk('public_uploads')->delete('/product_images/' . $product->image);
                    
            }//end of if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/product_images/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if
        
        $product->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of update


   

    public function destroy(Product $product)
    {
        if ($product->image != 'default.png') {

            Storage::disk('public_uploads')->delete('/product_images/' . $product->image);

        }//end of if

        $product->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');

    }//end of destroy

    // public function stocks(Product $product){
    //     $product = Product::all();
    //     return $product;
    // }

}//end of controller
