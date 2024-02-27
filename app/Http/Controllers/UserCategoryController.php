<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCategoryController extends Controller
{
    public function index()
    {
        return UserCategory::all();
    }

    public function show($id)
    {
        $user_category = UserCategory::with('tasks')->find($id);
        return $user_category
            ? response()->json(['data' => $user_category, 'message' => 'Category found'])
            : response()->json(['error' => true, 'message' => 'Category not found']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_photo' => 'nullable',
            'user_id' => 'required|exists:users,id',
        ]);

        $inputs = $request->input();
        $response = UserCategory::create($inputs);
        return response()->json(['data' => $response, 'message' => 'Category created']);
    }

    public function update(Request $request, $id)
    {
        $exist = UserCategory::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'Category not found']);
        }
        if ($request->filled('name')) $exist->name = $request->name;
        if ($request->filled('category_photo')) $exist->category_photo = $request->category_photo;

        return response()->json(['data' => $exist, 'message' => 'Category updated']);
    }

    public function destroy($id)
    {
        $category = UserCategory::find($id);

        if (!$category) {
            return response()->json(['error' => true, 'message' => 'Category not found']);
        }

        $category->delete();
        return response()->json(['data' => $category, 'message' => 'Category deleted']);
    }
}
