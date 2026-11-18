<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    // MENAMPILKAN DATA SISWA
    public function index(Request $request)
    {
        $query = User::where('role', 'siswa');

        if ($request->filled('q')) {
            $kata = trim($request->q);

            $query->where(function ($q) use ($kata) {
                $q->where('name', 'like', "%{$kata}%")
                  ->orWhere('nisn', 'like', "%{$kata}%")
                  ->orWhere('kelas', 'like', "%{$kata}%");
            });
        }

        if ($request->filled('status_ijazah')) {
            $query->where('status_ijazah', $request->status_ijazah);
        }

        $siswa = $query->orderBy('kelas')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.siswa.index', [
            'siswa' => $siswa,
            'totalSiswa' => User::where('role', 'siswa')->count(),
            'belumDiambil' => User::where('role', 'siswa')
                ->where('status_ijazah', 'Belum Diambil')->count(),
            'sudahDiambil' => User::where('role', 'siswa')
                ->where('status_ijazah', 'Sudah Diambil')->count(),
        ]);
    }

    // FORM TAMBAH SISWA
    public function create()
    {
        return view('admin.siswa.form', [
            'siswa' => new User()
        ]);
    }

    // MENDAFTARKAN SISWA BARU
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nisn' => ['required', 'regex:/^[0-9]{8,10}$/', 'unique:users,nisn'],
            'kelas' => ['nullable', 'string', 'max:20'],
            'status_ijazah' => [
                'required',
                Rule::in(['Belum Diambil', 'Sudah Diambil'])
            ],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.regex' => 'NISN harus berupa 8 sampai 10 angka.',
            'nisn.unique' => 'NISN tersebut sudah terdaftar.',
        ]);

        $nisn = trim($data['nisn']);

        User::create([
            'name' => trim($data['name']),
            'nisn' => $nisn,
            'kelas' => $data['kelas'] ?? null,
            'email' => $nisn . '@siswa.arsiva.local',

            // Password awal otomatis menggunakan NISN
            'password' => $nisn,

            'role' => 'siswa',
            'status_ijazah' => $data['status_ijazah'],
        ]);

        return redirect()
            ->route('admin.siswa.index')
            ->with(
                'success',
                'Siswa berhasil didaftarkan. Username dan password awal menggunakan NISN.'
            );
    }

    // FORM EDIT SISWA
    public function edit(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);

        return view('admin.siswa.form', compact('siswa'));
    }

    // MEMPERBARUI DATA SISWA
    public function update(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'nisn' => [
                'required',
                'regex:/^[0-9]{8,10}$/',
                Rule::unique('users', 'nisn')->ignore($siswa->id)
            ],

            'password' => ['nullable', 'string', 'min:8', 'max:255'],
            'kelas' => ['nullable', 'string', 'max:20'],

            'status_ijazah' => [
                'required',
                Rule::in(['Belum Diambil', 'Sudah Diambil'])
            ],
        ], [
            'nisn.regex' => 'NISN harus berupa 8 sampai 10 angka.',
            'nisn.unique' => 'NISN tersebut sudah digunakan siswa lain.',
        ]);

        $nisn = trim($data['nisn']);

        $siswa->update([
            'name' => trim($data['name']),
            'nisn' => $nisn,
            'kelas' => $data['kelas'] ?? null,
            'email' => $nisn . '@siswa.arsiva.local',
            'status_ijazah' => $data['status_ijazah'],
        ]);

        // Password hanya berubah jika admin mengisi password baru
        if (!empty($data['password'])) {
            $siswa->password = $data['password'];
            $siswa->save();
        }

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // MEMPERBARUI STATUS IJAZAH
    public function updateStatus(Request $request, User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);

        $data = $request->validate([
            'status_ijazah' => [
                'required',
                Rule::in(['Belum Diambil', 'Sudah Diambil'])
            ],
        ]);

        $siswa->update($data);

        return redirect()->back()->with(
            'success',
            'Status pengambilan ijazah berhasil diperbarui.'
        );
    }

    // MENGHAPUS DATA SISWA
    public function destroy(User $siswa)
    {
        abort_unless($siswa->role === 'siswa', 404);

        if ($siswa->pengajuan()->exists()) {
            return redirect()->back()->withErrors([
                'siswa' => 'Siswa tidak bisa dihapus karena masih memiliki riwayat pengajuan dokumen.',
            ]);
        }

        $siswa->delete();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }
}
