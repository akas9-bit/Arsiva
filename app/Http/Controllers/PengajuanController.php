<?php

namespace App\Http\Controllers;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    public const LAYANAN = [
        'Legalisir Ijazah',
        'Surat Keterangan Aktif Siswa',
        'Duplikat Rapor',
        'Surat Keterangan Lulus',
        'Surat Pindah Sekolah',
    ];

    public function beranda()
    {
        $id = Auth::id();

        $hitung = fn (string $status) =>
            Pengajuan::where('user_id', $id)
                ->where('status', $status)
                ->count();

        return view('beranda', [
            'total' => Pengajuan::where('user_id', $id)->count(),
            'pending' => $hitung('Pending'),
            'diproses' => $hitung('Diproses'),
            'selesai' => $hitung('Siap Diambil'),
            'ditolak' => $hitung('Ditolak'),
            'terbaru' => Pengajuan::where('user_id', $id)
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }

    public function create()
    {
        $layananFiltered = array_values(array_filter(
            self::LAYANAN,
            function ($value, $index) {
                return !in_array($index, [1, 4]);
            },
            ARRAY_FILTER_USE_BOTH
        ));

        return view('pengajuan.create', [
            'layanan' => $layananFiltered
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jenis_layanan' => ['required', Rule::in(self::LAYANAN)],
            'nisn' => ['required', 'numeric', 'digits_between:8,12'],
            'tanggal_pengajuan' => ['required', 'date'],
            'keterangan' => ['required', 'string', 'max:1000'],
            'berkas_pendukung' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048'
            ],
        ], [
            'jenis_layanan.required' => 'Pilih jenis layanan dulu.',
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.numeric' => 'NISN harus berupa angka.',
            'tanggal_pengajuan.required' => 'Tanggal wajib diisi.',
            'keterangan.required' => 'Keperluan wajib diisi.',
            'berkas_pendukung.required' => 'Upload berkas pendukung dulu.',
            'berkas_pendukung.mimes' => 'Berkas harus berformat PDF, JPG, atau PNG.',
            'berkas_pendukung.max' => 'Ukuran berkas maksimal 2 MB.',
        ]);

        $data['berkas_pendukung'] =
            $request->file('berkas_pendukung')->store('berkas');

        $data['user_id'] = Auth::id();
        $data['status'] = 'Pending';

        Pengajuan::create($data);

        return redirect()
            ->route('pengajuan.riwayat')
            ->with('success', 'Pengajuan berhasil dikirim.');
    }

    public function riwayat(Request $request)
    {
        $query = Pengajuan::where('user_id', Auth::id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate(
                'tanggal_pengajuan',
                $request->tanggal
            );
        }

        $pengajuans = $query->latest()->get();

        return view('pengajuan.riwayat', compact('pengajuans'));
    }

    public function berkas(Pengajuan $pengajuan)
{
    $user = Auth::user();

    abort_unless(
        $user && (
            $user->role === 'admin' ||
            (int) $pengajuan->user_id === (int) $user->id
        ),
        403
    );

    abort_unless(
        Storage::exists($pengajuan->berkas_pendukung),
        404,
        'Berkas tidak ditemukan.'
    );

    return Storage::response($pengajuan->berkas_pendukung);
}
    // Route lama tetap diarahkan ke riwayat.
    // Dokumen hasil tidak lagi dikirim secara online.
    public function hasil(Pengajuan $pengajuan)
{
    $user = Auth::user();

    abort_unless(
        $user && (
            $user->role === 'admin' ||
            (int) $pengajuan->user_id === (int) $user->id
        ),
        403
    );

    return redirect()
        ->route('pengajuan.riwayat')
        ->with(
            'success',
            'Dokumen diambil langsung di sekolah. Silakan lihat status dan pesan dari admin.'
        );
}
}
