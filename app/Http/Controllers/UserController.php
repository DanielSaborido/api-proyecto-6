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

    public function show(User $user)
    {
        return response()->json(['user' => $user]);
    }

    public function store(Request $request)
    {
        $inputs = $request->input();
        $response = User::create($inputs);
        return $response;
    }

    public function update(Request $request, User $id)
    {
        $exist = User::find($id);
        if (isset($exist)) {
            $exist->name = $request->name;
            $exist->email = $request->email;
            $exist->password = $request->password;
            $exist->profile_photo = $request->profile_photo;
            return $exist->save();
        }else {
            return response()->json(['error' => true,'message' =>'User not found']);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
