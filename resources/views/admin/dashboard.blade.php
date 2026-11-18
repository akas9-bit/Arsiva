
@extends('layouts.admin')

@section('page_title', 'Kelola Pengajuan Dokumen Akademik Siswa')

@section('content')

@php
    $warna = [
        'Pending'      => 'bg-yellow-100 text-yellow-700',
        'Diproses'     => 'bg-blue-100 text-blue-700',
        'Siap Diambil' => 'bg-green-100 text-green-700',
        'Sudah Diambil'=> 'bg-emerald-100 text-emerald-700',
        'Ditolak'      => 'bg-red-100 text-red-700',
    ];

    $daftarStatus = [
        'Pending',
        'Diproses',
        'Siap Diambil',
        'Sudah Diambil',
        'Ditolak',
    ];
@endphp

{{-- NOTIFIKASI --}}
@if (session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm p-4 rounded-xl">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 bg-red-50 border border-red-200 text-red-600 text-sm p-4 rounded-xl">
        {{ $errors->first() }}
    </div>
@endif

{{-- KARTU STATISTIK --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-6">

    @foreach ([
        ['Pending', $pending ?? 0, 'bg-yellow-100 text-yellow-600', '⏳'],
        ['Diproses', $diproses ?? 0, 'bg-blue-100 text-blue-600', '📋'],
        ['Siap Diambil', $siapDiambil ?? 0, 'bg-green-100 text-green-600', '📄'],
        ['Sudah Diambil', $sudahDiambil ?? 0, 'bg-emerald-100 text-emerald-600', '✓'],
        ['Ditolak', $ditolak ?? 0, 'bg-red-100 text-red-600', '✕']
    ] as [$label, $jumlah, $warnaIcon, $icon])

        <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-sm text-gray-500">{{ $label }}</p>
                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        {{ $jumlah }}
                    </h2>
                </div>

                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl {{ $warnaIcon }}">
                    {{ $icon }}
                </div>
            </div>
        </div>

    @endforeach

</div>

{{-- DAFTAR PENGAJUAN --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">

    {{-- HEADER DAN FILTER --}}
    <div class="p-4 sm:p-6 border-b flex flex-col lg:flex-row justify-between lg:items-center gap-4">

        <div>
            <h3 class="font-bold text-gray-800 text-base sm:text-lg">
                Daftar Masuk Permohonan Dokumen
            </h3>

            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Kelola pengajuan dan berikan informasi pengambilan dokumen kepada siswa.
            </p>
        </div>

        <form method="GET"
              action="{{ route('admin.dashboard') }}"
              class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto">

            <select name="status"
                    class="w-full sm:w-auto border border-gray-300 rounded-lg px-4 py-2.5 text-sm bg-white outline-none focus:border-blue-500">

                <option value="">Semua Status</option>

                @foreach ($daftarStatus as $s)
                    <option value="{{ $s }}" @selected(request('status') == $s)>
                        {{ $s }}
                    </option>
                @endforeach

            </select>

            <button type="submit"
                    class="bg-blue-600 text-white text-sm font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-700 transition">
                Filter
            </button>

            @if(request('status'))
                <a href="{{ route('admin.dashboard') }}"
                   class="text-center bg-gray-100 text-gray-700 text-sm font-semibold px-4 py-2.5 rounded-lg hover:bg-gray-200 transition">
                    Reset
                </a>
            @endif

        </form>

    </div>

    {{-- TABEL RESPONSIF --}}
    <div class="w-full overflow-x-auto">

        <table class="w-full min-w-[1200px] text-left border-collapse">

            <thead>
                <tr class="bg-gray-50 border-b text-gray-600 text-xs uppercase">

                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Nama Siswa</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">NISN</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Jenis Layanan</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Keperluan</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Tanggal</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Berkas Siswa</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Status</th>
                    <th class="py-4 px-4 sm:px-5 whitespace-nowrap">Pesan Admin</th>
                    <th class="py-4 px-4 sm:px-5 text-center whitespace-nowrap">Aksi</th>

                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100 text-gray-700 text-sm">

                @forelse ($pengajuans as $item)

                    <tr class="hover:bg-blue-50/50 transition">

                        {{-- NAMA --}}
                        <td class="py-4 px-4 sm:px-5 font-semibold whitespace-nowrap">
                            {{ $item->user->name ?? '-' }}
                        </td>

                        {{-- NISN --}}
                        <td class="py-4 px-4 sm:px-5 font-medium text-gray-600 whitespace-nowrap">
                            {{ $item->nisn ?? '-' }}
                        </td>

                        {{-- JENIS LAYANAN --}}
                        <td class="py-4 px-4 sm:px-5 whitespace-nowrap">
                            {{ $item->jenis_layanan }}
                        </td>

                        {{-- KETERANGAN --}}
                        <td class="py-4 px-4 sm:px-5 max-w-xs">
                            <button type="button"
                                    onclick="openModal('modal-detail-{{ $item->id }}')"
                                    class="text-left truncate max-w-[180px] block cursor-pointer hover:text-blue-600 font-medium">
                                {{ $item->keterangan }}
                            </button>
                        </td>

                        {{-- TANGGAL --}}
                        <td class="py-4 px-4 sm:px-5 whitespace-nowrap">
                            {{ $item->tanggal_pengajuan->format('d/m/Y') }}
                        </td>

                        {{-- BERKAS SISWA --}}
                        <td class="py-4 px-4 sm:px-5 whitespace-nowrap">
                            <a href="{{ route('pengajuan.berkas', $item) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline font-medium">
                                Lihat Berkas
                            </a>
                        </td>

                        {{-- STATUS --}}
                        <td class="py-4 px-4 sm:px-5 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warna[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- PESAN ADMIN --}}
                        <td class="py-4 px-4 sm:px-5 max-w-[220px]">
                            <p class="text-xs text-gray-600 line-clamp-2">
                                {{ $item->komentar_admin ?: ($item->pesan_admin ?? 'Belum ada pesan') }}
                            </p>
                        </td>

                        {{-- AKSI --}}
                        <td class="py-4 px-4 sm:px-5 text-center whitespace-nowrap">

                            <button type="button"
                                    onclick="openModal('modal-detail-{{ $item->id }}')"
                                    class="bg-blue-600 text-white text-xs font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Kelola
                            </button>

                            <form action="{{ route('admin.pengajuan.destroy', $item->id) }}"
                                  method="POST"
                                  class="inline-block mt-1"
                                  onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="bg-red-600 text-white text-xs font-semibold px-3 py-2 rounded-lg hover:bg-red-700 transition">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="py-10 text-center text-gray-400">
                            Belum ada pengajuan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- PETUNJUK TABEL HP --}}
    <div class="sm:hidden px-4 py-2 bg-blue-50 text-blue-600 text-xs">
        Geser tabel ke kanan atau kiri untuk melihat semua data.
    </div>

    {{-- PAGINASI --}}
    <div class="p-4 border-t bg-gray-50 overflow-x-auto">
        {{ $pengajuans->links() }}
    </div>

</div>

{{-- MODAL DETAIL PENGAJUAN --}}
@foreach ($pengajuans as $item)

    <div id="modal-detail-{{ $item->id }}"
         class="fixed inset-0 z-[100] hidden items-start sm:items-center justify-center bg-gray-900/70 p-2 sm:p-4 overflow-y-auto">

        <div class="bg-white rounded-xl shadow-2xl w-full max-w-xl my-auto flex flex-col max-h-[calc(100dvh-16px)] sm:max-h-[90vh] overflow-hidden">

            {{-- HEADER MODAL --}}
            <div class="flex justify-between items-center px-4 sm:px-5 py-3 sm:py-4 bg-slate-800 text-white shrink-0">

                <h4 class="font-bold text-sm sm:text-base uppercase">
                    Detail Permohonan Dokumen
                </h4>

                <button type="button"
                        onclick="closeModal('modal-detail-{{ $item->id }}')"
                        class="text-white text-3xl leading-none hover:text-gray-300 px-2"
                        aria-label="Tutup">
                    &times;
                </button>

            </div>

            {{-- ISI MODAL --}}
            <div class="p-4 sm:p-5 space-y-4 text-sm text-gray-700 overflow-y-auto flex-1 min-h-0 overscroll-contain">

                {{-- INFORMASI SISWA --}}
                <div>
                    <h3 class="font-bold text-base text-slate-800 mb-4">
                        Informasi Pemohon
                    </h3>

                    <div class="space-y-3">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                            <span class="font-semibold text-gray-500">Nama Siswa</span>
                            <span class="sm:col-span-2 break-words">
                                {{ $item->user->name ?? '-' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                            <span class="font-semibold text-gray-500">NISN</span>
                            <span class="sm:col-span-2 break-words">
                                {{ $item->nisn ?? '-' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                            <span class="font-semibold text-gray-500">Jenis Layanan</span>
                            <span class="sm:col-span-2 break-words">
                                {{ $item->jenis_layanan }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                            <span class="font-semibold text-gray-500">Tanggal</span>
                            <span class="sm:col-span-2">
                                {{ $item->tanggal_pengajuan->format('d/m/Y') }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-2">
                            <span class="font-semibold text-gray-500">Status</span>
                            <span class="sm:col-span-2">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $warna[$item->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $item->status }}
                                </span>
                            </span>
                        </div>

                    </div>
                </div>

                {{-- KETERANGAN --}}
                <div class="pt-3 border-t">
                    <label class="font-semibold block mb-2">
                        Keperluan / Keterangan
                    </label>

                    <div class="p-3 bg-gray-50 border rounded-lg whitespace-pre-line break-words">
                        {{ $item->keterangan }}
                    </div>
                </div>

                {{-- BERKAS SISWA --}}
                <div class="pt-2">
                    <label class="font-semibold block mb-2">
                        Berkas dari Siswa
                    </label>

                    <a href="{{ route('pengajuan.berkas', $item) }}"
                       target="_blank"
                       class="text-blue-600 hover:underline font-medium">
                        Lihat Berkas Siswa
                    </a>
                </div>

                {{-- KELOLA STATUS DAN PESAN --}}
                <div class="pt-4 border-t">

                    <h3 class="font-bold text-slate-800 mb-3">
                        Kelola Pengajuan dan Pesan untuk Siswa
                    </h3>

                    <form action="{{ route('admin.pengajuan.updateStatus', $item->id) }}"
                          method="POST"
                          class="space-y-4">

                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block font-semibold mb-2">
                                Status Pengajuan
                            </label>

                            <select name="status"
                                    required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 outline-none focus:border-blue-500">

                                @foreach ($daftarStatus as $s)
                                    <option value="{{ $s }}" @selected($item->status === $s)>
                                        {{ $s }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">
                                Pesan untuk Siswa
                            </label>

                            <textarea name="komentar_admin"
                                      rows="4"
                                      maxlength="2000"
                                      placeholder="Contoh: Dokumen sudah siap. Silakan datang ke sekolah pada jam kerja untuk mengambil dokumen."
                                      class="w-full border border-gray-300 rounded-lg px-3 py-3 outline-none focus:border-blue-500 resize-y">{{ old('komentar_admin', $item->komentar_admin ?: ($item->pesan_admin ?? '')) }}</textarea>

                            <p class="text-xs text-gray-500 mt-1">
                                Pesan ini akan terlihat oleh siswa di halaman riwayat pengajuan.
                            </p>
                        </div>

                        <button type="submit"
                                class="w-full bg-blue-600 text-white py-2.5 rounded-lg hover:bg-blue-700 font-semibold transition">
                            Simpan Status dan Pesan
                        </button>

                    </form>

                </div>

                {{-- HAPUS PENGAJUAN --}}
                <div class="pt-4 border-t">

                    <h3 class="font-bold text-red-600 mb-2">
                        Hapus Permintaan
                    </h3>

                    <p class="text-xs text-gray-500 mb-3">
                        Pengajuan yang dihapus tidak dapat dikembalikan.
                        Pastikan kamu sudah memeriksa data ini.
                    </p>

                    <form action="{{ route('admin.pengajuan.destroy', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus permohonan ini?')">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="w-full bg-red-600 text-white py-2.5 rounded-lg hover:bg-red-700 font-semibold transition">
                            🗑 Hapus Permintaan
                        </button>

                    </form>

                </div>

            </div>

            {{-- FOOTER MODAL --}}
            <div class="px-4 sm:px-5 py-3 bg-gray-50 border-t flex justify-end shrink-0">

                <button type="button"
                        onclick="closeModal('modal-detail-{{ $item->id }}')"
                        class="bg-slate-800 text-white px-6 py-2.5 rounded-lg hover:bg-slate-700 transition">
                    Tutup
                </button>

            </div>

        </div>

    </div>

@endforeach

{{-- SCRIPT MODAL --}}
<script>

    function openModal(modalId) {
        const modal = document.getElementById(modalId);

        if (!modal) return;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);

        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.querySelectorAll('[id^="modal-detail-"]').forEach(function(modal) {
                if (!modal.classList.contains('hidden')) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });

            document.body.style.overflow = '';
        }
    });

    document.querySelectorAll('[id^="modal-detail-"]').forEach(function(modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal(modal.id);
            }
        });
    });

</script>

@endsection
