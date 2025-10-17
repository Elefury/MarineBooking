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
    Schema::create('promo_codes', function (Blueprint $table) {
        $table->id();
        $table->string('code')->unique();
        $table->enum('type', ['percent', 'fixed']);
        $table->decimal('value', 8, 2);
        $table->dateTime('valid_from');
        $table->dateTime('valid_to');
        $table->integer('usage_limit')->nullable();
        $table->integer('used_count')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
