<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            // Guest customer info columns
            if (!Schema::hasColumn('rentals', 'customer_name')) {
                $table->string('customer_name')->nullable();
            }
            if (!Schema::hasColumn('rentals', 'customer_phone')) {
                $table->string('customer_phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('rentals', function (Blueprint $table) {
            $columns = [];
            if (Schema::hasColumn('rentals', 'customer_name')) $columns[] = 'customer_name';
            if (Schema::hasColumn('rentals', 'customer_phone')) $columns[] = 'customer_phone';
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
