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
        Schema::table('users', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->after('ktp_number');
            $table->string('ktp_photo')->nullable()->after('birth_date');
            $table->decimal('weight', 5, 2)->nullable()->after('ktp_photo');
            $table->decimal('height', 5, 2)->nullable()->after('weight');
            $table->text('medical_history')->nullable()->after('height');
            $table->boolean('has_donated_before')->default(false)->after('medical_history');
            $table->text('donation_history_details')->nullable()->after('has_donated_before');
            $table->string('allergies')->nullable()->after('donation_history_details');
            $table->text('medications')->nullable()->after('allergies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'birth_date',
                'ktp_photo',
                'weight',
                'height',
                'medical_history',
                'has_donated_before',
                'donation_history_details',
                'allergies',
                'medications'
            ]);
        });
    }
};
