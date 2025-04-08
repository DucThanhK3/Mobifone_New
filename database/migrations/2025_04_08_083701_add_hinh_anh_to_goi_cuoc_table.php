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
        $table->string('hinh_anh')->nullable()->after('mo_ta'); // hoặc 'ten_goi'
    });
}


    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('goi_cuoc', function (Blueprint $table) {
        $table->dropColumn('hinh_anh');
    });
}

};
