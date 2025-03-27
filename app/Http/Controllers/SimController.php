<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SimController extends Controller
{
    /**
     * Hiển thị danh sách tất cả SIM.
     */
    public function index()
    {
        try {
            $sims = Sim::all();
            return view('admin.sims.index', compact('sims'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi lấy danh sách SIM: ' . $e->getMessage());
            return redirect()->back()->with('error', 'LỖI KHI LẤY DANH SÁCH SIM!');
        }
    }

    /**
     * Xử lý thêm SIM mới (AJAX).
     */
    public function store(Request $request)
    {
        // In ra dữ liệu nhận được để kiểm tra
    dd($request->all()); 
        $validatedData = $request->validate([
            'phone_number' => 'required|unique:sims,phone_number|regex:/^0[0-9]{9}$/',
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $sim = Sim::create($validatedData);
            return response()->json([
                'message' => 'Thêm SIM thành công!',
                'sim' => $sim
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm SIM: ' . $e->getMessage());
            return response()->json(['message' => 'LỖI KHI THÊM SIM!'], 500);
        }
    }

    /**
     * Xử lý cập nhật SIM (AJAX).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'phone_number' => 'required|regex:/^0[0-9]{9}$/|unique:sims,phone_number,' . $id,
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive'
        ]);

        try {
            $sim = Sim::find($id);
            if (!$sim) {
                return response()->json(['message' => 'Không tìm thấy SIM!'], 404);
            }

            $sim->phone_number = $request->phone_number;
            $sim->network_provider = $request->network_provider;
            $sim->status = $request->status;
            $sim->save();

            return response()->json(['message' => 'Cập nhật SIM thành công!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật SIM: ' . $e->getMessage());
            return response()->json(['message' => 'LỖI KHI CẬP NHẬT SIM!'], 500);
        }
    }

    /**
     * Xử lý xóa SIM (AJAX).
     */
    public function destroy($id)
    {
        try {
            $sim = Sim::findOrFail($id);
            $sim->delete();
            return response()->json(['message' => 'Xóa SIM thành công!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa SIM: ' . $e->getMessage());
            return response()->json(['message' => 'LỖI KHI XÓA SIM!'], 500);
        }
    }
}
