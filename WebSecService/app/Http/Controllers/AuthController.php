<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Account created successfully!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            return redirect()->route('profile')->with('success', 'Login successful!');
        }
    
        return back()->withErrors(['email' => 'Invalid email or password']);
    }
    
    public function profile()
    {
        $user = Auth::user(); 
        return view('profile', compact('user'));
    }
    
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

  

public function changePassword(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->old_password, $user->password)) {
        return back()->withErrors(['old_password' => 'Current password is incorrect']);
    }

    DB::table('users')
        ->where('id', $user->id)
        ->update(['password' => Hash::make($request->new_password)]);

    return redirect()->route('dashboard')->with('success', 'Password changed successfully!');
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
