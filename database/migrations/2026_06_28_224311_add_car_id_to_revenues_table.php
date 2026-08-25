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
            $table->foreignId('car_id')->nullable()->after('rental_id')->constrained()->nullOnDelete();
        });

        // Copy car_id from rentals to revenues for existing records
        try {
            DB::table('revenues')
                ->join('rentals', 'revenues.rental_id', '=', 'rentals.id')
                ->update(['revenues.car_id' => DB::raw('rentals.car_id')]);
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
