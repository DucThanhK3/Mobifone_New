<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use App\Models\GoiCuoc;
use App\Models\SoDienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoiCuocDichVuFrontendController extends Controller
{
    // Hiển thị danh sách gói cước và trạng thái đăng ký
    public function index()
    {
        $goiCuocs = GoiCuoc::all();
        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();

        if (!$soDienThoai) {
            return redirect()->route('frontend.home')->with('error', 'Bạn cần đăng ký số điện thoại trước khi đăng ký gói cước.');
        }

        $goiDaDangKy = DangKyGoiCuoc::where('user_id', $user->id)
            ->pluck('goi_cuoc_id')
            ->toArray();

        return view('frontend.goicuocdichvu.index', compact('goiCuocs', 'soDienThoai', 'goiDaDangKy'));
    }

    // Xử lý đăng ký gói cước (yêu cầu duyệt)
    public function dangKy(Request $request)
    {
        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();

        if (!$soDienThoai) {
            return back()->with('error', 'Bạn cần đăng ký số điện thoại trước khi đăng ký gói cước.');
        }

        $request->validate([
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
        ]);

        DangKyGoiCuoc::create([
            'goi_cuoc_id' => $request->goi_cuoc_id,
            'so_dien_thoai_id' => $soDienThoai->id,
            'user_id' => $user->id,
            'trang_thai' => 'chua_duyet',
        ]);

        return back()->with('success', 'Yêu cầu đăng ký đã được gửi. Vui lòng chờ duyệt!');
    }

    // Hiển thị lịch sử đăng ký gói cước
    public function lichSu()
    {
        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();

        if (!$soDienThoai) {
            return redirect()->route('frontend.home')->with('error', 'Bạn cần đăng ký số điện thoại trước khi xem lịch sử đăng ký.');
        }

        $dangKyGoiCuocs = DangKyGoiCuoc::with('goiCuoc')
            ->where('user_id', $user->id)
            ->get();

        return view('frontend.goicuocdichvu.lichsu', compact('dangKyGoiCuocs', 'soDienThoai'));
    }

    // Hủy đăng ký gói cước
    public function destroy($id)
    {
        $dangKy = DangKyGoiCuoc::where('user_id', Auth::guard('web')->id())->findOrFail($id);
        $dangKy->delete();

        return redirect()->route('frontend.lichsu')->with('success', 'Hủy đăng ký thành công!');
    }
}