
@extends('layouts.app')

@section('page_title', 'Profil Pengguna')

@section('content')

<div class="w-full flex flex-col items-center py-8 px-4 gap-6">

    {{-- NOTIFIKASI --}}
    @if (session('success'))
        <div class="w-full max-w-md p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    @if (session('password_success'))
        <div class="w-full max-w-md p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
            {{ session('password_success') }}
        </div>
    @endif

    {{-- KARTU PROFIL --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">

        <form action="{{ route('profil.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="flex flex-col items-center">

            @csrf
            @method('PUT')

            {{-- FOTO PROFIL --}}
            <div class="relative mb-6">

                <div class="w-24 h-24 bg-blue-600 rounded-full overflow-hidden flex items-center justify-center text-white text-3xl font-bold shadow-md">

                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}"
                             alt="Foto Profil"
                             class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif

                </div>

                <label for="avatar"
                       class="absolute bottom-0 right-0 bg-white border border-gray-300 p-2 rounded-full shadow cursor-pointer hover:bg-gray-50">

                    <svg class="w-4 h-4 text-gray-600"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>

                    </svg>

                </label>

                <input type="file"
                       id="avatar"
                       name="avatar"
                       class="hidden"
                       accept="image/*">
            </div>

            @error('avatar')
                <p class="mb-3 text-xs text-red-500">{{ $message }}</p>
            @enderror

            <div class="w-full space-y-4">

                {{-- NAMA --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">
                        Nama Lengkap
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           required>

                    @error('name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">
                        Email Akademik
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                           required>

                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SIMPAN PROFIL --}}
                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition">
                        Simpan Perubahan Profil
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- KARTU GANTI PASSWORD --}}
    
{{-- KARTU GANTI PASSWORD --}}
<div class="w-full max-w-md bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-8">

    <div class="mb-5">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4">
                    </path>
                </svg>
            </div>

            <h3 class="text-lg font-bold text-gray-800">
                Keamanan Akun
            </h3>
        </div>

        <p class="text-sm text-gray-500">
            Ganti password akun agar akun kamu lebih aman.
        </p>
    </div>

    <form action="{{ route('profil.password.update') }}"
          method="POST"
          class="space-y-4">

        @csrf
        @method('PUT')

        {{-- PASSWORD LAMA --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">
                Password Lama
            </label>

            <div class="relative">
                <input type="password"
                       id="current_password"
                       name="current_password"
                       autocomplete="current-password"
                       placeholder="Masukkan password lama"
                       class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

                <button type="button"
                        onclick="togglePassword('current_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600"
                        aria-label="Tampilkan password"
                        aria-pressed="false">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            @error('current_password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- PASSWORD BARU --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">
                Password Baru
            </label>

            <div class="relative">
                <input type="password"
                       id="new_password"
                       name="password"
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

                <button type="button"
                        onclick="togglePassword('new_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600"
                        aria-label="Tampilkan password"
                        aria-pressed="false">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            @error('password')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">
                Konfirmasi Password Baru
            </label>

            <div class="relative">
                <input type="password"
                       id="confirm_password"
                       name="password_confirmation"
                       autocomplete="new-password"
                       placeholder="Ulangi password baru"
                       class="w-full px-4 py-3 pr-12 bg-gray-50 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 outline-none"
                       required>

                <button type="button"
                        onclick="togglePassword('confirm_password', this)"
                        class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-500 hover:text-blue-600"
                        aria-label="Tampilkan password"
                        aria-pressed="false">

                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- INFORMASI --}}
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3">
            <p class="text-xs text-blue-700">
                <strong>Tips keamanan:</strong>
                Gunakan password yang berbeda dari NISN dan jangan berikan password kepada orang lain.
            </p>
        </div>

        {{-- TOMBOL GANTI PASSWORD --}}
        <button type="submit"
                class="w-full py-3 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition">
            Ganti Password
        </button>

    </form>
</div>

{{-- SCRIPT LIHAT PASSWORD --}}
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);

        if (!input) return;

        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';

        button.setAttribute('aria-pressed', isHidden ? 'true' : 'false');

        button.setAttribute(
            'aria-label',
            isHidden ? 'Sembunyikan password' : 'Tampilkan password'
        );

        button.innerHTML = isHidden
            ? `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3l18 18M10.585 10.587a2 2 0 002.828 2.828M9.88 5.09A10.94 10.94 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.97 10.97 0 01-4.043 5.17M6.228 6.228A10.96 10.96 0 002.458 12c1.274 4.057 5.064 7 9.542 7 1.2 0 2.35-.22 3.41-.62"/>
               </svg>`
            : `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
               </svg>`;
    }
</script>


</div>

@endsection
