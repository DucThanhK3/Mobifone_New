<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dang_ky_goi_cuoc', function (Blueprint $table) {
            $table->enum('trang_thai', ['cho_duyet', 'da_duyet', 'tu_choi'])->default('cho_duyet');
            $table->string('ly_do_tu_choi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dang_ky_goi_cuoc', function (Blueprint $table) {
            $table->dropColumn('trang_thai');
            $table->dropColumn('ly_do_tu_choi');
        });
    }
};
