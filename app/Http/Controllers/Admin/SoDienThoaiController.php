<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinTuc;  // Đảm bảo đây là dòng use ở đầu file
use Illuminate\Http\Request;

class TinTucController extends Controller
{
    /**
     * Hiển thị danh sách tin tức.
     */
    public function index()
    {
        $tinTucs = TinTuc::latest()->get();  // Lấy các tin tức mới nhất
        return view('admin.tintuc.index', compact('tinTucs'));  // Trả về view với dữ liệu
    }

    /**
     * Lưu tin tức mới.
     */
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'hinh_anh' => 'nullable|image',
            'noi_dung' => 'required',
        ]);
    
        // Lấy dữ liệu từ request
        $data = $request->only('tieu_de', 'noi_dung');
    
        // Xử lý nếu có file ảnh
        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images'), $filename);
            $data['hinh_anh'] = $filename;
        }
    
        // Tạo mới tin tức
        TinTuc::create($data);
    
        // Quay lại trang trước với thông báo thành công
        return redirect()->back()->with('success', 'Thêm tin tức thành công!');
    }

    /**
     * Cập nhật tin tức.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:255',
            'noi_dung' => 'required',
        ]);

        // Tìm tin tức theo ID
        $tinTuc = TinTuc::find($id);
        if (!$tinTuc) {
            return response()->json(['message' => 'Không tìm thấy tin tức!'], 404);
        }

        // Cập nhật tin tức
        $tinTuc->update($request->only('tieu_de', 'noi_dung'));

        return response()->json(['message' => 'Cập nhật tin tức thành công!']);
    }

    /**
     * Xóa tin tức.
     */
    public function destroy($id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        $tinTuc->delete();

        return response()->json(['message' => 'Xóa tin tức thành công!']);
    }
}
