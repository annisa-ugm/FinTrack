<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required'
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();

    //         // Simpan session
    //         session(['user_id' => $user->id_user]);

    //         return response()->json([
    //             'message' => 'Login successful',
    //             'user' => $user,
    //             'session_id' => session()->getId(),
    //         ], 200);
    //     }

    //     return response()->json(['message' => 'Invalid credentials'], 401);
    // }

    // public function logout(Request $request)
    // {
    //     if (Auth::check()) {
    //         Auth::logout();
    //         $request->session()->invalidate();
    //         $request->session()->regenerateToken();

    //         return response()->json(['message' => 'Logout successful'], 200);
    //     }

    //     return response()->json(['message' => 'User not logged in'], 400);
    // }

    // public function me()
    // {
    //     if (Auth::check()) {
    //         return response()->json(['user' => Auth::user()], 200);
    //     }

    //     return response()->json(['message' => 'Unauthorized'], 401);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.']
            ]);
        }

        // dd($user);

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function me(Request $request)
    {
        Log::info('Fungsi me() dipanggil');

        $user = $request->user();
        if (!$user) {
            Log::error('User tidak ditemukan!');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user], 200);
    }
}
