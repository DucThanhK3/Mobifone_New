<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use App\Models\GoiCuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThongBaoDuyetGoiCuoc;  // Đảm bảo đã tạo class này
use App\Mail\ThongBaoTuChoiGoiCuoc; // Đảm bảo đã tạo class này

class DangKyGoiCuocController extends Controller
{
    // Hiển thị danh sách đăng ký gói cước
    public function index()
    {
        $dangKys = DangKyGoiCuoc::with('goiCuoc', 'user')->get(); // Lấy tất cả các đăng ký
        return view('admin.dangkygoicuoc.index', compact('dangKys'));
    }

    // Duyệt đăng ký gói cước
    public function approve($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->trang_thai = 1;  // Đánh dấu là đã duyệt
        $dangKy->save();

        // Gửi email thông báo cho người dùng về việc gói cước đã được duyệt
        Mail::to($dangKy->user->email)->send(new ThongBaoDuyetGoiCuoc($dangKy));

        return redirect()->route('admin.dangkygoicuoc.index')->with('success', 'Đăng ký gói cước đã được duyệt!');
    }

    // Từ chối đăng ký gói cước
    public function reject($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->trang_thai = 2;  // Đánh dấu là bị từ chối
        $dangKy->save();

        // Gửi email thông báo cho người dùng về việc gói cước bị từ chối
        Mail::to($dangKy->user->email)->send(new ThongBaoTuChoiGoiCuoc($dangKy));

        return redirect()->route('admin.dangkygoicuoc.index')->with('error', 'Đăng ký gói cước bị từ chối!');
    }
}
