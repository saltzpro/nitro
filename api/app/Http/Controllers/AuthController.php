<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    //

    public function login(Request $request) {

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $request->session()->regenerate();

        return response()->json([
            'message' => 'Successfully logged in...',
        ], 200);

        
    }

    public function logout(Request $request) {
        
        // $request->user()->currentAccessToken()->delete(); // Revoke current token
        // $request->user()->tokens()->delete(); // Revoke all tokens
        // logout cookie based 
        auth('web')->logout();

        // return response()->noContent(); // 204 No Content
        return response()->json([
            'message' => 'User successfully logout',
        ], 200);
    }
    
}
