<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('chi_tiet_goi_cuoc'); // Xóa bảng chi_tiet_goi_cuoc
    }
    
    public function down()
    {
        // Nếu muốn khôi phục bảng, bạn cần tạo lại cấu trúc bảng này ở đây.
    }
    
};
