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
        Schema::table('cruise_lines', function (Blueprint $table) {
            $table->foreignId('vessel_id')
                  ->nullable()
                  ->constrained('vessels')
                  ->onDelete('set null');
                  

            $table->string('meeting_point')->nullable();
            
            
            $table->decimal('meeting_latitude', 10, 7)
                  ->nullable();
                  
            $table->decimal('meeting_longitude', 10, 7)
                  ->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruise_lines', function (Blueprint $table) {
            $table->dropForeign(['vessel_id']);
            $table->dropColumn([
                'vessel_id',
                'meeting_point',
                'meeting_latitude',
                'meeting_longitude'
            ]);
        });
    }
};