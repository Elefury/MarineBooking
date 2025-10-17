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
        Schema::create('voyages', function (Blueprint $table) {
            $table->id();
            $table->string('voyage_number'); 
            $table->foreignId('vessel_id')->constrained(); 
            $table->foreignId('departure_port_id')->constrained('ports');
            $table->foreignId('arrival_port_id')->constrained('ports');
            $table->dateTime('departure_time');
            $table->dateTime('arrival_time');
            $table->integer('passenger_capacity');
            $table->integer('available_seats');
            $table->decimal('price_per_seat', 10, 2);
            $table->string('type')->default('regular');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyages');
    }
};
