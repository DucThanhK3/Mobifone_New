<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use App\Models\GoiCuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Nếu cần gửi email
use App\Mail\GoiCuocDuyetMail; // Tạo Mail theo yêu cầu của bạn

class GoiCuocController extends Controller
{
    // ✅ Hiển thị danh sách gói cước
    public function index()
    {
        $goiCuocs = GoiCuoc::all();
        return view('admin.goi_cuoc.index', compact('goiCuocs'));
    }

    // ✅ Hiển thị danh sách các đăng ký gói cước chờ duyệt
    public function danhSachDangKyChoDuyet()
    {
        $dangKys = DangKyGoiCuoc::where('trang_thai', 'pending')->with('soDienThoai', 'goiCuoc')->get();
        return view('admin.goi_cuoc.dang_ky_cho_duyet', compact('dangKys'));
    }

    // ✅ Thêm gói cước (AJAX)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ten_goi' => 'required|unique:goi_cuoc,ten_goi',
            'gia' => 'required|numeric',
            'mo_ta' => 'nullable|string',
            'cu_phap_dang_ky' => 'nullable|string',
        ]);

        $goiCuoc = GoiCuoc::create($validatedData);

        return response()->json([
            'message' => 'Thêm gói cước thành công!',
            'goi_cuoc' => $goiCuoc
        ]);
    }

    // ✅ Cập nhật gói cước (AJAX)
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

        $goiCuoc->update($request->only(['ten_goi', 'gia', 'mo_ta', 'cu_phap_dang_ky']));

        return response()->json(['message' => 'Cập nhật gói cước thành công!']);
    }

    // ✅ Xóa gói cước
    public function destroy($id)
    {
        $goiCuoc = GoiCuoc::findOrFail($id);
        $goiCuoc->delete();

        return response()->json(['message' => 'Xóa gói cước thành công!']);
    }

    // ✅ Duyệt đăng ký gói cước
    public function approve($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);

        // Kiểm tra nếu trạng thái đã duyệt rồi không thực hiện lại
        if ($dangKyGoiCuoc->trang_thai == 'approved') {
            return redirect()->back()->with('error', 'Gói cước này đã được duyệt trước đó.');
        }

        $dangKyGoiCuoc->trang_thai = 'approved';
        $dangKyGoiCuoc->save();

        // Gửi email hoặc SMS khi duyệt
        // Gửi email (bạn có thể tạo mail cụ thể theo yêu cầu của bạn)
        Mail::to($dangKyGoiCuoc->soDienThoai->email)->send(new GoiCuocDuyetMail($dangKyGoiCuoc));

        // Hoặc gửi SMS nếu cần
        // Có thể dùng thư viện gửi SMS như Nexmo, Twilio

        return redirect()->back()->with('success', 'Đăng ký gói cước đã được duyệt.');
    }

    // ✅ Từ chối đăng ký gói cước
    public function reject($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);

        // Kiểm tra nếu trạng thái đã từ chối rồi không thực hiện lại
        if ($dangKyGoiCuoc->trang_thai == 'rejected') {
            return redirect()->back()->with('error', 'Gói cước này đã bị từ chối trước đó.');
        }

        $dangKyGoiCuoc->trang_thai = 'rejected';
        $dangKyGoiCuoc->save();

        // Có thể thêm thông báo SMS/email nếu cần

        return redirect()->back()->with('success', 'Đăng ký gói cước đã bị từ chối.');
    }
}
