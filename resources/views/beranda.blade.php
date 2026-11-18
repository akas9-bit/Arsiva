@extends('layouts.app')

@section('page_title', 'Beranda')

@section('content')
@php
    // ====== EDIT DATA SEKOLAHMU DI SINI ======
    $sekolah = [
        'nama'      => 'SMK Negeri 5 SURAKARTA',
        'tagline'   => 'Cerdas, Berkarakter, dan Siap Berkarya',
        'deskripsi' => 'Arsiva adalah layanan online SMK Negeri 5 SURAKARTA untuk mengajukan dokumen akademik. Siswa dan alumni bisa mengajukan legalisir ijazah, surat keterangan, dan dokumen lain tanpa antre di ruang Tata Usaha.',
        'visi'      => 'Menjadi sekolah kejuruan yang unggul, berkarakter, dan mampu bersaing di dunia kerja.',
        'misi'      => [
            'Menyelenggarakan pembelajaran yang berkualitas dan berbasis praktik.',
            'Menanamkan disiplin, integritas, dan tanggung jawab.',
            'Mengembangkan layanan administrasi sekolah yang cepat dan transparan.',
        ],
        'alamat'    => 'Jl. Adi Sucipto No.42, Kerten, Kec. Laweyan, Kota Surakarta, Jawa Tengah',
        'telepon'   => '(0271) 713916',
        'email'     => 'lapor@smkn5surakarta.sch.id',
        'jam'       => 'Senin - Jumat, 07.30 - 15.00 WIB',
    ];
    // =========================================

    $warna = [
        'Pending'  => 'bg-yellow-100 text-yellow-700',
        'Diproses' => 'bg-blue-100 text-blue-700',
        'Selesai'  => 'bg-green-100 text-green-700',
        'Ditolak'  => 'bg-red-100 text-red-700',
    ];
    $kartu = [['Total', $total], ['Pending', $pending], ['Diproses', $diproses], ['Selesai', $selesai], ['Ditolak', $ditolak]];
    $siap  = $terbaru->whereNotNull('berkas_hasil')->count();
    $alur  = [
        ['Pilih layanan', 'Tentukan dokumen yang kamu butuhkan.'],
        ['Isi dan upload', 'Isi keperluan, lalu unggah berkas pendukung.'],
        ['Diperiksa sekolah', 'Tata Usaha memeriksa dan memproses pengajuanmu.'],
        ['Ambil di sekolah', 'Dokumen yang selesai dapat diambil langsung melalui Tata Usaha sekolah.'],
    ];
@endphp

{{-- Banner sekolah --}}
<div class="bg-blue-600 text-white rounded-2xl p-6 md:p-8 mb-6">
    <p class="text-blue-100 text-sm mb-1">Selamat datang, {{ auth()->user()->name }}</p>
    <h2 class="text-2xl md:text-3xl font-bold">{{ $sekolah['nama'] }}</h2>
    <p class="text-blue-100 mt-1 font-medium">{{ $sekolah['tagline'] }}</p>
    <p class="mt-4 text-sm md:text-base text-white/90 max-w-3xl leading-relaxed">{{ $sekolah['deskripsi'] }}</p>
    <a href="{{ route('pengajuan.create') }}" class="inline-block mt-4 bg-white text-blue-600 font-semibold px-5 py-2.5 rounded-lg hover:bg-blue-50 transition shadow-sm">Buat pengajuan</a>
</div>

{{-- Pemberitahuan dokumen siap --}}
@if ($siap > 0)
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm p-4 rounded-lg flex items-center justify-between">
        <span>Ada <strong>{{ $siap }}</strong> dokumen dari sekolah yang siap diunduh. Silakan cek pada tabel di bawah.</span>
    </div>
@endif

{{-- Ringkasan angka --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
    @foreach ($kartu as [$label, $jumlah])
        <div class="bg-white rounded-xl border p-5 shadow-sm">
            <div class="text-3xl font-bold text-gray-800">{{ $jumlah }}</div>
            <div class="text-sm text-gray-500 mt-1">{{ $label }}</div>
        </div>
    @endforeach
</div>

{{-- Pengajuan terbaru --}}
<div class="bg-white rounded-xl shadow-sm border overflow-hidden mb-6">
    <div class="p-5 border-b flex justify-between items-center">
        <h3 class="font-bold text-gray-800">Pengajuan terbaru</h3>
        <a href="{{ route('pengajuan.riwayat') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <tbody class="divide-y text-sm text-gray-700">
                @forelse ($terbaru as $p)
                    <tr>
                        <td class="py-4 px-6 font-medium">{{ $p->jenis_layanan }}</td>
                        <td class="py-4 px-6 text-gray-500">{{ $p->tanggal_pengajuan->format('d/m/Y') }}</td>
                        <td class="py-4 px-6"><span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warna[$p->status] ?? 'bg-gray-100 text-gray-600' }}">{{ $p->status }}</span></td>
                        <td class="py-4 px-6">
                            @if ($p->berkas_hasil)
                                {{-- Diubah: target="_blank" dihapus dan ditambahkan atribut download --}}
                                <span class="inline-block bg-emerald-50 text-emerald-700 text-xs font-semibold px-3 py-1.5 rounded-lg">Siap diambil di sekolah</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-10 px-6 text-center text-gray-400">Belum ada pengajuan. Mulai dari tombol <strong>Buat pengajuan</strong>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Alur pengajuan --}}
<div class="bg-white rounded-xl border p-6 shadow-sm mb-8">
    <h3 class="font-bold text-gray-800 mb-5 text-base">Cara mengajukan dokumen</h3>
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($alur as $i => [$judul, $isi])
            <div class="flex gap-3">
                <div class="flex-none w-8 h-8 rounded-full bg-blue-600 text-white text-sm font-bold flex items-center justify-center">{{ $i + 1 }}</div>
                <div>
                    <div class="font-semibold text-gray-800 text-sm">{{ $judul }}</div>
                    <p class="text-sm text-gray-500 mt-1 leading-relaxed">{{ $isi }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

{{-- Visi, misi, kontak --}}
<div class="grid md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white rounded-xl border p-6 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-3 text-base">Visi</h3>
        <p class="text-sm text-gray-600 leading-relaxed mb-5">{{ $sekolah['visi'] }}</p>
        <h3 class="font-bold text-gray-800 mb-3 text-base">Misi</h3>
        <ul class="list-disc pl-5 space-y-2 text-sm text-gray-600 leading-relaxed">
            @foreach ($sekolah['misi'] as $m)
                <li>{{ $m }}</li>
            @endforeach
        </ul>
    </div>

    <div class="bg-white rounded-xl border p-6 shadow-sm">
        <h3 class="font-bold text-gray-800 mb-3 text-base">Kontak Tata Usaha</h3>
        <dl class="space-y-4 text-sm">
            <div>
                <dt class="text-gray-400 font-medium">Alamat</dt>
                <dd class="text-gray-700 mt-0.5">{{ $sekolah['alamat'] }}</dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">Telepon</dt>
                <dd class="text-gray-700 mt-0.5">{{ $sekolah['telepon'] }}</dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">Email</dt>
                <dd class="text-gray-700 mt-0.5">{{ $sekolah['email'] }}</dd>
            </div>
            <div>
                <dt class="text-gray-400 font-medium">Jam layanan</dt>
                <dd class="text-gray-700 mt-0.5">{{ $sekolah['jam'] }}</dd>
            </div>
        </dl>
    </div>
</div>

{{-- Footer Halaman --}}




@endsection
