<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $dir = "auth.";

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view($this->dir . "login");
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        if(Auth::attempt($credentials)) {
            return redirect()
                ->intended(route('dashboard'))
                ->with('status', [
                    'type' => 'success',
                    'msg' => 'Successfully Logged-in'
                ]);
        }
        return redirect()->back()->with('error', 'The credentials do not match our credentials');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
