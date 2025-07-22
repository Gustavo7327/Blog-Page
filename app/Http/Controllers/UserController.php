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

        return redirect('/')->with('success', 'User registered successfully');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'User logged in successfully');
        }

        return redirect('/login')->withErrors(['email' => 'Invalid credentials']);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'User logged out successfully');
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


    public function create()
    {
        return view('auth.register');
    }


    public function loginForm()
    {
        return view('auth.login');
    }


    public function show($userId)
    {
        $user = User::findOrFail($userId);
        return view('profile.show', compact('user'));
    }


    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        
        if (Auth::user()->id !== $user->id) {
            return redirect()->route('profile.show', ['userId' => $user->id])->withErrors(['error' => 'You do not have permission to edit this profile']);
        }

        return view('profile.edit', compact('user'));
    }
}
