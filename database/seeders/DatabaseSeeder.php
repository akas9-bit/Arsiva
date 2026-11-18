<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | AKUN ADMIN
        |--------------------------------------------------------------------------
        */

        User::firstOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Petugas Tata Usaha',
                'password' => 'password123',
                'role' => 'admin',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        |
        | Pertahankan seluruh daftar JSON siswa milikmu.
        | Jangan menghapus data nama, NISN, dan kelas yang sudah ada.
        |
        */

        $siswaRpl = json_decode(<<<'JSON'
[
    TEMPEL_DAFTAR_JSON_SISWA_KAMU_DI_SINI
]
JSON, true);

        // Periksa apakah JSON berhasil dibaca
        if (!is_array($siswaRpl)) {
            throw new \RuntimeException(
                'Data siswa tidak valid. Periksa format JSON di DatabaseSeeder.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | PROSES MEMBUAT AKUN SISWA
        |--------------------------------------------------------------------------
        */

        foreach ($siswaRpl as $data) {

            // Pastikan data memiliki NISN
            $nisn = trim((string) ($data['nisn'] ?? ''));

            // Lewati NISN yang tidak valid
            if (!preg_match('/^[0-9]{8,10}$/', $nisn)) {
                continue;
            }

            // Cari akun berdasarkan NISN
            $user = User::firstOrNew([
                'nisn' => $nisn,
            ]);

            // Periksa apakah akun baru
            $akunBaru = !$user->exists;

            // Simpan data siswa
            $user->fill([
                'name' => $data['name'],
                'kelas' => $data['kelas'],
                'email' => $nisn . '@siswa.arsiva.local',
                'role' => 'siswa',
            ]);

            // Password awal menggunakan NISN
            // Hanya diberikan kepada akun yang baru dibuat
            if ($akunBaru) {
                $user->password = $nisn;
            }

            $user->save();
        }
    }
}
