<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $exist = User::with('userCategories', 'tasks')->find($id);
        return isset($exist) ?
            response()->json(['data' => $exist, 'message' =>'User found']):
            response()->json(['error' => true, 'message' =>'User not found']);
    }

    public function store(Request $request)
    {
        $inputs = $request->input();
        $response = User::create($inputs);
        return response()->json(['data' => $response, 'message' => 'User created']);
    }

    public function update(Request $request, $id)
    {
        $exist = User::find($id);
        if (!$exist) {
            return response()->json(['error' => true, 'message' =>'User not found']);
        }

        $currentPassword = $request->input('current_password');
        if ($request->filled('password') && !Hash::check($currentPassword, $exist->password)) {
            return response()->json(['error' => true, 'message' => 'Incorrect current password']);
        }

        if ($request->filled('name')) $exist->name = $request->name;
        if ($request->filled('email')) $exist->email = $request->email;
        if ($request->filled('password')) {
            $exist->password = bcrypt($request->password);
        }
        if ($request->filled('profile_photo')) {
            $base64Image = $request->input('profile_photo');
            $formatExtension = explode('/', mime_content_type($base64Image))[1];
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Image));
            $imageName = 'profile_photo_' . time() . '.' . $formatExtension;
            $imagePath = 'profile-photos/' . $imageName;
            Storage::disk('public')->put($imagePath, $image);
            if ($exist->profile_photo) {
                Storage::disk('public')->delete($exist->profile_photo);
            }
            $exist->profile_photo = $imagePath;
        }

        $exist->save();

        return  response()->json(['data' => $exist, 'message' => 'User updated']);
    }

    public function destroy($id)
    {
        $exist = User::find($id);
        if (isset($exist)) {
            $delete = User::destroy($id);
            return $delete & response()->json(['data' => $exist,'message' =>'User deleted']);
        }
        return response()->json(['error' => true, 'message' =>'User not found']);
    }
}
