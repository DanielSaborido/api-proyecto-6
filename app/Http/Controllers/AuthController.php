<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function checkPassword(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                return response()->json(['message' => 'Password correct']);
            } else {
                return response()->json(['error' => true, 'message' => 'Incorrect password']);
            }
        } else {
            return response()->json(['error' => true, 'message' => 'User not found']);
        }
    }
}
