<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Hash;



use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIcontroller extends Controller
{
    // we will use user table of the default db to create the user
    //this method will hit by post method which will contain [email and password] 
    public function register(Request $request)
    {
        try {
            // Validate request data
            $validate_data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'name' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation failure
            return response()->json([
                'errors' => $e->errors()
            ], 422);  // 422 Unprocessable Entity (typical for validation errors)
        }
        User::create([
            'name' => $validate_data['name'],
            'email' => $validate_data['email'],
            'password' => bcrypt($validate_data['password'])
        ]);

        return response()->json([
            'status' => true,
            'message' => "User register successfully call login method to get the api",
            'data' => []
        ]);
    }
    //post method which will contain the registerd email and password and will return the api key
    public function login(Request $request)
    {
        try {
            // Validate request data
            $validate_data = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'name' => 'required|string'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation failure
            return response()->json([
                'errors' => $e->errors()
            ], 422);  // 422 Unprocessable Entity (typical for validation errors)
        }

        $user = User::where('email', $validate_data['email'])->first();
        if (!empty($user)) {
            if (Hash::check($validate_data['password'], $user->password)) {
                $token = $user->createToken('MY-AUTH-token')->accessToken;
                return response()->json([
                    'status' => true,
                    'message' => "Your Credential",
                    'data' => [
                        'name' => $validate_data['name'],
                        'email' => $validate_data['email'],
                        'api-token' => $token
                    ]
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "wrong password",
                    'data' => []
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "email is wrong",
                'data' => []
            ]);
        }
    }
    //these 2 are protected method and need token
    public function profile(Request $request) {
        $user_data=auth()->user();
        return response()->json([
            'status' => true,
            'message' => "your data",
            'data' => $user_data
        ]);
    }
    public function logout(Request $request) {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => true,
            'message' => "Used deleted",
            'data' => []
        ]);
    }
}
