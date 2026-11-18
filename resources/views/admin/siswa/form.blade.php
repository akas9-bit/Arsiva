@extends('layouts.admin')

@section('page_title', $siswa->exists ? 'Edit Data Siswa' : 'Tambah Data Siswa')

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
        <h2 class="text-lg font-bold text-gray-800">{{ $siswa->exists ? 'Edit Data Siswa' : 'Tambah Siswa Baru' }}</h2>
        <p class="mb-6 mt-1 text-sm text-gray-500">Admin membuat password siswa di sini. Siswa masuk menggunakan NISN dan password yang telah dibuat.</p>

        @if ($errors->any())
            <div class="mb-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-600">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ $siswa->exists ? route('admin.siswa.update', $siswa) : route('admin.siswa.store') }}" class="space-y-5">
            @csrf
            @if($siswa->exists) @method('PUT') @endif

            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                <input type="text" name="name" required maxlength="255" value="{{ old('name', $siswa->name) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">NISN</label>
                <input type="text" name="nisn" required inputmode="numeric" pattern="[0-9]{8,10}" maxlength="10" value="{{ old('nisn', $siswa->nisn) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                <p class="mt-1 text-xs text-gray-500">Masukkan 8 sampai 10 angka.</p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Password Siswa</label>
                <input type="password" name="password" {{ $siswa->exists ? '' : 'required' }} minlength="8" autocomplete="new-password"
                       placeholder="{{ $siswa->exists ? 'Kosongkan jika tidak ingin mengubah password' : 'Buat password untuk siswa (minimal 8 karakter)' }}"
                       class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                <p class="mt-1 text-xs text-gray-500">
                    {{ $siswa->exists ? 'Isi hanya jika ingin mengganti password siswa.' : 'Password ini akan diberikan kepada siswa untuk login.' }}
                </p>
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Kelas</label>
                <input type="text" name="kelas" maxlength="20" placeholder="Contoh: XII RPL A" value="{{ old('kelas', $siswa->kelas) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
            </div>

            <div>
                <label class="mb-1 block text-sm font-semibold text-gray-700">Status Pengambilan Ijazah</label>
                <select name="status_ijazah" required class="w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm">
                    <option value="Belum Diambil" @selected(old('status_ijazah', $siswa->status_ijazah ?? 'Belum Diambil') === 'Belum Diambil')>Belum Diambil</option>
                    <option value="Sudah Diambil" @selected(old('status_ijazah', $siswa->status_ijazah) === 'Sudah Diambil')>Sudah Diambil</option>
                </select>
            </div>

            <div class="flex flex-col-reverse gap-2 border-t pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('admin.siswa.index') }}" class="rounded-lg bg-gray-100 px-5 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-200">Batal</a>
                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-blue-700">Simpan Data Siswa</button>
            </div>
        </form>
    </div>
</div>
@endsection
