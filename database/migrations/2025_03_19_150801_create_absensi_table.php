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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->nullable();
            $table->date('absensi_date');
            $table->time('time_in');
            $table->time('time_out')->nullable();
            $table->text('photo_in');
            $table->text('photo_out')->nullable();
            $table->string('location');
            $table->timestamps();

            $table->unique(['nik', 'absensi_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
