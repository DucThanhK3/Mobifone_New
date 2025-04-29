<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Session;  // Đảm bảo đã có model Session

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        // Lấy token từ header hoặc session
        $token = $request->header('Authorization'); // Hoặc cách khác nếu bạn lưu token trong session hoặc cookie

        // Kiểm tra xem token có hợp lệ trong bảng sessions không
        $session = Session::where('token', $token)
                          ->where('admin_id', '!=', null) // Đảm bảo token là của admin
                          ->where('last_activity', '>', time() - 3600) // Kiểm tra xem session có còn hợp lệ không
                          ->first();

        if (!$session) {
            // Nếu không tìm thấy session hợp lệ, đăng xuất và chuyển hướng tới login
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Bạn không có quyền truy cập trang quản trị hoặc phiên làm việc đã hết hạn.',
            ]);
        }

        // Tiếp tục xử lý yêu cầu
        return $next($request);
    }
}
