<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoiCuocLoai;

class GoiCuocLoaiController extends Controller
{
    public function index()
    {
        // Lấy dữ liệu từ bảng goi_cuoc_loai và phân loại theo loại thuê bao
        $traTruoc = GoiCuocLoai::where('loai_thue_bao', 'Trả trước')->get();
        $traSau = GoiCuocLoai::where('loai_thue_bao', 'Trả sau')->get();
        $fastConnect = GoiCuocLoai::where('loai_thue_bao', 'Fast Connect')->get();
    
        // Trả về view với dữ liệu
        return view('frontend.dichvu.loaithuebao', compact('traTruoc', 'traSau', 'fastConnect'));
    }

   public function show($id)
{
    $goiCuoc = GoiCuocLoai::findOrFail($id);

    // Lấy một loại thuê bao khác bất kỳ, không phải loại hiện tại
    $otherLoai = GoiCuocLoai::where('loai_thue_bao', '!=', $goiCuoc->loai_thue_bao)
        ->inRandomOrder()
        ->first();

    // Lấy 5 gói cước ngẫu nhiên thuộc loại thuê bao đó
    $otherGoiCuocList = GoiCuocLoai::where('loai_thue_bao', $otherLoai->loai_thue_bao)
        ->where('id', '!=', $goiCuoc->id) // loại trừ chính gói hiện tại nếu cùng loại
        ->inRandomOrder()
        ->limit(5)
        ->get();

    return view('frontend.dichvu.show', [
        'goi' => $goiCuoc,
        'otherGoiCuocList' => $otherGoiCuocList,
        'tenLoaiThueBao' => $otherLoai->loai_thue_bao
    ]);
}

    
};
