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
        Schema::create('voyage_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('voyage_id')->constrained();
            $table->integer('seats');
            $table->decimal('total_price', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamp('reserved_until')->nullable();
            $table->string('stripe_session_id')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'voyage_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voyage_bookings');
    }
};
