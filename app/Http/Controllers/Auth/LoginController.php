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
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid email or password.']
                ]);
            }

            // Batasi maksimal 4 token aktif per user
            $tokens = $user->tokens()->orderBy('created_at')->get();
            if ($tokens->count() >= 4) {
                // Hapus token tertua
                $tokens->first()->delete();
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful.',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log unexpected errors
            Log::error('Login error: ' . $e->getMessage());

            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        // $request->user()->tokens()->delete();
        // Sementara pake ini, setelah pppl diganti lagi
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function users(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            Log::error('User not found!');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['user' => $user], 200);
    }
}
