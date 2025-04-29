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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Cột id (session ID)
            $table->text('payload'); // Cột chứa dữ liệu phiên
            $table->integer('last_activity'); // Cột lưu trữ thời gian hoạt động cuối cùng
            $table->unsignedBigInteger('user_id')->nullable(); // Cột user_id nếu cần
            $table->string('ip_address'); // Cột lưu trữ IP của người dùng
            $table->string('user_agent'); // Cột lưu trữ user agent
            $table->timestamps(); // Thời gian tạo và cập nhật
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
    
};
