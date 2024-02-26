<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function show($id)
    {
        $category = Category::with('tasks')->find($id);
        return $category
            ? response()->json(['data' => $category, 'message' => 'Category found'])
            : response()->json(['error' => true, 'message' => 'Category not found']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'category_photo' => 'nullable',
        ]);

        $user = Auth::user();

        $category = new Category($request->all());
        $category->user_id = $user->id;
        $category->save();

        return response()->json(['data' => $category, 'message' => 'Category created']);
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => true, 'message' => 'Category not found']);
        }

        $request->validate([
            'name' => 'required|unique:categories,name,' . $id . '|max:40',
            'category_photo' => 'nullable',
        ]);

        $category->update($request->only(['name', 'category_photo']));

        return response()->json(['data' => $category, 'message' => 'Category updated']);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => true, 'message' => 'Category not found']);
        }

        $category->delete();

        return response()->json(['data' => $category, 'message' => 'Category deleted']);
    }
}
