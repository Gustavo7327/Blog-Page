<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        Auth::login($user);

        return response()->json(['message' => 'User registered successfully'], 201);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return response()->json(['message' => 'User logged in successfully'], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['message' => 'User logged out successfully'], 200);
    }


    public function update(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $validatedData = $request->validate([
                'name' => 'sometimes|string|max:255',
                'biography' => 'sometimes|string|max:1000',
                'photo_url' => 'sometimes|url|max:255',
            ]);
            
            $user->update($validatedData);
            return response()->json(['message' => 'User updated successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }
}
