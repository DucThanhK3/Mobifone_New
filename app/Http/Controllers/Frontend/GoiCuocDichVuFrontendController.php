<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\GoiCuoc;
use App\Models\SoDienThoai;
use App\Models\DangKyGoiCuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GoiCuocDichVuFrontendController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        Log::info('User ID: ' . ($user ? $user->id : 'null')); // Debug
    
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();
        Log::info('SoDienThoai: ' . ($soDienThoai ? $soDienThoai->so : 'null')); // Debug
    
        $goiCuocs = GoiCuoc::all();
        Log::info('GoiCuocs count: ' . $goiCuocs->count()); // Debug
    
        $goiDaDangKy = [];
        if ($soDienThoai) {
            $goiDaDangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoai->id)
                ->whereIn('trang_thai', ['pending', 'approved'])
                ->pluck('goi_cuoc_id')
                ->toArray();
        }
        Log::info('GoiDaDangKy: ' . json_encode($goiDaDangKy)); // Debug
    
        return view('frontend.goicuocdichvu.index', compact('goiCuocs', 'soDienThoai', 'goiDaDangKy'));
    }

    public function dangKy(Request $request)
    {
        $user = Auth::guard('web')->user();
        Log::info('User ID: ' . $user->id); // Debug
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();
        Log::info('SoDienThoai: ' . ($soDienThoai ? $soDienThoai->so : 'null')); // Debug

        if (!$soDienThoai) {
            return back()->with('error', 'Bạn cần đăng ký số điện thoại trước khi đăng ký gói cước.');
        }

        $request->validate([
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
            'math_answer' => 'required|numeric',
        ]);
        Log::info('GoiCuoc ID: ' . $request->goi_cuoc_id); // Debug

        DangKyGoiCuoc::create([
            'goi_cuoc_id' => $request->goi_cuoc_id,
            'so_dien_thoai_id' => $soDienThoai->id,
            'trang_thai' => 'pending',
        ]);

        return back()->with('success', 'Yêu cầu đăng ký đã được gửi. Vui lòng chờ duyệt!');
    }

    public function lichSu()
    {
        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();
        $dangKyGoiCuocs = collect();

        if ($soDienThoai) {
            $dangKyGoiCuocs = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoai->id)
                ->with('goiCuoc', 'soDienThoai')
                ->get();
        }

        return view('frontend.goicuocdichvu.lichsu', compact('dangKyGoiCuocs'));
    }

    public function destroy($id)
    {
        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();

        if (!$soDienThoai) {
            return back()->with('error', 'Bạn cần đăng ký số điện thoại trước.');
        }

        $dangKy = DangKyGoiCuoc::where('id', $id)
            ->where('so_dien_thoai_id', $soDienThoai->id)
            ->where('trang_thai', 'cho_duyet')
            ->firstOrFail();

        $dangKy->delete();

        return back()->with('success', 'Hủy đăng ký thành công!');
    }

    public function huyGoiCuoc(Request $request)
    {
        $request->validate([
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id', // Sửa goi_cuocs thành goi_cuoc
            'math_answer' => 'required|numeric',
        ]);

        $user = Auth::guard('web')->user();
        $soDienThoai = SoDienThoai::where('user_id', $user->id)->first();

        if (!$soDienThoai) {
            return redirect()->route('frontend.goicuocdichvu.index')->with('error', 'Bạn cần đăng ký số điện thoại trước.');
        }

        // Kiểm tra xem người dùng đã đăng ký gói cước này chưa
        $dangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoai->id)
            ->where('goi_cuoc_id', $request->input('goi_cuoc_id'))
            ->where('trang_thai', 'approved')
            ->first();

        if (!$dangKy) {
            return redirect()->route('frontend.goicuocdichvu.index')->with('error', 'Bạn chưa đăng ký gói cước này.');
        }

        // Xóa bản ghi đăng ký
        $dangKy->delete();

        return redirect()->route('frontend.goicuocdichvu.index')->with('success', 'Hủy gói cước thành công.');
    }
}