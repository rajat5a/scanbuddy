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
        $request->validate([
            'fname'    => 'required|string|max:50',
            'lname'    => 'required|string|max:50',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // 1. User Create Karein
        $user = User::create([
            'name'     => $request->fname . ' ' . $request->lname,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 2. Naya Cafe Automatically Create Karein (User ke liye)
        $user->cafes()->create([
            'name'        => ($request->fname . "'s Cafe"), // Default name
            'slug'        => \Illuminate\Support\Str::slug($request->fname . '-cafe'), 
            'description' => 'Welcome to my digital menu!',
        ]);

        // 3. Login aur Redirect
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account & Cafe created! Welcome to ScanBuddy.');
    }
}

