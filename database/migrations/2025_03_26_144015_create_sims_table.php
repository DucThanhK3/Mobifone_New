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
        Schema::create('sims', function (Blueprint $table) {
            $table->id(); // Tạo khóa chính tự động tăng
            $table->string('phone_number')->unique(); // Số điện thoại phải duy nhất
            $table->string('network_provider'); // Nhà mạng (Ví dụ: Viettel, Mobifone)
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('inactive'); // Trạng thái của SIM
            $table->date('activation_date')->nullable(); // Ngày kích hoạt SIM (có thể null)
            $table->timestamps(); // Các trường tạo và cập nhật tự động
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('sims'); // Xóa bảng nếu cần rollback
    }
};

