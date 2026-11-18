<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan kolom komentar_admin tersedia untuk controller dan riwayat siswa.
        if (!Schema::hasColumn('pengajuan', 'komentar_admin')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->text('komentar_admin')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pengajuan', 'komentar_admin')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->dropColumn('komentar_admin');
            });
        }
    }
};
