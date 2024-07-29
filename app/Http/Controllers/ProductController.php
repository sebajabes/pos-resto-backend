<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // index
    public function index(Request $request) {
        // get all products with pagination
        // $products = Product::when($request->input('name'), function($query, $name) {
        //     $query->where('name', 'like', '%'.$name.'%')->paginate(10);
        // });

        $products = Product::paginate(10);
        return view('pages.products.index', compact('products'));
    }

    // create
    public function create() {
        $categories = DB::table('categories')->get();
        return view('pages.products.create', compact('categories'));
    }

    // store
    public function store(Request $request) {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'stock' => 'required|numeric',
                'status' => 'required|boolean',
                'is_favorite' => 'required|boolean',
            ]
        );

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;
        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        return redirect()->route('pages.products.index')->with('success', 'Product created successfully');


    }

    // show
    public function show($id) {
        // return view
        return view('pages.products.show', compact('product'));
    }

    // edit
    public function edit($id) {
        // return view
        $product = Product::findOrFail($id);
        $categories = DB::table('categories')->get();
        return view('pages.products.edit', compact('product', 'categories'));
    }

    // update

    public function update(Request $request, $id) {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'status' => 'required',
                'is_favorite' => 'required',
            ]
        );

        // update product
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->is_favorite = $request->is_favorite;
        $product->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/products', $product->id . '.' . $image->getClientOriginalExtension());
            $product->image = 'storage/products/' . $product->id . '.' . $image->getClientOriginalExtension();
            $product->save();
        }

        // redirect
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // destroy
    public function destroy($id) {
        // find product by id
        $product = Product::find($id);

        // delete product
        $product->delete();

        // redirect
        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
