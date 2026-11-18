
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('page_title', 'Dashboard') - Arsiva</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }

        button,
        input[type="submit"] {
            font-weight: 600;
            letter-spacing: .01em;
        }

        /* SIDEBAR */
        #sidebar {
            width: 256px;
            height: 100vh;
            background-color: #0b1f3a !important;
            color: white;
            z-index: 30;
            overflow-y: auto;
            flex-shrink: 0;
        }

        /* LOGO */
        .logo-arsiva {
            width: 42px !important;
            height: 42px !important;
            max-width: 42px;
            max-height: 42px;
            object-fit: contain;
            flex-shrink: 0;
        }

        /* ANIMASI MENU SIDEBAR */
        #sidebar nav a {
            transition: all .2s ease-in-out;
            transform: scale(1);
            transform-origin: center;
        }

        #sidebar nav a:hover {
            transform: scale(1.04);
        }

        #sidebar nav a:active {
            transform: scale(.98);
        }

        /* AREA KONTEN */
        #content-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;
            min-width: 0;
            transition: margin-left .3s ease-in-out,
                        width .3s ease-in-out;
        }

        /* HEADER */
        .arsiva-header {
            height: 56px;
            min-height: 56px;
            background-color: #0b1f3a !important;
            color: white !important;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        /* FOOTER */
        .arsiva-footer {
            background-color: #0b1f3a !important;
            color: #ffffff !important;
            width: 100%;
            margin-top: auto;
            position: relative;
            opacity: 1 !important;
        }

        .arsiva-footer p,
        .arsiva-footer h3,
        .arsiva-footer h4,
        .arsiva-footer a {
            color: #ffffff;
        }

        .arsiva-footer .footer-muted {
            color: #dbeafe !important;
        }

        /* DESKTOP */
        @media (min-width: 768px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
            }

            #content-wrapper {
                margin-left: 256px;
                width: calc(100% - 256px);
            }
        }

        /* MOBILE */
        @media (max-width: 767px) {
            #sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                box-shadow: 5px 0 20px rgba(0,0,0,.2);
            }

            #content-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>

<body class="bg-gray-100 antialiased"
      x-data="{ open: window.innerWidth >= 768 }"
      @resize.window="open = window.innerWidth >= 768">

@php
    $menu = [
        ['Beranda', 'beranda', route('beranda'), 'home'],
        ['Buat Pengajuan', 'pengajuan.create', route('pengajuan.create'), 'file-plus'],
        ['Status & Riwayat', 'pengajuan.riwayat', route('pengajuan.riwayat'), 'history'],
        ['Profil', 'profil', route('profil'), 'user'],
    ];
@endphp

<!-- OVERLAY MOBILE -->
<div
    x-cloak
    x-show="open"
    x-transition.opacity
    @click="open = false"
    class="fixed inset-0 bg-black/50 z-20 md:hidden">
</div>

<!-- SIDEBAR -->
<aside
    id="sidebar"
    :class="open ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col justify-between
           bg-[#0b1f3a] text-white
           transform transition-transform duration-300 ease-in-out
           md:translate-x-0 md:static md:inset-auto shadow-lg">

    <div>
        <!-- LOGO SIDEBAR -->
        <div class="h-14 min-h-[56px] px-5 flex items-center gap-3 border-b border-white/10">

            <img
                src="{{ asset('images/logo-arsiva.png') }}"
                alt="Logo Arsiva"
                class="logo-arsiva">

            <span class="text-xl font-extrabold tracking-wide text-white">
                Arsiva
            </span>

            <!-- TOMBOL TUTUP MOBILE -->
            <button
                type="button"
                @click="open = false"
                class="md:hidden ml-auto text-blue-200 hover:text-white transition"
                aria-label="Tutup menu">

                <svg class="w-6 h-6"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

        <!-- MENU SIDEBAR -->
        <nav class="mt-6 px-3 space-y-2">

            @foreach ($menu as [$label, $rute, $url, $icon])

                <a
                    href="{{ $url }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl
                           text-sm font-semibold
                           {{ request()->routeIs($rute)
                                ? 'bg-blue-600 text-white shadow-lg shadow-blue-950/30'
                                : 'text-blue-100 hover:bg-[#19395f] hover:text-white' }}">

                    @if ($icon === 'home')

                        <svg class="w-5 h-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z"/>
                        </svg>

                    @elseif ($icon === 'file-plus')

                        <svg class="w-5 h-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9zM13 2v7h7M12 12v6m-3-3h6"/>
                        </svg>

                    @elseif ($icon === 'history')

                        <svg class="w-5 h-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12a9 9 0 1 0 2.64-6.36L3 8M3 3v5h5m4-1v5l3 2"/>
                        </svg>

                    @else

                        <svg class="w-5 h-5 shrink-0"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">

                            <circle cx="12" cy="8" r="4"/>

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 21a8 8 0 0 1 16 0"/>
                        </svg>

                    @endif

                    <span>{{ $label }}</span>

                </a>

            @endforeach

        </nav>
    </div>

    <!-- LOGOUT -->
    <div class="p-4 border-t border-white/10">

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button
                type="submit"
                class="w-full flex items-center gap-3 text-left px-4 py-3
                       rounded-xl bg-red-500/10 text-red-200
                       hover:bg-red-600 hover:text-white
                       transition-all duration-200 font-semibold text-sm">

                <svg class="w-5 h-5"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>

                Logout
            </button>
        </form>

    </div>

</aside>

<!-- AREA KONTEN -->
<div id="content-wrapper">

    <!-- HEADER -->
    <header class="arsiva-header px-4 md:px-8 flex justify-between items-center sticky top-0 z-10">

        <div class="flex items-center gap-3">

            <!-- TOMBOL MENU MOBILE -->
            <button
                type="button"
                @click="open = !open"
                class="md:hidden bg-blue-600 text-white w-10 h-10
                       rounded-xl text-xl font-bold transition
                       hover:bg-blue-700"
                aria-label="Buka menu">

                &#9776;
            </button>

            <h1 class="text-lg font-bold text-white">
                @yield('page_title', 'Dashboard')
            </h1>

        </div>

        <span class="text-sm text-blue-100 hidden sm:block">
            Halo, {{ auth()->user()->name }}
        </span>

    </header>

    <!-- KONTEN HALAMAN -->
    <main class="flex-1 p-4 md:p-8">

        @if (session('success'))
            <div class="mb-6 bg-green-50 border border-green-200
                        text-green-700 text-sm p-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')

    </main>

    <!-- FOOTER -->
    <footer class="arsiva-footer">

        <div class="px-8 md:px-10 py-8 md:py-9">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10 items-start">

                <!-- IDENTITAS ARSIVA -->
                <div>

                    <div class="flex items-center gap-3 mb-3">

                        <img
                            src="{{ asset('images/logo-arsiva.png') }}"
                            alt="Logo Arsiva"
                            class="logo-arsiva">

                        <h3 class="text-xl font-bold">
                            Arsiva
                        </h3>

                    </div>

                    <p class="footer-muted text-sm leading-relaxed max-w-sm">
                        Sistem Layanan Administrasi & Pengajuan
                        Dokumen Akademik Online.
                    </p>

                    <p class="footer-muted text-sm mt-3">
                        SMK Negeri 5 Surakarta
                    </p>

                    <!-- BANTUAN -->
                    <div class="mt-6">

                        <h4 class="font-bold text-base mb-3">
                            Bantuan & Laporan
                        </h4>

                        <p class="footer-muted text-sm mb-2">
                            Mengalami kendala atau menemukan kesalahan?
                            Silakan hubungi developer Arsiva.
                        </p>

                        <div class="text-sm footer-muted space-y-2">
                            <p>
                                <span class="font-semibold">
                                    Email Developer:
                                </span>

                                <a
                                    href="mailto:akaskus9@gmail.com"
                                    class="hover:underline">
                                    akaskus9@gmail.com
                                </a>
                            </p>
                        </div>

                    </div>

                </div>

                <!-- INFORMASI SEKOLAH -->
                <div class="text-left md:text-right">

                    <h4 class="font-bold text-lg mb-4">
                        Informasi
                    </h4>

                    <div class="text-sm footer-muted space-y-3">

                        <p>Pelayanan Dokumen Akademik</p>
                        <p>Senin - Jumat, 07.30 - 15.00 WIB</p>
                        <p>(0271) 713916</p>
                        <p>lapor@smkn5surakarta.sch.id</p>

                    </div>

                </div>

            </div>

            <!-- COPYRIGHT -->
            <div class="border-t border-white/20 mt-8 pt-5
                        flex flex-col sm:flex-row justify-between
                        items-start sm:items-center gap-3">

                <p class="text-xs footer-muted">
                    &copy; {{ date('Y') }} Arsiva. Hak cipta dilindungi undang-undang.
                </p>

                <p class="text-xs footer-muted text-right">
                    SMK Negeri 5 Surakarta
                </p>

            </div>

        </div>

    </footer>

</div>

<!-- ALPINE JS -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
