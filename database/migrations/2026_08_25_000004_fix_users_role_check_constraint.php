<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * When the original enum('role', ['admin','user']) column was changed to a
     * plain string via ->change(), PostgreSQL kept the old check constraint
     * "users_role_check" that only allows 'admin' or 'user'.
     *
     * This migration explicitly drops that constraint so 'superadmin' (and any
     * other future role values) can be inserted without a Check Violation error.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'pgsql') {
            // Drop the stale enum check constraint (IF EXISTS is safe - no-op if already gone)
            DB::statement('ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check');

            // Also ensure the column is a plain VARCHAR (no type-level restriction)
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user')->change();
            });
        }
    }

    public function down(): void
    {
        // Intentionally left empty - we cannot safely recreate the old constraint
        // without knowing which values are currently in the table.
    }
};
