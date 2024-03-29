<?php

namespace App\Http\Controllers;

use App\Models\UserCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    private function handleCategoryPhoto(Request $request, $model)
    {
        if ($request->filled('category_photo')) {
            $base64Image = $request->input('category_photo');
            $formatExtension = explode('/', mime_content_type($base64Image))[1];
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $imageName = 'category_photo_' . time() . '.' . $formatExtension;
            $imagePath = 'category-photos/' . $imageName;
            Storage::disk('public')->put($imagePath, $image);
            if ($model->category_photo) {
                Storage::disk('public')->delete($model->category_photo);
            }
            $model->category_photo = $imagePath;
        }
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
        $this->handleCategoryPhoto($request, $response);
        return response()->json(['data' => $response, 'message' => 'Category created']);
    }

    public function update(Request $request, $id)
    {
        $exist = UserCategory::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'Category not found']);
        }
        if ($request->filled('name')) $exist->name = $request->name;
        $this->handleCategoryPhoto($request, $exist);

        $exist->save();

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
