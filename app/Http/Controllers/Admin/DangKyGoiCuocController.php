<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DangKyGoiCuoc;
use App\Models\SoDienThoai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\GoiCuocDuyetMail;

class DangKyGoiCuocController extends Controller
{
    public function index()
    {
        $dangKys = DangKyGoiCuoc::with('soDienThoai', 'goiCuoc')->paginate(10);
        return view('admin.dang_ky_goi_cuoc.index', compact('dangKys'));
    }

    public function danhSachDangKyChoDuyet()
    {
        $dangKys = DangKyGoiCuoc::where('trang_thai', 'pending')
            ->with('soDienThoai', 'goiCuoc')
            ->paginate(10);
        return view('admin.goi_cuoc.dang_ky_cho_duyet', compact('dangKys'));
    }

    public function approve($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);
        if ($dangKyGoiCuoc->trang_thai === 'approved') {
            return redirect()->back()->with('error', 'Gói cước này đã được duyệt trước đó.');
        }
        $dangKyGoiCuoc->trang_thai = 'approved';
        $dangKyGoiCuoc->save();

        $email = $dangKyGoiCuoc->soDienThoai->user->email ?? $dangKyGoiCuoc->soDienThoai->email;
        Mail::to($email)->send(new GoiCuocDuyetMail($dangKyGoiCuoc, 'emails.thong_bao_duyet'));

        return redirect()->back()->with('success', 'Đăng ký gói cước đã được duyệt.');
    }

    public function reject($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);

        if ($dangKyGoiCuoc->trang_thai === 'pending') {
            $dangKyGoiCuoc->trang_thai = 'rejected';
            $dangKyGoiCuoc->save();

            $email = $dangKyGoiCuoc->soDienThoai->user->email ?? $dangKyGoiCuoc->soDienThoai->email;
            Mail::to($email)->send(new GoiCuocDuyetMail($dangKyGoiCuoc, 'emails.thong_bao_tu_choi'));

            return redirect()->back()->with('success', 'Từ chối đăng ký thành công.');
        }

        return redirect()->back()->with('error', 'Không thể từ chối đăng ký này.');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'so_dien_thoai_id' => 'required|exists:so_dien_thoais,id',
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
            'trang_thai' => 'required|in:pending,approved,rejected',
        ]);

        $dangKyGoiCuoc = DangKyGoiCuoc::create($validatedData);

        return response()->json([
            'message' => 'Thêm đăng ký gói cước thành công!',
            'dang_ky_goi_cuoc' => $dangKyGoiCuoc
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'so_dien_thoai_id' => 'required|exists:so_dien_thoais,id',
            'goi_cuoc_id' => 'required|exists:goi_cuoc,id',
            'trang_thai' => 'required|in:pending,approved,rejected',
        ]);

        $dangKyGoiCuoc = DangKyGoiCuoc::find($id);
        if (!$dangKyGoiCuoc) {
            return response()->json(['message' => 'Không tìm thấy đăng ký gói cước!'], 404);
        }

        $dangKyGoiCuoc->update($validatedData);

        return response()->json(['message' => 'Cập nhật đăng ký gói cước thành công!']);
    }

    public function destroy($id)
    {
        $dangKyGoiCuoc = DangKyGoiCuoc::findOrFail($id);
        $dangKyGoiCuoc->delete();

        return response()->json(['message' => 'Xóa đăng ký gói cước thành công!']);
    }
}