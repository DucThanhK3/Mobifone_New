<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoiCuoc;
use App\Models\SoDienThoai;
use App\Models\DangKyGoiCuoc;

class GoiCuocController extends Controller
{
    public function index()
    {
        $goiCuocs = GoiCuoc::all();
        $soDienThoaiMacDinh = SoDienThoai::first(); // giả lập

        $goiDaDangKy = DangKyGoiCuoc::where('so_dien_thoai_id', $soDienThoaiMacDinh->id)
            ->pluck('goi_cuoc_id')
            ->toArray();



        return view('frontend.goicuoc.index', compact('goiCuocs', 'soDienThoaiMacDinh', 'goiDaDangKy'));
    }

    public function dangKy(Request $request)
    {
        $request->validate([
            'so_dien_thoai_id' => 'required|exists:so_dien_thoai,id',
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
        ]);

        $tonTai = DangKyGoiCuoc::where('so_dien_thoai_id', $request->so_dien_thoai_id)
            ->where('goi_cuoc_id', $request->goi_cuoc_id)
            ->exists();

        if ($tonTai) {
            return redirect()->back()->with('error', 'Số điện thoại đã đăng ký gói này.');
        }

        DangKyGoiCuoc::create([
            'so_dien_thoai_id' => $request->so_dien_thoai_id,
            'goi_cuoc_id' => $request->goi_cuoc_id,
        ]);

        return redirect()->back()->with('success', 'Đăng ký thành công!');
    }

    public function lichSu()
    {
        $so = SoDienThoai::first();
        $dangKys = DangKyGoiCuoc::with('goiCuoc')->where('so_dien_thoai_id', $so->id)->get();

        return view('frontend.goicuoc.lichsu', compact('dangKys', 'so'));
    }

    
    public function destroy($id)
    {
        $dangKy = DangKyGoiCuoc::findOrFail($id);
        $dangKy->delete();
    
        return redirect()->route('frontend.lichsu')->with('success', 'Hủy đăng ký thành công!');
    }
    

}
