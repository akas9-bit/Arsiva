
@extends('layouts.app')

@section('page_title', 'Buat Pengajuan')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 md:p-8 rounded-xl shadow-sm border">

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm p-3 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900">
        <strong>Informasi pengambilan:</strong>
        Dokumen yang sudah selesai diproses tidak dikirim atau diunduh melalui aplikasi. Silakan ambil langsung di sekolah melalui Tata Usaha.
    </div>

    <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                Pilihan Jenis Layanan
            </label>

            <select id="jenis_layanan" name="jenis_layanan" required
                class="w-full px-4 py-2 border rounded-lg outline-none focus:border-blue-500">

                <option value="">Pilih jenis layanan</option>

                @foreach ($layanan as $item)
                    @if (in_array($item, ['Surat Keterangan Aktif Siswa', 'Surat Pindah Sekolah']))
                        @continue
                    @endif

                    <option value="{{ $item }}" @selected(old('jenis_layanan') === $item)>
                        {{ $item }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- INPUT NISN -->
        <div class="mb-4">
            <label for="nisn" class="block text-sm font-medium text-gray-700 mb-2">
                NISN (Nomor Induk Siswa Nasional)
            </label>

            <input
                type="text"
                id="nisn"
                name="nisn"
                value="{{ old('nisn') }}"
                maxlength="10"
                minlength="10"
                pattern="[0-9]{10}"
                inputmode="numeric"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                required
                placeholder="Masukkan 10 digit NISN"
                class="w-full px-4 py-2 border rounded-lg outline-none focus:border-blue-500"
            >

            <p class="text-xs text-gray-400 mt-1">
                NISN harus terdiri dari tepat 10 angka.
            </p>
        </div>

        <div class="mb-4">
            <label for="tanggal_pengajuan" class="block text-sm font-medium text-gray-700 mb-2">
                Input Tanggal
            </label>

            <input
                type="date"
                id="tanggal_pengajuan"
                name="tanggal_pengajuan"
                value="{{ old('tanggal_pengajuan', date('Y-m-d')) }}"
                required
                class="w-full px-4 py-2 border rounded-lg outline-none focus:border-blue-500"
            >
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                Keperluan Surat / Keterangan
            </label>

            <textarea
                id="keterangan"
                name="keterangan"
                rows="4"
                required
                class="w-full px-4 py-2 border rounded-lg outline-none focus:border-blue-500"
            >{{ old('keterangan') }}</textarea>
        </div>

        <div class="mb-6">
            <label for="berkas_pendukung" class="block text-sm font-medium text-gray-700 mb-2">
                Upload Berkas Pendukung
            </label>

            <input
                type="file"
                id="berkas_pendukung"
                name="berkas_pendukung"
                accept=".pdf,.jpg,.jpeg,.png"
                required
                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            >

            <p class="text-xs text-gray-400 mt-2">
                Format PDF, JPG, atau PNG. Maksimal 2 MB.
            </p>

            <!-- PREVIEW BERKAS -->
            <div id="preview-container" class="mt-4 hidden">
                <p class="text-xs font-medium text-gray-600 mb-2">
                    Pratinjau Gambar:
                </p>

                <img
                    id="image-preview"
                    src="#"
                    alt="Preview Berkas"
                    class="w-32 h-32 object-cover rounded-lg border shadow-sm"
                >
            </div>
        </div>

        <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
            Kirim Pengajuan
        </button>

    </form>
</div>

<!-- SCRIPT PREVIEW FOTO -->
<script>
    const fileInput = document.getElementById('berkas_pendukung');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                };

                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
                imagePreview.src = '#';
            }
        } else {
            previewContainer.classList.add('hidden');
            imagePreview.src = '#';
        }
    });
</script>
@endsection
