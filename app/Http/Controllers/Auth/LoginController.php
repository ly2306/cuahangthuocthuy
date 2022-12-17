<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->route('invoice-index');
        }
        return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng')->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
