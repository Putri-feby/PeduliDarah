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
            $table->string('organization_type')->nullable()->after('type'); // Perusahaan, Instansi Pemerintah, dll
            $table->string('pic_name')->nullable()->after('name');
            $table->string('event_name')->nullable()->after('description');
            $table->date('proposed_date')->nullable()->after('event_name');
            $table->time('proposed_time')->nullable()->after('proposed_date');
            $table->string('location')->nullable()->after('proposed_time');
            $table->string('maps_link')->nullable()->after('location');
            $table->string('estimated_donors')->nullable()->after('maps_link'); // < 50, 50-500, dll
            
            // Fasilitas
            $table->boolean('has_room')->default(false)->after('estimated_donors');
            $table->boolean('has_furniture')->default(false)->after('has_room');
            $table->boolean('has_electricity')->default(false)->after('has_furniture');
            $table->boolean('has_parking')->default(false)->after('has_electricity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborations', function (Blueprint $table) {
            $table->dropColumn([
                'organization_type',
                'pic_name',
                'event_name',
                'proposed_date',
                'proposed_time',
                'location',
                'maps_link',
                'estimated_donors',
                'has_room',
                'has_furniture',
                'has_electricity',
                'has_parking'
            ]);
        });
    }
};
