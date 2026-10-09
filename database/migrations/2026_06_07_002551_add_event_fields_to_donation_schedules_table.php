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
        Schema::table('donation_schedules', function (Blueprint $table) {
            $table->string('event_type')->default('Publik')->after('pmi_id');
            $table->foreignId('collaboration_id')->nullable()->after('event_type')->constrained('collaborations')->onDelete('set null');
            $table->string('invitation_code')->nullable()->unique()->after('collaboration_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_schedules', function (Blueprint $table) {
            $table->dropForeign(['collaboration_id']);
            $table->dropColumn(['event_type', 'collaboration_id', 'invitation_code']);
        });
    }
};
