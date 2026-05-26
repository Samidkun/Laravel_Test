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
        Schema::create('transaksi_pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('id_lowongan')->constrained('master_lowongans')->onDelete('cascade');
            $table->string('name');
            $table->string('gender'); // e.g. Laki-laki, Perempuan
            $table->date('dob'); // Date of Birth
            $table->text('adres'); // Address
            $table->string('no_telp');
            $table->string('university');
            $table->string('major');
            $table->decimal('ipk', 3, 2); // E.g. 3.75
            $table->string('status')->default('Pending'); // e.g. Pending, Approved, Rejected
            $table->string('path_cv')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_pendaftars');
    }
};
