<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->foreignId('car_id')->nullable()->constrained()->nullOnDelete();
        });

        // Copy car_id from rentals to revenues for existing records
        // Uses a subquery compatible with both PostgreSQL and MySQL
        try {
            DB::statement('
                UPDATE revenues
                SET car_id = rentals.car_id
                FROM rentals
                WHERE revenues.rental_id = rentals.id
                  AND revenues.car_id IS NULL
            ');
        } catch (\Exception $e) {
            // Ignore if tables are empty or query fails
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropForeign(['car_id']);
            $table->dropColumn('car_id');
        });
    }
};
