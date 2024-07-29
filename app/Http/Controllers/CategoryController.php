<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // index
    public function index(Request $request)
    {
        // get all categories with pagination
        // $categories = Category::when($request->input('name'), function($query, $name) {
        //     $query->where('name', 'like', '%'.$name.'%')->paginate(10);
        // });
        $categories = Category::paginate(10);

        return view('pages.categories.index', compact('categories'));
    }

    // create
    public function create()
    {
        return view('pages.categories.create');
    }

    // store
    public function store(Request $request)
    {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            ]
        );

        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/category', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/category/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    // show
    public function show($id)
    {
        $category = Category::find($id);
        return view('pages.categories.show', compact('category'));
    }

    // edit
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.categories.edit', compact('category'));
    }

    // update
    public function update(Request $request, $id)
    {
        // validate
        $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
            ]
        );

        // update category
        $category = Category::find($id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image->storeAs('public/category', $category->id . '.' . $image->getClientOriginalExtension());
            $category->image = 'storage/category/' . $category->id . '.' . $image->getClientOriginalExtension();
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
