<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->foreignId('goi_cuoc_id')->nullable()->constrained('goi_cuoc')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->dropForeign(['goi_cuoc_id']);
            $table->dropColumn('goi_cuoc_id');
        });
    }
};
