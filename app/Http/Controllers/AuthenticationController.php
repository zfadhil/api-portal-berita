<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        // DD($user);

        if (!$user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'account' => ['The provided credentials are incorrest'],
            ]);
        }

        return $user->createToken('user login')->plainTextToken;

    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();


        return response()->json([
            'message' => 'anda sudah logout'
        ]);
    }

    public function me(Request $request){
        $user = Auth::user();
        return response()->json($user);
    }
}
