<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengajuan', 'pesan_admin')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->text('pesan_admin')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pengajuan', 'pesan_admin')) {
            Schema::table('pengajuan', function (Blueprint $table) {
                $table->dropColumn('pesan_admin');
            });
        }
    }
};
