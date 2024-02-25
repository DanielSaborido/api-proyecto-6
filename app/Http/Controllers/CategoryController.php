<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function show($id)
    {
        $exist = Category::with('tasks')->find($id);
        return isset($exist) ?
            response()->json(['data' => $exist, 'message' =>'Category found']):
            response()->json(['error' => true, 'message' =>'Category not found']);
    }

    public function store(Request $request)
    {
        $inputs = $request->input();
        $response = Category::create($inputs);
        return response()->json(['data' => $response, 'message' => 'Category created']);
    }

    public function update(Request $request, $id)
    {
        $exist = Category::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'Category not found']);
        }

        if ($request->filled('name')) $exist->name = $request->name;
        if ($request->filled('category_photo')) $exist->category_photo = $request->category_photo;

        return response()->json(['data' => $exist, 'message' => 'Category updated']);
    }

    public function destroy($id)
    {
        $exist = Category::find($id);
        if (isset($exist)) {
            $delete = Category::destroy($id);
            return $delete ? response()->json(['data' => $exist,'message' =>'Category deleted']) : response()->json(['error' => true, 'message' => 'Failed to delete category']);
        }
        return response()->json(['error' => true, 'message' =>'Category not found']);
    }
}
