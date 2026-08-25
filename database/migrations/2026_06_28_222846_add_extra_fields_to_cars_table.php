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
        Schema::table('cars', function (Blueprint $table) {
            $table->decimal('late_return_penalty', 10, 2)->nullable();
            $table->date('next_service_due')->nullable();
            $table->date('insurance_expiry')->nullable();
            $table->date('road_tax_expiry')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn([
                'late_return_penalty',
                'next_service_due',
                'insurance_expiry',
                'road_tax_expiry',
            ]);
        });
    }
};
