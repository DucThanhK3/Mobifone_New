<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect()->route('frontend.home');
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
            'password' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    public function showRegisterForm()
    {
        return view('frontend.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // ít nhất 1 chữ thường
                'regex:/[A-Z]/',      // ít nhất 1 chữ hoa
                'regex:/[0-9]/',      // ít nhất 1 số
                'regex:/[@$!%*?&]/'   // ít nhất 1 ký tự đặc biệt
            ],
        ], [
            'password.regex' => 'Mật khẩu phải chứa ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('frontend.login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('frontend.login');
    }
}
