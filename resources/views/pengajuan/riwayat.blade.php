
@extends('layouts.app')

@section('page_title', 'Status & Riwayat Pengajuan')

@section('content')

@php
    $warna = [
        'Pending' => 'bg-yellow-100 text-yellow-700',
        'Diproses' => 'bg-blue-100 text-blue-700',
        'Siap Diambil' => 'bg-emerald-100 text-emerald-700',
        'Sudah Diambil' => 'bg-green-100 text-green-700',
        'Ditolak' => 'bg-red-100 text-red-700',
    ];
@endphp

@if (session('success'))
    <div class="mb-5 bg-green-50 border border-green-200 text-green-700 text-sm p-4 rounded-xl">
        {{ session('success') }}
    </div>
@endif

<form method="GET"
      action="{{ route('pengajuan.riwayat') }}"
      class="mb-6 bg-white p-4 rounded-xl shadow-sm border flex flex-wrap gap-4 items-end">

    <div class="flex-1 min-w-[200px]">
        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
            Status
        </label>

        <select name="status" id="status"
                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">

            <option value="">Semua Status</option>

            @foreach (['Pending', 'Diproses', 'Siap Diambil', 'Sudah Diambil', 'Ditolak'] as $s)
                <option value="{{ $s }}" @selected(request('status') == $s)>
                    {{ $s }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="flex-1 min-w-[200px]">
        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">
            Tanggal Pengajuan
        </label>

        <input type="date"
               name="tanggal"
               id="tanggal"
               value="{{ request('tanggal') }}"
               class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
    </div>

    <div class="flex gap-2">
        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
            Filter
        </button>

        <a href="{{ route('pengajuan.riwayat') }}"
           class="bg-gray-100 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
            Reset
        </a>
    </div>
</form>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">

    <div class="p-5 border-b">
        <h3 class="font-bold text-gray-800 text-lg">
            Riwayat Pengajuan Dokumen
        </h3>

        <p class="text-sm text-gray-500 mt-1">
            Pantau status pengajuan dan baca pesan dari admin sekolah.
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[850px] text-left border-collapse">

            <thead>
                <tr class="bg-gray-50 border-b text-gray-600 text-sm">
                    <th class="py-3 px-5">No</th>
                    <th class="py-3 px-5">Jenis Layanan</th>
                    <th class="py-3 px-5">Tanggal</th>
                    <th class="py-3 px-5">Status</th>
                    <th class="py-3 px-5">Berkas Saya</th>
                    <th class="py-3 px-5">Pesan Admin</th>
                </tr>
            </thead>

            <tbody class="divide-y text-gray-700 text-sm">

                @forelse ($pengajuans as $p)

                    <tr class="align-top">

                        <td class="py-4 px-5">
                            {{ $loop->iteration }}
                        </td>

                        <td class="py-4 px-5 font-medium">
                            {{ $p->jenis_layanan }}
                        </td>

                        <td class="py-4 px-5 whitespace-nowrap">
                            {{ $p->tanggal_pengajuan->format('d/m/Y') }}
                        </td>

                        <td class="py-4 px-5">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $warna[$p->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $p->status }}
                            </span>

                            @if ($p->status === 'Siap Diambil')
                                <p class="text-xs text-emerald-700 mt-2 max-w-[180px]">
                                    Silakan datang ke sekolah untuk mengambil dokumen.
                                </p>

                            @elseif ($p->status === 'Sudah Diambil')
                                <p class="text-xs text-green-700 mt-2">
                                    Dokumen sudah diserahkan.
                                </p>

                            @elseif ($p->status === 'Ditolak')
                                <p class="text-xs text-red-600 mt-2">
                                    Pengajuan ditolak. Silakan baca pesan admin.
                                </p>
                            @endif
                        </td>

                        <td class="py-4 px-5">
                            <a href="{{ route('pengajuan.berkas', $p) }}"
                               target="_blank"
                               class="text-blue-600 hover:underline">
                                Lihat Berkas
                            </a>
                        </td>

                        {{-- PESAN ADMIN --}}
                        <td class="py-4 px-5 max-w-xs">

                            @if (!empty($p->pesan_admin))

                                <div class="bg-blue-50 border border-blue-100 rounded-lg p-3">

                                    <p class="text-xs font-semibold text-blue-800 mb-1">
                                        Pesan dari Admin
                                    </p>

                                    <p class="text-sm text-gray-700 whitespace-pre-line break-words">
                                        {{ $p->pesan_admin }}
                                    </p>

                                </div>

                            @else

                                <span class="text-gray-400">
                                    Belum ada pesan dari admin.
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="py-10 text-center text-gray-400">
                            Belum ada pengajuan.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>
</div>

@endsection
