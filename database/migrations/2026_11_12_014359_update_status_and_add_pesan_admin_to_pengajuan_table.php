<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->string('status')->default('Pending')->change();
            $table->text('pesan_admin')->nullable()->after('status');
        });

        // Pengajuan lama yang berstatus Selesai dianggap siap diambil.
        DB::table('pengajuan')
            ->where('status', 'Selesai')
            ->update(['status' => 'Siap Diambil']);
    }

    public function down(): void
    {
        Schema::table('pengajuan', function (Blueprint $table) {
            $table->dropColumn('pesan_admin');
        });

        // Status tetap berupa string agar data lama tidak terpotong.
    }
};
