<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Illuminate\Http\Request;


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
            'phone_number' => 'required|unique:sims,phone_number|regex:/^0[0-9]{9}$/',
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,locked',  // Thêm "locked" vào các giá trị hợp lệ
        ]);
    
        // Tạo mới SIM
        $sim = Sim::create([
            'phone_number' => $validatedData['phone_number'],
            'network_provider' => $validatedData['network_provider'],
            'status' => $validatedData['status'],
        ]);
    
        return response()->json(['message' => 'SIM added successfully', 'sim' => $sim], 201);
    }
    
    
    
        

    /**
     * Xử lý cập nhật SIM (AJAX).
     */
    public function update(Request $request, $id)
    {
        $sim = Sim::findOrFail($id);
    
        $validatedData = $request->validate([
            'phone_number' => 'required|regex:/^0[0-9]{9}$/|unique:sims,phone_number,'.$id,
            'network_provider' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,blocked'
        ]);
    
        $sim->update($validatedData);
    
        return response()->json(['message' => 'SIM updated successfully', 'sim' => $sim]);
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
