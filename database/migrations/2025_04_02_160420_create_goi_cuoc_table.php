<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('goi_cuoc', function (Blueprint $table) {
        $table->id();
        $table->string('ten_goi'); // Tên gói cước
        $table->decimal('gia', 10, 2); // Giá gói cước
        $table->text('mo_ta')->nullable(); // Mô tả gói cước
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('goi_cuoc');
}

};
