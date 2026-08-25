<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // PostgreSQL-compatible: change the role column to include 'superadmin'
        // Drop check constraint if it exists (specific to Postgres)
        if (DB::getDriverName() === 'pgsql') {
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');
        }

        // We use string type with a check constraint (works on both MySQL & PgSQL)
        Schema::table('users', function (Blueprint $table) {
            // Drop old enum and replace with string + default (cross-DB compatible)
            $table->string('role')->default('user')->change();
        });

        // Add is_active column for enabling/disabling admin users
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_active')) {
                $table->dropColumn('is_active');
            }
            $table->string('role')->default('user')->change();
        });
    }
};
