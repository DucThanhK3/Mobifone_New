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
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->text('mo_ta_chi_tiet')->nullable(); // Thêm cột mô tả chi tiết
        });
    }
    
    public function down()
    {
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->dropColumn('mo_ta_chi_tiet'); // Xóa cột khi rollback
        });
    }
};    
