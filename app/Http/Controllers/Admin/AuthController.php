<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;  // Đảm bảo đã có model Session

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

        // Kiểm tra đăng nhập
        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user();
            $ip_address = $request->ip();
            $user_agent = $request->header('User-Agent');
            $token = bin2hex(random_bytes(32));  // Tạo token ngẫu nhiên
            
            // Lưu session vào bảng sessions
            Session::create([
                'id' => $token,
                'user_id' => null, // Nếu không sử dụng user, để null
                'admin_id' => $user->id,  // Lưu admin_id
                'ip_address' => $ip_address,
                'user_agent' => $user_agent,
                'last_activity' => time(),
                'token' => $token,
            ]);

            // Chuyển hướng đến trang quản trị sau khi đăng nhập thành công
            return redirect()->intended('/admin/home');
        }

        // Nếu đăng nhập không thành công
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    // Xử lý đăng xuất
    public function logout(Request $request)
    {
        // Xóa session khỏi bảng sessions
        $user = Auth::guard('admin')->user();
        $token = $request->header('Authorization');  // Giả sử token được gửi qua header

        // Xóa session với token liên quan
        Session::where('token', $token)->delete();

        // Đăng xuất
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
