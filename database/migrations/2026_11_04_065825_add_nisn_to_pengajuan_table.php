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
        Schema::table('pengajuan', function (Blueprint $table) {
            // Tambahkan kolom nisn di sini (sesuaikan tipe data, misal string)
            $table->string('nisn')->after('jenis_layanan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            // Hapus kolom nisn jika migrasi dibatalkan (rollback)
            $table->dropColumn('nisn');
        });
    }
};
