<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Strict Data Validation (Kachra data andar na aaye)
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'], // Password kam se kam 8 character ho
        ]);

        // 2. Secure Login Attempt
        if (Auth::attempt($credentials)) {
            
            // 3. Hacker se bachne ke liye session regenerate karna zaroori hai
            $request->session()->regenerate();

            // 4. Role-Based Redirect (Aage chal kar hum isme exact roles lagayenge)
            // Example: Agar Super Admin hai toh uske dashboard par, Shop Owner hai toh uski shop par
            if (Auth::user()->email === 'admin@test.com') {
                return redirect()->intended('/')->with('success', 'Welcome Super Admin!');
            }

            return redirect()->intended('/')->with('success', 'Login Successful!');
        }

        // 5. Agar details galat hon, toh specifically mat batao kya galat hai (Security feature)
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        // Session ko destroy karna zaroori hai security ke liye
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Logout hone ke baad wapas signin page par bhej do
        return redirect('/signin')->with('success', 'Aap successfully logout ho gaye hain.');
    }

    public function register(Request $request)
    {
        // 1. Validation: Check if all fields are correct
        $request->validate([
            'fname'    => 'required|string|max:50',
            'lname'    => 'required|string|max:50',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Agar password confirmation hai toh 'confirmed' add karein
        ]);

        // 2. User Creation: Merging first and last name
        $user = User::create([
            'name'     => $request->fname . ' ' . $request->lname,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Password ko encrypt karna zaroori hai
        ]);

        // 3. Auto Login: Signup ke baad user ko sidha login karwa dena
        Auth::login($user);

        // 4. Redirect: Success message ke saath dashboard par bhejein
        return redirect()->route('dashboard')->with('success', 'Account created successfully! Welcome to ScanBuddy.');
    }
}

