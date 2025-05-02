<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use Illuminate\Http\Request;

class GoiCuocController extends Controller
{
    public function index()
    {
        $dangKyGoiCuocs = DangKyGoiCuoc::with('goiCuoc', 'soDienThoai')->get();
        return view('admin.dangkygoicuoc.index', compact('dangKyGoiCuocs'));
    }

    public function approve(Request $request, $id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->update([
            'trang_thai' => 'da_duyet',
        ]);
        return redirect()->route('admin.dangkygoicuoc.index')->with('success', 'Đăng ký đã được duyệt!');
    }

    public function reject(Request $request, $id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->update([
            'trang_thai' => 'tu_choi',
            'ly_do_tu_choi' => $request->input('ly_do_tu_choi', 'Không có lý do'),
        ]);
        return redirect()->route('admin.dangkygoicuoc.index')->with('success', 'Đăng ký đã bị từ chối!');
    }
}