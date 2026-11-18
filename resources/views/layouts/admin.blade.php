
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Panel - Sistem Manajemen Dokumen Akademik</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body,
        button,
        input,
        select,
        textarea {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
        }

        button,
        input[type=submit] {
            font-weight: 600;
            letter-spacing: .01em;
        }

       /* SIDEBAR ADMIN */
.admin-sidebar {
    background-color: #0b1f3a !important;
    color: #ffffff !important;
}

/* Animasi menu sidebar */
.admin-sidebar nav a {
    color: #dbeafe;
    transition: all .2s ease-in-out;
    transform: scale(1);
    transform-origin: center;
}

/* Saat kursor diarahkan ke menu */
.admin-sidebar nav a:hover {
    background-color: #19395f !important;
    color: #ffffff !important;
    transform: scale(1.04);
}

/* Saat menu diklik */
.admin-sidebar nav a:active {
    transform: scale(.98);
}

.admin-sidebar a.menu-aktif {
    background-color: #2563eb !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
}

        .admin-sidebar a.menu-aktif {
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
        }

        .admin-sidebar .judul-sidebar {
            color: #ffffff;
            border-color: rgba(255, 255, 255, .12);
        }

        .admin-sidebar .logout-area {
            border-color: rgba(255, 255, 255, .12);
        }

        .admin-sidebar .btn-logout {
            color: #fecaca !important;
            background-color: rgba(239, 68, 68, .12);
        }

        .admin-sidebar .btn-logout:hover {
            color: #ffffff !important;
            background-color: #dc2626 !important;
        }

        /* AREA KONTEN */
        .admin-main {
            background-color: #f3f4f6;
        }

        /* RESPONSIVE */
        @media (max-width: 767px) {
            .admin-sidebar {
                box-shadow: 5px 0 20px rgba(0, 0, 0, .2);
            }
        }
    </style>
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden" x-data="{ open: false }">

        <!-- BACKDROP MOBILE -->
        <div
            x-show="open"
            x-transition.opacity
            @click="open = false"
            class="fixed inset-0 z-20 bg-black bg-opacity-50 md:hidden">
        </div>

        <!-- SIDEBAR ADMIN -->
        <aside
            :class="open ? 'translate-x-0' : '-translate-x-full'"
            class="admin-sidebar fixed inset-y-0 left-0 z-30 w-64 flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto shadow-lg">

            <!-- JUDUL SIDEBAR -->
            <div class="judul-sidebar p-5 text-xl font-bold border-b flex items-center justify-between">

                <span>Admin Panel</span>

                <button
                    type="button"
                    @click="open = false"
                    class="md:hidden text-blue-200 hover:text-white">

                    <svg class="w-6 h-6"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- MENU SIDEBAR -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">

                <!-- DASHBOARD -->
                <a
                    href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-xl transition
                    {{ request()->routeIs('admin.dashboard') ? 'menu-aktif font-semibold' : '' }}">

                    <svg
                        class="w-5 h-5 flex-shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V10Z">
                        </path>
                    </svg>

                    <span>Dashboard</span>
                </a>

                <!-- KELOLA DATA SISWA -->
                <a
                    href="{{ route('admin.siswa.index') }}"
                    class="flex items-center gap-3 py-3 px-4 rounded-xl transition
                    {{ request()->routeIs('admin.siswa.*') ? 'menu-aktif font-semibold' : '' }}">

                    <svg
                        class="w-5 h-5 flex-shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">

                        <circle cx="9" cy="8" r="4"></circle>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2 21a7 7 0 0 1 14 0m2-13h4m-2-2v4">
                        </path>
                    </svg>

                    <span>Kelola Data Siswa</span>
                </a>

            </nav>

            <!-- LOGOUT -->
            <div class="logout-area p-4 border-t">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button
                        type="submit"
                        class="btn-logout w-full text-left py-2.5 px-4 rounded-lg transition flex items-center gap-3 font-semibold text-sm">

                        <svg
                            class="w-5 h-5 flex-shrink-0"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6">
                            </path>
                        </svg>

                        Logout
                    </button>
                </form>

            </div>

        </aside>

        <!-- AREA KONTEN UTAMA -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- NAVBAR ATAS -->
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">

                <div class="flex items-center">

                    <!-- TOMBOL MENU MOBILE -->
                    <button
                        type="button"
                        @click="open = !open"
                        class="text-gray-600 focus:outline-none md:hidden mr-4">

                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </button>

                    <h1 class="text-lg font-semibold text-gray-700">
                        Panel Admin
                    </h1>

                </div>

            </header>

            <!-- KONTEN HALAMAN -->
            <main class="admin-main flex-1 overflow-x-hidden overflow-y-auto p-6">

                @yield('content')

            </main>

        </div>

    </div>

    <!-- ALPINE JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>
