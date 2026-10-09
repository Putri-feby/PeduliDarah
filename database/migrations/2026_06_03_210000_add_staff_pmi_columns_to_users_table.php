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
            $table->string('unit_pmi')->nullable()->after('medications');
            $table->string('employee_number')->nullable()->after('unit_pmi');
            $table->string('employee_id_card')->nullable()->after('employee_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['unit_pmi', 'employee_number', 'employee_id_card']);
        });
    }
};
