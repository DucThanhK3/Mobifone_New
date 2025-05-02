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
        Log::info('Admin login attempt', ['email' => $credentials['email']]);

        // Kiểm tra đăng nhập với guard 'admin'
        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            Log::info('Admin login successful', ['admin' => $admin->toArray()]);

            $ip_address = $request->ip();
            $user_agent = $request->header('User-Agent');
            $token = bin2hex(random_bytes(32));

            // Lưu session vào bảng AdminSession
            try {
                $session = AdminSession::create([
                    'id' => $token,
                    'admin_id' => $admin->id,
                    'ip_address' => $ip_address,
                    'user_agent' => $user_agent,
                    'last_activity' => now()->timestamp,
                    'token' => $token,
                ]);
                Log::info('Admin session created', ['session' => $session->toArray()]);
            } catch (\Exception $e) {
                Log::error('Failed to create admin session', ['error' => $e->getMessage()]);
                Auth::guard('admin')->logout();
                return back()->withErrors(['email' => 'Lỗi hệ thống khi tạo session.']);
            }

            // Lưu token vào session
            session(['admin_token' => $token]);

            // Chuyển hướng đến trang quản trị
            return redirect()->intended('/admin/home');
        }

        Log::warning('Admin login failed', ['email' => $credentials['email']]);
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
            Log::info('Admin session deleted', ['token' => $token]);
        }

        Auth::guard('admin')->logout();
        session()->forget('admin_token');

        return redirect()->route('admin.login.get');
    }
}