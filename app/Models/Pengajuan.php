<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan';

    protected $fillable = [
    'user_id',
    'jenis_layanan',
    'nisn',
    'tanggal_pengajuan',
    'keterangan',
    'berkas_pendukung',
    'berkas_hasil',
    'status',
    'pesan_admin',
];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
