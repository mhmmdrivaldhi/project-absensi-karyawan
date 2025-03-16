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
         return redirect('/')->with('error','NIK or Password is Wrong!');
    }

    public function logoutProcess(Request $request) {
        if(Auth::guard('employee')->check()) {
            // Auth::guard('employee')->logout();
            // Tandai bahwa logout diizinkan
        $request->session()->put('logout_allowed', true);

        // Lakukan logout
        Auth::logout();

        // Hapus session logout_allowed
        $request->session()->forget('logout_allowed');

        // Redirect ke halaman login
        return redirect('/')->with('success', 'You have been logged out.');
            // return redirect('/');
        }
    }
}
