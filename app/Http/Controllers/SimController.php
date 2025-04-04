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
        // Validate dữ liệu
        $validatedData = $request->validate([
            'sodt' => 'required|unique:sims,sodt',
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,blocked',
            'loai_thue_bao' => 'required|in:Tra Truoc,Tra Sau', // Kiểm tra loại thuê bao
        ]);
    
        // Tạo mới SIM
        $sim = Sim::create([
            'sodt' => $validatedData['sodt'],
            'network_provider' => $validatedData['network_provider'],
            'status' => $validatedData['status'],
            'loai_thue_bao' => $validatedData['loai_thue_bao'], // Thêm loại thuê bao
        ]);
    
        return response()->json(['message' => 'SIM added successfully', 'sim' => $sim], 201);
    }

    /**
     * Xử lý cập nhật SIM (AJAX).
     */
    public function update(Request $request, $so_id)
    {
        \Log::info('Update SIM Request:', $request->all()); // Ghi log request

        // Kiểm tra SIM có tồn tại không
        $sim = Sim::where('so_id', $so_id)->first();
        if (!$sim) {
            \Log::error('SIM not found with so_id: ' . $so_id);
            return response()->json(['message' => 'SIM not found'], 404);
        }

        // Validate dữ liệu đầu vào
        $validatedData = $request->validate([
            'sodt' => 'required|unique:sims,sodt,' . $so_id . ',so_id',
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,blocked',
            'loai_thue_bao' => 'required|in:Tra Truoc,Tra Sau', // Kiểm tra loại thuê bao
        ]);

        \Log::info('Validated Data:', $validatedData); // Ghi log dữ liệu đã kiểm tra

        try {
            $sim->update($validatedData);
            \Log::info('SIM updated successfully', ['sim' => $sim]); // Log kết quả update

            return response()->json(['message' => 'SIM updated successfully', 'sim' => $sim]);
        } catch (\Exception $e) {
            \Log::error('Error updating SIM:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to update SIM', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Xử lý xóa SIM (AJAX).
     */
    public function destroy($so_id)
    {
        try {
            $sim = Sim::findOrFail($so_id);
            $sim->delete();
            return response()->json(['message' => 'Xóa SIM thành công!']);
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa SIM: ' . $e->getMessage());
            return response()->json(['message' => 'LỖI KHI XÓA SIM!'], 500);
        }
    }
}
