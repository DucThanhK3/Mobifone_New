<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoiCuocLoaiTable extends Migration
{
    public function up()
    {
        Schema::create('goi_cuoc_loai', function (Blueprint $table) {
            $table->id();
            $table->string('loai_thue_bao'); // trac_truoc, tra_sau, fast_connect
            $table->string('tieu_de');
            $table->string('hinh_anh')->nullable(); // VD: mobiQ.jpg
            $table->text('mo_ta_chi_tiet')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('goi_cuoc_loai');
    }
}
