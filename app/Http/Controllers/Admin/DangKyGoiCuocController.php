<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ThongBaoDuyetGoiCuoc;
use App\Mail\ThongBaoTuChoiGoiCuoc;

class DangKyGoiCuocController extends Controller
{
    // Hiển thị danh sách đăng ký gói cước
    public function index()
    {
        $dangKys = DangKyGoiCuoc::with('goiCuoc', 'user', 'soDienThoai')->get();
        return view('admin.dangkygoicuoc.index', compact('dangKys'));
    }

    // Duyệt đăng ký gói cước
    public function approve($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->trang_thai = 'da_duyet';
        $dangKy->save();

        // Gửi email thông báo
        if ($dangKy->user) {
            Mail::to($dangKy->user->email)->send(new ThongBaoDuyetGoiCuoc($dangKy));
        }

        return redirect()->route('admin.dang_ky_goi_cuoc.index')->with('success', 'Đăng ký gói cước đã được duyệt!');
    }

    // Từ chối đăng ký gói cước
    public function reject($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->trang_thai = 'tu_choi';
        $dangKy->save();

        // Gửi email thông báo
        if ($dangKy->user) {
            Mail::to($dangKy->user->email)->send(new ThongBaoTuChoiGoiCuoc($dangKy));
        }

        return redirect()->route('admin.dang_ky_goi_cuoc.index')->with('error', 'Đăng ký gói cước bị từ chối!');
    }
}