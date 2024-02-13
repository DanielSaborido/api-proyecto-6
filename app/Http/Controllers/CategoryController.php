<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('tasks')->get();
        return response()->json(['categories' => $categories]);
    }

    public function show(Category $category)
    {
        return response()->json(['category' => $category]);
    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json(['category' => $category], 201);
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->all());
        return response()->json(['category' => $category]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
