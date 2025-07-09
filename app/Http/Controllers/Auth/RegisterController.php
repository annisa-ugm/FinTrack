<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed',
            ]);

            if ($validator->fails()) {
                throw ValidationException::withMessages($validator->errors()->toArray());
            }

            $user = User::create([
                'id_user' => User::generateId(),
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => $request->password,  // Auto hash via mutator
            ]);

            return response()->json([
                'message' => 'User registered successfully.',
                'user' => $user
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Register error: ' . $e->getMessage());
            return response()->json([
                'message' => 'An unexpected error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
