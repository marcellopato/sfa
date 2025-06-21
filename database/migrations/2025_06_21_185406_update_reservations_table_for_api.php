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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('reservation_code')->after('flight_id')->unique();
            $table->timestamp('reservation_date')->after('reservation_code');
            $table->dropColumn('passengers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('reservation_code');
            $table->dropColumn('reservation_date');
            $table->integer('passengers');
        });
    }
};
