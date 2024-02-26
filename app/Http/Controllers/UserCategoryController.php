<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;

class UserCategoryController extends Controller
{
    public function index()
    {
        return UserCategory::all();
    }

    public function show($id)
    {
        $category = UserCategory::find($id);
        return $category ? response()->json(['data' => $category, 'message' => 'Category found']) :
            response()->json(['error' => true, 'message' => 'Category not found']);
    }

    public function store(Request $request)
    {
        $category = UserCategory::create($request->all());
        return response()->json(['data' => $category, 'message' => 'Category created']);
    }

    public function update(Request $request, $id)
    {
        $category = UserCategory::find($id);

        if (!$category) {
            return response()->json(['error' => true, 'message' => 'Category not found']);
        }

        $category->update($request->all());

        return response()->json(['data' => $category, 'message' => 'Category updated']);
    }

    public function destroy($id)
    {
        $category = UserCategory::find($id);

        if ($category) {
            $category->delete();
            return response()->json(['data' => $category, 'message' => 'Category deleted']);
        }

        return response()->json(['error' => true, 'message' => 'Category not found']);
    }
}
