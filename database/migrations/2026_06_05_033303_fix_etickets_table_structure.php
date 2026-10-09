<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixEticketsTableStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('etickets', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['schedule_id']);
            $table->dropColumn(['user_id', 'schedule_id', 'status']);
        });

        Schema::table('etickets', function (Blueprint $table) {
            $table->foreignId('registration_id')->after('id')->constrained('donation_registrations')->onDelete('cascade');
            $table->longText('qr_code')->nullable()->after('ticket_code');
            $table->string('status')->default('generated')->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('etickets', function (Blueprint $table) {
            $table->dropForeign(['registration_id']);
            $table->dropColumn(['registration_id', 'qr_code', 'status']);
        });
        
        Schema::table('etickets', function (Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
            $table->foreignId('schedule_id')->after('user_id')->constrained('donation_schedules')->onDelete('cascade');
            $table->enum('status', ['active', 'used', 'expired'])->default('active')->after('ticket_code');
        });
    }
}
