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
        Schema::create('goi_cuoc_loai', function (Blueprint $table) {
            $table->id();
            $table->string('loai_thue_bao'); // Loại thuê bao (Trả trước, Trả sau, Fast Connect)
            $table->string('tieu_de'); // Tiêu đề gói cước
            $table->string('hinh_anh'); // Hình ảnh gói cước
            $table->text('mo_ta_chi_tiet'); // Mô tả chi tiết gói cước
            $table->timestamps(); // Các trường created_at, updated_at
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('goi_cuoc_loai');
    }
    
};
