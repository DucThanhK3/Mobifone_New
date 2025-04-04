<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('sims', function (Blueprint $table) {
            // Thêm cột 'loai_thue_bao' với kiểu dữ liệu enum
            $table->enum('loai_thue_bao', ['Tra Truoc', 'Tra Sau'])->default('Tra Truoc')->after('sodt');
        });
    }

    public function down() {
        Schema::table('sims', function (Blueprint $table) {
            // Xóa cột 'loai_thue_bao' nếu rollback migration
            $table->dropColumn('loai_thue_bao');
        });
    }
};
