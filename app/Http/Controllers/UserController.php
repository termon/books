<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // get registration form
    public function create()
    {
        return view('user.register');
    }

    // post registration handler – create user
    public function store(Request $request)
    {
        // validate request form values
        $credentials = $request->validate([
            'name'  => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['confirmed', 'min:6']
        ]);

        // create user
        $user = User::create($credentials);

        // login newly authenticated user
        Auth::login($user);

        return redirect()->route("home")
            ->with('success', "Logged in Successfully");
    }

    // get login form
    public function login()
    {
        return view('user.login');
    }

    // post login handler – authenticate user session
    public function authenticate(Request $request)
    {
        // validate request form values
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // attempt to authenticate and generate session
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route("home")
                ->with('success', "Logged in Successfully");
        }

        // invalid credentials
        return redirect()->back()->withErrors([
            'email' => 'Invalid credentials',
            'password' => 'Invalid credentials'
        ]);
    }
    // post logout handler – delete user session
    public function logout(Request $request)
    {
        // remove authentication info from user session
        Auth::logout();

        // invalidate the user session
        $request->session()->invalidate();

        // regenerate the CSRF token
        $request->session()->regenerateToken();

        // redirect to home or login route
        return redirect()
            ->route("login")
            ->with('success', "Successfully logged out");
    }
}
