<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminSession;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        Log::info('Login attempt', ['credentials' => $credentials]);

        // Kiểm tra đăng nhập với guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            Log::info('Login successful', ['user' => $user->toArray()]);

            $ip_address = $request->ip();
            $user_agent = $request->header('User-Agent');
            $token = bin2hex(random_bytes(32));

            // Lưu session vào bảng AdminSession
            $session = AdminSession::create([
                'id' => $token,
                'admin_id' => $user->id,
                'ip_address' => $ip_address,
                'user_agent' => $user_agent,
                'last_activity' => now()->timestamp,
                'token' => $token,
            ]);
            Log::info('Session created', ['session' => $session->toArray()]);

            // Lưu token vào session
            session(['admin_token' => $token]);

            // Chuyển hướng đến trang quản trị
            return redirect()->intended('/admin/home');
        }

        Log::warning('Login failed', ['credentials' => $credentials]);
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        $token = session('admin_token');
        if ($token) {
            AdminSession::where('token', $token)->delete();
        }

        Auth::guard('admin')->logout();
        session()->forget('admin_token');

        return redirect()->route('admin.login.get');
    }
}