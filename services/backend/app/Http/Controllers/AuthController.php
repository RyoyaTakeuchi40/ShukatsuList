<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required','unique:users','email'],
            'password' => ['required','min:8','max:16','ascii',Password::min(8)->letters()->numbers()]
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
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(Auth::user());
        } else {
            $user = User::where('email', $request->email)->first();
            if (! $user) {
                return response()->json([
                    'errors' => ['email' => [trans('passwords.user')]]
                ], 422);
            }
            if (! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'errors' => ['password' => [trans('auth.password')]]
                ], 422);
            }
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
    }

    public function user()
    {
        return response()->json(Auth::user());
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Already Unauthenticated.'], 400);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'Unauthenticated.'], 200);
    }
}