<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('AudioManager', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hafalan_id');
            $table->string('path');
            $table->timestamps();

            $table->foreign('hafalan_id')->references('id')->on('Hafalan')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('AudioManager');
    }
};
