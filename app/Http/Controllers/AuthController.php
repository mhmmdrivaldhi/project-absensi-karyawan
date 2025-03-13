<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index () {
        return view('auth.login');
    }
    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'nik' => htmlspecialchars('required|string'),
            'password' => htmlspecialchars('required|string')
        ]);

        if (Auth::guard('employee')->attempt($credentials)) {
            return redirect('/dashboard');
        }
        return redirect()->back()->withErrors(['login' => 'Failed Login!']);
    }

    public function logoutProcess() {
        if(Auth::guard('employee')->check()) {
            Auth::guard('employee')->logout();
            return redirect('/');
        }
    }
}
