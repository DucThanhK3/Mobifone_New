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
            $table->dropColumn('loai_thue_bao'); // Xóa cột loai_thue_bao
        });
    }
    
    public function down()
    {
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->string('loai_thue_bao'); // Thêm lại cột loai_thue_bao nếu cần rollback
        });
    }
    
};
