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
            $table->id();
            $table->string('phone_number')->unique();
            $table->string('network_provider'); // NHÀ MẠNG (VIETTEL, MOBIFONE,...)
            $table->enum('status', ['active', 'inactive', 'blocked'])->default('inactive');
            $table->date('activation_date')->nullable();
            $table->timestamps();
        });
    }
    
};
