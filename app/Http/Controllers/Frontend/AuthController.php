<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SoDienThoai;
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

        // Kiểm tra đăng nhập với guard 'web'
        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            return redirect()->route('frontend.home');
        }

        // Nếu đăng nhập thất bại, kiểm tra xem có phải admin không
        $admin = \App\Models\Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Nếu là admin, tạo tài khoản user tương ứng nếu chưa có
            $user = User::firstOrCreate(
                ['email' => $admin->email],
                [
                    'name' => $admin->name,
                    'password' => $admin->password,
                    'role' => 'admin',
                ]
            );

            Auth::guard('web')->login($user);
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
            'phone' => 'nullable|string|regex:/^[0-9]{10,15}$/|unique:so_dien_thoai,so',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone.regex' => 'Số điện thoại phải chứa 10-15 chữ số.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
        ]);

        // Tạo user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        // Lưu số điện thoại nếu có
        if ($request->phone) {
            SoDienThoai::create([
                'user_id' => $user->id,
                'so' => $request->phone,
                'chu_so_huu' => $request->name, // Lưu tên người dùng làm chủ sở hữu
            ]);
        }

        return redirect()->route('frontend.login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('frontend.login');
    }
}