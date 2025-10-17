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
    Schema::create('cruise_lines', function (Blueprint $table) {
        $table->id();
        $table->string('name'); 
        $table->text('description'); 
        $table->dateTime('departure_time');
        $table->integer('total_seats');
        $table->integer('available_seats');
        $table->decimal('price_per_seat', 8, 2);
        $table->string('type')->default('standard');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cruise_lines');
    }
};
