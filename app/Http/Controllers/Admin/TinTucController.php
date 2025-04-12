<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinTuc;
use Illuminate\Http\Request;

class TinTucController extends Controller
{
    // Hiển thị danh sách tin tức
    public function index()
    {
        $tinTucs = TinTuc::latest()->get();  // Lấy danh sách tin tức mới nhất
        return view('admin.tintuc.index', compact('tinTucs'));
    }

    // Thêm tin tức
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image',
            'noi_dung' => 'required',
        ]);

        $data = $request->only('tieu_de', 'noi_dung');

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $data['hinh_anh'] = $filename;
        }

        $tinTuc = TinTuc::create($data);  // Tạo tin tức mới
        return response()->json(['tinTuc' => $tinTuc], 200);
    }

    public function update(Request $request, $id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        $tinTuc->tieu_de = $request->tieu_de;
        $tinTuc->noi_dung = $request->noi_dung;
    
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);
            $tinTuc->hinh_anh = $filename;
        }
    
        $tinTuc->save();
    
        return response()->json([
            'message' => 'Cập nhật thành công',
            'tinTuc' => $tinTuc
        ]);
    }
    

    // Xóa tin tức
    public function destroy($id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        $tinTuc->delete();  // Xóa tin tức
        return response()->json(['message' => 'Xóa tin tức thành công!'], 200);
    }
}
