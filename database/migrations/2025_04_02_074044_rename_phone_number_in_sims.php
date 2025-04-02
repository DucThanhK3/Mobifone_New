<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->renameColumn('phone_number', 'so_id');
        });
    }

    public function down()
    {
        Schema::table('sims', function (Blueprint $table) {
            $table->renameColumn('so_id', 'phone_number');
        });
    }
};

