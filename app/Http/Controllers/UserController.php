<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        $exist = User::find($id);
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

        ($request->filled('name')) & $exist->name = $request->name;
        ($request->filled('email')) & $exist->email = $request->email;
        ($request->filled('password')) & $exist->password = $request->password;
        ($request->filled('profile_photo')) & $exist->profile_photo = $request->profile_photo;

        return $exist->save() ?
            response()->json(['data' => $exist, 'message' => 'User updated']):
            response()->json(['error' => true, 'message' => 'Failed to update user']);
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
