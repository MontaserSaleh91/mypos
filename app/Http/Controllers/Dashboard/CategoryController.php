<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        $categories = Category::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories','products_stock'));

    }//end of index

    public function create()
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        return view('dashboard.categories.create',compact('products_stock'));

    }//end of create

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);
        Category::create([
            'name'=>request('name')
        ]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of store

    public function edit(Category $category)
    {
        $products_stock = DB::table('products')->where('stock', '<', 1)->count();
        return view('dashboard.categories.edit', compact('category','products_stock'));

    }//end of edit

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $this->validate($request,[
            "name"    => "required",
        ]);
        $category->save();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of update

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');

    }//end of destroy

}//end of controller
