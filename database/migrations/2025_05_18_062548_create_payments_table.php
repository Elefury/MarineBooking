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
        
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('bookable_type');
            $table->unsignedBigInteger('bookable_id');
            $table->string('stripe_payment_id');
            $table->decimal('amount', 10, 2);
            $table->string('status');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->index(['bookable_type', 'bookable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
