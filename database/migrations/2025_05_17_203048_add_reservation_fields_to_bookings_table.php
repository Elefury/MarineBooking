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
        Schema::table('bookings', function (Blueprint $table) {
        $table->timestamp('reserved_until')->nullable()->after('status');
        $table->string('stripe_session_id')->nullable()->after('reserved_until');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
        $table->dropColumn(['reserved_until', 'stripe_session_id']);
        });
    }
};
