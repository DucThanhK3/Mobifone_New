<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToSims extends Migration
{
    public function up()
    {
        Schema::table('sims', function (Blueprint $table) {
            // Tạo foreign key cho so_id trong bảng sims
            $table->foreign('so_id')
                  ->references('so')  // Cột so trong bảng so_dien_thoai
                  ->on('so_dien_thoai') // Tên bảng tham chiếu
                  ->onDelete('cascade'); // Nếu số điện thoại bị xóa thì SIM cũng bị xóa
        });
    }

    public function down()
    {
        Schema::table('sims', function (Blueprint $table) {
            // Xóa foreign key khi rollback migration
            $table->dropForeign(['so_id']);
        });
    }
}
