<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE peminjamans
            MODIFY status ENUM(
                'Menunggu Persetujuan',
                'Dipinjam',
                'Dikembalikan'
            ) NOT NULL DEFAULT 'Menunggu Persetujuan'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE peminjamans
            MODIFY status ENUM(
                'Dipinjam',
                'Dikembalikan'
            ) NOT NULL DEFAULT 'Dipinjam'
        ");
    }
};