<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('leaves')
            ->where('status', 'approved')
            ->whereNull('approved_by')
            ->update([
                'approved_by' => DB::raw('user_id'),
                'approved_at' => DB::raw('COALESCE(approved_at, updated_at, created_at, CURRENT_TIMESTAMP)'),
            ]);
    }

    public function down(): void
    {
        // Backfilled approval history cannot be reversed safely.
    }
};
