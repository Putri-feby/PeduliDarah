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
        // Create users table (common account data)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->enum('role', ['donor', 'staff']);
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('no_telp');
            $table->enum('jenis_kelamin', ['pria', 'wanita', 'lainnya']);
            $table->string('nik', 16)->unique();
            $table->date('tanggal_lahir');
            $table->string('password');
            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();
            $table->timestamps();
        });

        // Create donor_profiles table
        Schema::create('donor_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O']);
            $table->enum('rhesus', ['+', '-'])->default('+');
            $table->text('riwayat_penyakit')->nullable();
            $table->boolean('pernah_donor')->default(false);
            $table->text('detail_riwayat_donor')->nullable();
            $table->string('alergi')->nullable();
            $table->text('obat')->nullable();
            $table->timestamps();
        });

        // Create staff_profiles table
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('unit_pmi');
            $table->string('nomor_pegawai');
            $table->string('foto_id_card')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_profiles');
        Schema::dropIfExists('donor_profiles');
        Schema::dropIfExists('users');
    }
};
