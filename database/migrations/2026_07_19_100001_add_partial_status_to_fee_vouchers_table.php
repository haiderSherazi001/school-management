<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE fee_vouchers MODIFY status ENUM('unpaid','partial','paid','cancelled') NOT NULL DEFAULT 'unpaid'");
    }

    public function down(): void
    {
        if (DB::table('fee_vouchers')->where('status', 'partial')->exists()) {
            throw new \RuntimeException('Cannot roll back: fee_vouchers rows exist with status=partial. Resolve them before reverting this migration.');
        }

        DB::statement("ALTER TABLE fee_vouchers MODIFY status ENUM('unpaid','paid','cancelled') NOT NULL DEFAULT 'unpaid'");
    }
};
