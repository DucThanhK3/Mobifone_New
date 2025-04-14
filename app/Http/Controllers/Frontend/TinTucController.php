<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TinTuc;

class TinTucController extends Controller
{
    public function index()
    {
        $tinTucs = TinTuc::orderByDesc('created_at')->paginate(6);
        return view('frontend.tin_tuc.index', compact('tinTucs'));
    }

    public function show($id)
    {
        $tinTuc = TinTuc::findOrFail($id);
        
        

    // Lấy 4 tin khác, loại trừ tin hiện tại
    $tinKhac = TinTuc::where('id', '!=', $id)
        ->orderBy('created_at', 'desc')
        ->take(4)
        ->get();

    return view('frontend.tin_tuc.show', compact('tinTuc', 'tinKhac'));
    }
}
