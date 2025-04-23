<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use App\Models\GoiCuoc;
use App\Models\SoDienThoai;
use Illuminate\Http\Request;

class GoiCuocDichVuFrontendController extends Controller
{
    // Hiển thị danh sách gói cước và trạng thái đăng ký
    public function index()
    {
        $goiCuocs = GoiCuoc::all(); // Lấy tất cả các gói cước
        $soDienThoai = SoDienThoai::first(); // Giả lập: lấy số điện thoại đầu tiên

        $goiDaDangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoai->id)
            ->pluck('goi_cuoc_id')
            ->toArray();

        return view('frontend.goicuocdichvu.index', compact('goiCuocs', 'soDienThoai', 'goiDaDangKy'));
    }

    // Xử lý đăng ký gói cước (yêu cầu duyệt)
    public function dangKy(Request $request)
    {
        $request->validate([
            'so_dien_thoai_id' => 'required|exists:so_dien_thoai,id',
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
        ]);

        // Kiểm tra đã đăng ký chưa
        $daDangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $request->so_dien_thoai_id)
            ->where('goi_cuoc_id', $request->goi_cuoc_id)
            ->exists();

        if ($daDangKy) {
            return redirect()->back()->with('error', 'Số điện thoại đã đăng ký gói này.');
        }

        // Tạo đăng ký mới với trạng thái 'pending'
        DangKyGoiCuoc::create([
            'so_dien_thoai_id' => $request->so_dien_thoai_id,
            'goi_cuoc_id' => $request->goi_cuoc_id,
            'trang_thai' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Đăng ký gói cước thành công! Chờ admin duyệt.');
    }

    // Hiển thị lịch sử đăng ký gói cước
    public function lichSu()
    {
        $soDienThoai = SoDienThoai::first(); // Giả lập: lấy số đầu tiên
        $dangKyGoiCuocs = DangKyGoiCuoc::with('goiCuoc')
            ->where('so_dien_thoai_id', $soDienThoai->id)
            ->get();

        return view('frontend.goicuocdichvu.lichsu', compact('dangKyGoiCuocs', 'soDienThoai'));
    }

    // Hủy đăng ký gói cước
    public function destroy($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->delete();

        return redirect()->route('frontend.goicuocdichvu.lichsu')->with('success', 'Hủy đăng ký thành công!');
    }
}
