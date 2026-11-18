@extends('layouts.admin')

@section('page_title', 'Kelola Data Siswa')

@section('content')
<div class="space-y-6">
    @if (session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-600">{{ $errors->first() }}</div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Total Siswa</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ $totalSiswa }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Ijazah Belum Diambil</p>
            <p class="mt-2 text-3xl font-bold text-amber-600">{{ $belumDiambil }}</p>
        </div>
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <p class="text-sm text-gray-500">Ijazah Sudah Diambil</p>
            <p class="mt-2 text-3xl font-bold text-green-600">{{ $sudahDiambil }}</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b p-4 sm:flex-row sm:items-center sm:justify-between sm:p-6">
            <div>
                <h2 class="text-lg font-bold text-gray-800">Data Siswa</h2>
                <p class="mt-1 text-sm text-gray-500">Tambah dan kelola data siswa serta status pengambilan ijazah.</p>
            </div>
            <a href="{{ route('admin.siswa.create') }}" class="rounded-lg bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-blue-700">
                + Tambah Siswa
            </a>
        </div>

        <form method="GET" action="{{ route('admin.siswa.index') }}" class="flex flex-col gap-2 border-b bg-gray-50 p-4 sm:flex-row">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NISN, atau kelas..." class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <select name="status_ijazah" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm">
                <option value="">Semua Status Ijazah</option>
                <option value="Belum Diambil" @selected(request('status_ijazah') === 'Belum Diambil')>Belum Diambil</option>
                <option value="Sudah Diambil" @selected(request('status_ijazah') === 'Sudah Diambil')>Sudah Diambil</option>
            </select>
            <button class="rounded-lg bg-slate-800 px-5 py-2 text-sm font-semibold text-white hover:bg-slate-700">Cari</button>
            @if(request()->hasAny(['q', 'status_ijazah']))
                <a href="{{ route('admin.siswa.index') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-center text-sm font-semibold text-gray-700">Reset</a>
            @endif
        </form>

        <div class="w-full overflow-x-auto">
            <table class="w-full min-w-[850px] text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-5 py-4">No.</th>
                        <th class="px-5 py-4">Nama Siswa</th>
                        <th class="px-5 py-4">NISN</th>
                        <th class="px-5 py-4">Kelas</th>
                        <th class="px-5 py-4">Status Ijazah</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($siswa as $item)
                        <tr class="hover:bg-blue-50/50">
                            <td class="px-5 py-4">{{ $siswa->firstItem() + $loop->index }}</td>
                            <td class="px-5 py-4 font-semibold">{{ $item->name }}</td>
                            <td class="px-5 py-4">{{ $item->nisn }}</td>
                            <td class="px-5 py-4">{{ $item->kelas ?? '-' }}</td>
                            <td class="px-5 py-4">
                                <form action="{{ route('admin.siswa.updateStatus', $item) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_ijazah" class="rounded-lg border border-gray-300 px-2 py-2 text-xs">
                                        <option value="Belum Diambil" @selected($item->status_ijazah === 'Belum Diambil')>Belum Diambil</option>
                                        <option value="Sudah Diambil" @selected($item->status_ijazah === 'Sudah Diambil')>Sudah Diambil</option>
                                    </select>
                                    <button class="rounded-lg bg-slate-800 px-3 py-2 text-xs text-white hover:bg-slate-700">Simpan</button>
                                </form>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.siswa.edit', $item) }}" class="rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Edit</a>
                                    <form action="{{ route('admin.siswa.destroy', $item) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-gray-400">Data siswa tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t bg-gray-50 p-4">{{ $siswa->links() }}</div>
    </div>
</div>
@endsection
