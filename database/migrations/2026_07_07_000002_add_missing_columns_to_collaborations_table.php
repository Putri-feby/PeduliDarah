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
        Schema::table('collaborations', function (Blueprint $table) {
            $table->string('organization_name')->nullable()->after('name');
            $table->string('contact_person')->nullable()->after('pic_name');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->text('proposal_description')->nullable()->after('description');
            $table->integer('expected_donors')->nullable()->after('estimated_donors');
            $table->text('admin_notes')->nullable()->after('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->dropColumn([
                'organization_name',
                'contact_person',
                'contact_phone',
                'proposal_description',
                'expected_donors',
                'admin_notes',
            ]);
        });
    }
};
