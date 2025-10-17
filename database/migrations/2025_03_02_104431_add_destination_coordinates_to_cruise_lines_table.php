<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cruise_lines', function (Blueprint $table) {
            $table->string('destination_coordinates', 50)->nullable()->after('price_per_seat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cruise_lines', function (Blueprint $table) {
            //
        });
    }
};
