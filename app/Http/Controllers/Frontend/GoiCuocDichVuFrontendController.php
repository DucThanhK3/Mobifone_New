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
        $soDienThoaiMacDinh = SoDienThoai::first(); // Giả lập lấy số điện thoại mặc định

        // Lấy danh sách các gói cước đã đăng ký của số điện thoại mặc định
        $goiDaDangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoaiMacDinh->id)
            ->pluck('goi_cuoc_id')
            ->toArray();

        return view('frontend.goicuoc.index', compact('goiCuocs', 'soDienThoaiMacDinh', 'goiDaDangKy'));
    }

    // Đăng ký gói cước mới
    public function dangKy(Request $request)
    {
        // Kiểm tra dữ liệu yêu cầu
        $request->validate([
            'so_dien_thoai_id' => 'required|exists:so_dien_thoai,id',
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
        ]);

        // Kiểm tra xem số điện thoại đã đăng ký gói này chưa
        $tonTai = DangKyGoiCuoc::where('so_dien_thoai_id', $request->so_dien_thoai_id)
            ->where('goi_cuoc_id', $request->goi_cuoc_id)
            ->exists();

        if ($tonTai) {
            return redirect()->back()->with('error', 'Số điện thoại đã đăng ký gói này.');
        }

        // Tạo mới đăng ký gói cước với trạng thái 'pending' (chờ duyệt)
        DangKyGoiCuoc::create([
            'so_dien_thoai_id' => $request->so_dien_thoai_id,
            'goi_cuoc_id' => $request->goi_cuoc_id,
            'trang_thai' => 'pending', // Trạng thái đăng ký chờ duyệt
        ]);

        return redirect()->back()->with('success', 'Đăng ký gói cước thành công! Chờ admin duyệt.');
    }

    // Xem lịch sử đăng ký gói cước của số điện thoại
    public function lichSu()
    {
        $so = SoDienThoai::first(); // Giả lập lấy số điện thoại mặc định
        $dangKys = DangKyGoiCuoc::with('goiCuoc')->where('so_dien_thoai_id', $so->id)->get();

        return view('frontend.goicuoc.lichsu', compact('dangKys', 'so'));
    }

    // Hủy đăng ký gói cước
    public function destroy($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->delete();

        return redirect()->route('frontend.lichsu')->with('success', 'Hủy đăng ký thành công!');
    }
}
