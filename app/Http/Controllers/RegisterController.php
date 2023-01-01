<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        // define validator rules
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        // check if validator errors
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // create user in User data
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // check if create user error
        if ($user->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Register Failed!',
            ]);
        }

        // return response create user success!
        return response()->json([
            'success' => true,
            'message' => 'Register Success!',
            'data' => $user
        ]);
    }
}
