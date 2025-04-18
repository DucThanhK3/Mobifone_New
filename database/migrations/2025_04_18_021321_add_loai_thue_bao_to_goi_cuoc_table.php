<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->string('loai_thue_bao')->after('ten_goi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->dropColumn('loai_thue_bao');
        });
    }
};
