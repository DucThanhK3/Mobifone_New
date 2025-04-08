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
            $table->string('cu_phap_dang_ky')->nullable()->after('mo_ta');
        });
    }
    
    public function down()
    {
        Schema::table('goi_cuoc', function (Blueprint $table) {
            $table->dropColumn('cu_phap_dang_ky');
        });
    }
    
};
