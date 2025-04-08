<?php

namespace App\Http\Controllers;

use App\Models\GoiCuoc;
use Illuminate\Http\Request;

class GoiCuocController extends Controller
{
    // Hiển thị danh sách gói cước
    public function index()
    {
        $goiCuocs = GoiCuoc::all();
        return view('admin.goi_cuoc.index', compact('goiCuocs'));
    }

    // Xử lý thêm gói cước (AJAX)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten_goi' => 'required|unique:goi_cuoc,ten_goi',
            'gia' => 'required|numeric',
            'mo_ta' => 'nullable|string',
            'cu_phap_dang_ky' => 'nullable|string', // 👈 Thêm dòng này
        ]);
    
        $goiCuoc = GoiCuoc::create($validatedData);
    
        return response()->json([
            'message' => 'Thêm gói cước thành công!',
            'goi_cuoc' => $goiCuoc
        ]);
    }

    // Xử lý cập nhật gói cước (AJAX)
    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_goi' => 'required|string',
            'gia' => 'required|numeric',
            'mo_ta' => 'nullable|string',
            'cu_phap_dang_ky' => 'nullable|string',
        ]);
    
        $goiCuoc = GoiCuoc::find($id);
        if (!$goiCuoc) {
            return response()->json(['message' => 'Không tìm thấy gói cước!'], 404);
        }
    
        $goiCuoc->ten_goi = $request->ten_goi;
        $goiCuoc->gia = $request->gia;
        $goiCuoc->mo_ta = $request->mo_ta;
        $goiCuoc->cu_phap_dang_ky = $request->cu_phap_dang_ky;
        $goiCuoc->save();
    
        return response()->json(['message' => 'Cập nhật gói cước thành công!']);
    }

    public function destroy($id)
    {
        $goiCuoc = GoiCuoc::findOrFail($id);
        $goiCuoc->delete();

        return response()->json(['message' => 'Xóa gói cước thành công!']);
    }
}
