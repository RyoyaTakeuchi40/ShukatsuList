<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:6'
        ]);

         User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json(['message' => 'User Created Successfully.'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json(['message' => 'Authenticated.'], 200);
        } else {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
    }

    public function user()
    {
        return response()->json(Auth::user()->id);
    }

    public function logout(Request $request)
    {
        if (!Auth::user()) {
            return response()->json(['message' => 'Already Unauthenticated.'], 400);
        }
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Unauthenticated.'], 200);
    }
}
