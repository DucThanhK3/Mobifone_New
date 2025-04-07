<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use App\Models\SoDienThoai;
use App\Models\GoiCuoc;

use App\Http\Controllers\Controller; // ✅ Thêm dòng này

class DichVuController extends Controller
{
    public function index()
    {
        $ssims = Sim::all();  // Truy vấn dữ liệu từ bảng sims
        $soDienThoais = SoDienThoai::all();  // Truy vấn dữ liệu từ bảng so_dien_thoai
        $goiCuocs = GoiCuoc::all();  // Truy vấn dữ liệu từ bảng goi_cuoc
    
        return view('customer.dichvu.index', compact('ssims', 'soDienThoais', 'goiCuocs'));
    }
    
}
