<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    private const STATUS = [
        'Pending',
        'Diproses',
        'Siap Diambil',
        'Sudah Diambil',
        'Ditolak',
    ];

    public function index(Request $request)
    {
        $query = Pengajuan::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengajuans = $query->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.dashboard', [
            'pengajuans' => $pengajuans,
            'pending' => Pengajuan::where('status', 'Pending')->count(),
            'diproses' => Pengajuan::where('status', 'Diproses')->count(),
            'siapDiambil' => Pengajuan::where('status', 'Siap Diambil')->count(),
            'sudahDiambil' => Pengajuan::where('status', 'Sudah Diambil')->count(),
            'ditolak' => Pengajuan::where('status', 'Ditolak')->count(),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => [
                'required',
                Rule::in(self::STATUS),
            ],
            'komentar_admin' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'status.required' => 'Pilih status pengajuan.',
            'komentar_admin.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        // Simpan status dan pesan admin ke database.
        $pengajuan->update([
            'status' => $data['status'],
            'pesan_admin' => $data['komentar_admin'] ?? null,
        ]);

        return redirect()->back()->with(
            'success',
            'Status dan pesan untuk siswa berhasil diperbarui.'
        );
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        // Hapus berkas pendukung.
        if (
            $pengajuan->berkas_pendukung &&
            Storage::exists($pengajuan->berkas_pendukung)
        ) {
            Storage::delete($pengajuan->berkas_pendukung);
        }

        // Hapus berkas hasil jika tersedia.
        if (
            $pengajuan->berkas_hasil &&
            Storage::exists($pengajuan->berkas_hasil)
        ) {
            Storage::delete($pengajuan->berkas_hasil);
        }

        $pengajuan->delete();

        return redirect()->back()->with(
            'success',
            'Pengajuan berhasil dihapus.'
        );
    }
}
