<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SoDienThoai;
use Illuminate\Http\Request;

class SoDienThoaiController extends Controller
{
    // Hiển thị danh sách số điện thoại
    public function index()
    {
        $soDienThoai = SoDienThoai::all();
        return view('admin.so_dien_thoai.index', compact('soDienThoai'));
    }

 // Xử lý thêm số điện thoại (AJAX)
public function store(Request $request)
{
    $validatedData = $request->validate([
        'so' => 'required|unique:so_dien_thoai,so',
        'chu_so_huu' => 'nullable|string',
    ]);

    // Nếu không nhập chủ sở hữu, mặc định là "Chưa có ai sở hữu"
    if (!$request->chu_so_huu) {
        $validatedData['chu_so_huu'] = "Chưa có ai sở hữu";
    }

    $soDienThoai = SoDienThoai::create($validatedData);

    return response()->json([
        'message' => 'Thêm số điện thoại thành công!',
        'so' => $soDienThoai
    ]);
}

// Xử lý cập nhật số điện thoại (AJAX)
public function update(Request $request, $id)
{
    $request->validate([
        'so' => 'required|string',
        'chu_so_huu' => 'nullable|string',
    ]);

    $soDienThoai = SoDienThoai::find($id);
    if (!$soDienThoai) {
        return response()->json(['message' => 'Không tìm thấy số điện thoại!'], 404);
    }

    $soDienThoai->so = $request->so;
    $soDienThoai->chu_so_huu = $request->chu_so_huu;
    $soDienThoai->save();

    return response()->json(['message' => 'Cập nhật thành công!']);
}



// Xử lý xóa số điện thoại (AJAX)
public function destroy($id)
{
    $soDienThoai = SoDienThoai::findOrFail($id);
    $soDienThoai->delete();

    return response()->json(['message' => 'Xóa số điện thoại thành công!']);
}

}
