<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GoiCuocDuyetMail;

class DangKyGoiCuocController extends Controller
{
    /**
     * Hiển thị danh sách đăng ký gói cước
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dangKys = DangKyGoiCuoc::all();
        return view('admin.dang_ky_goi_cuoc.index', compact('dangKys'));
    }

    /**
     * Hiển thị danh sách các đăng ký gói cước chờ duyệt
     *
     * @return \Illuminate\View\View
     */
    public function danhSachDangKyChoDuyet()
    {
        $dangKys = DangKyGoiCuoc::where('trang_thai', 'pending')
            ->with('soDienThoai', 'goiCuoc')
            ->paginate(10); // Hiển thị 10 bản ghi mỗi trang
        return view('admin.goi_cuoc.dang_ky_cho_duyet', compact('dangKys'));
    }

    /**
     * Duyệt đăng ký gói cước
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);
        if ($dangKyGoiCuoc->trang_thai == 'approved' || $dangKyGoiCuoc->trang_thai == 'da_duyet') {
            return redirect()->back()->with('error', 'Gói cước này đã được duyệt trước đó.');
        }
        $dangKyGoiCuoc->trang_thai = 'approved'; // Hoặc 'da_duyet'
        $dangKyGoiCuoc->save();

        // Gửi email thông báo (nếu cần)
        Mail::to($dangKyGoiCuoc->soDienThoai->email)->send(new GoiCuocDuyetMail($dangKyGoiCuoc));

        return redirect()->back()->with('success', 'Đăng ký gói cước đã được duyệt.');
    }

    /**
     * Từ chối đăng ký gói cước
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);

        if (in_array($dangKyGoiCuoc->trang_thai, ['pending', 'cho_duyet'])) {
            $dangKyGoiCuoc->trang_thai = 'da_tu_choi';
            $dangKyGoiCuoc->save();

            // Gửi email thông báo (nếu cần)
            Mail::to($dangKyGoiCuoc->soDienThoai->email)->send(new GoiCuocDuyetMail($dangKyGoiCuoc));

            return redirect()->back()->with('success', 'Từ chối đăng ký thành công.');
        }

        return redirect()->back()->with('error', 'Không thể từ chối đăng ký này.');
    }

    /**
     * Thêm đăng ký gói cước mới
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'so_dien_thoai' => 'required|exists:so_dien_thoais,so_dien_thoai', // Kiểm tra số điện thoại đã tồn tại
            'goi_cuoc_id' => 'required|exists:goi_cuocs,id', // Kiểm tra ID gói cước hợp lệ
            'trang_thai' => 'required|in:pending,approved,da_tu_choi', // Trạng thái hợp lệ
        ]);

        $dangKyGoiCuoc = DangKyGoiCuoc::create($validatedData);

        return response()->json([
            'message' => 'Thêm đăng ký gói cước thành công!',
            'dang_ky_goi_cuoc' => $dangKyGoiCuoc
        ]);
    }

    /**
     * Cập nhật đăng ký gói cước
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'so_dien_thoai' => 'required|exists:so_dien_thoais,so_dien_thoai',
            'goi_cuoc_id' => 'required|exists:goi_cuocs,id',
            'trang_thai' => 'required|in:pending,approved,da_tu_choi',
        ]);

        $dangKyGoiCuoc = DangKyGoiCuoc::find($id);
        if (!$dangKyGoiCuoc) {
            return response()->json(['message' => 'Không tìm thấy đăng ký gói cước!'], 404);
        }

        $dangKyGoiCuoc->update($validatedData);

        return response()->json(['message' => 'Cập nhật đăng ký gói cước thành công!']);
    }

    /**
     * Xóa đăng ký gói cước
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);
        $dangKyGoiCuoc->delete();

        return response()->json(['message' => 'Xóa đăng ký gói cước thành công!']);
    }
}
