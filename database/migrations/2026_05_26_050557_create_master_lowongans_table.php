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
        Schema::create('master_lowongans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dept_id')->constrained('master_departements')->onDelete('cascade');
            $table->string('posisi');
            $table->integer('quota');
            $table->text('deskripsi');
            $table->foreignId('user_created')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('user_updated')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_lowongans');
    }
};
