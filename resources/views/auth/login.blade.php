
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - Arsiva</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --biru: #2563eb;
            --biru-tua: #0b1f3a;
            --biru-muda: #dbeafe;
            --putih: #ffffff;
            --teks: #f8fafc;
            --abu: #cbd5e1;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            min-height: 100vh;
        }

        .layar {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        /* ===== BAGIAN KIRI (TETAP PUTIH) ===== */
        .kiri {
            background: #ffffff;
            color: #0f172a;
            padding: 56px 64px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .logo-kotak {
            width: 48px;
            height: 48px;
            min-width: 48px;
            border-radius: 12px;
            background: var(--biru);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo-kotak svg {
            width: 42px;
            height: 42px;
            display: block;
        }

        .sambutan h1 {
            color: #0f172a;
            font-size: 2.6rem;
            font-weight: 800;
            line-height: 1.2;
            max-width: 500px;
        }

        .sambutan p {
            margin-top: 20px;
            color: #475569;
            line-height: 1.7;
            max-width: 46ch;
        }

        .poin {
            margin-top: 24px;
            padding-left: 18px;
        }

        .poin li {
            color: #334155;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .kaki {
            color: #64748b;
            font-size: .85rem;
        }

        /* ===== BAGIAN KANAN (BIRU TUA) ===== */
        .kanan {
            background: #0b1f3a;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 32px;
        }

        .kotak {
            width: 100%;
            max-width: 400px;
            color: #ffffff;
        }

        .tab {
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: #132d4e;
            padding: 5px;
            border-radius: 12px;
        }

        .tab button {
            border: 0;
            background: transparent;
            color: #bfdbfe;
            font: inherit;
            font-weight: 600;
            padding: 11px;
            border-radius: 8px;
            cursor: pointer;
        }

        .tab button.aktif {
            background: #ffffff;
            color: #0b1f3a;
        }

        .tab button:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 2px;
        }

        .panel {
            display: none;
            margin-top: 32px;
        }

        .panel.aktif {
            display: block;
        }

        .panel h2 {
            font-size: 1.6rem;
            font-weight: 800;
        }

        .panel .sub {
            margin-top: 6px;
            color: #bfdbfe;
            font-size: .95rem;
        }

        .field {
            margin-top: 18px;
        }

        .field label {
            display: block;
            font-size: .85rem;
            font-weight: 600;
            margin-bottom: 7px;
        }

        /* INPUT: TULISAN BERWARNA GELAP */
        .field input,
        .field select {
            width: 100%;
            padding: 13px 14px;
            border-radius: 10px;
            border: 2px solid transparent;
            background: #ffffff;
            color: #0f172a;
            font: inherit;
            font-size: .95rem;
        }

        .field input::placeholder {
            color: #94a3b8;
        }

        .field input:focus,
        .field select:focus {
            outline: none;
            border-color: #60a5fa;
        }

        .error {
            margin-top: 18px;
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: .88rem;
        }

        .error ul {
            padding-left: 18px;
        }

        .ingat {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
            font-size: .88rem;
        }

        .btn {
            width: 100%;
            margin-top: 24px;
            padding: 14px;
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            background: #ffffff;
            color: #2563eb;
            font: inherit;
            font-weight: 700;
            font-size: 1rem;
        }

        .btn:hover {
            background: #dbeafe;
        }

        .btn:focus-visible {
            outline: 2px solid #ffffff;
            outline-offset: 3px;
        }

        .pw-wrap {
            position: relative;
        }

        .pw-wrap input {
            padding-right: 76px;
        }

        .pw-toggle {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #2563eb;
            font: inherit;
            font-weight: 600;
            font-size: .8rem;
            padding: 6px 8px;
            border-radius: 6px;
            cursor: pointer;
        }

        .pw-toggle:hover {
            background: #dbeafe;
        }

        .sukses {
            margin-top: 18px;
            background: #dcfce7;
            color: #166534;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: .88rem;
        }

        @media (max-width: 860px) {
            .layar {
                grid-template-columns: 1fr;
            }

            .kiri {
                padding: 32px 24px;
                gap: 28px;
            }

            .kanan {
                padding: 40px 24px 56px;
            }

            .sambutan h1 {
                font-size: 2rem;
            }
        }

        @media (prefers-reduced-motion: no-preference) {
            .panel.aktif {
                animation: muncul .25s ease;
            }

            @keyframes muncul {
                from {
                    opacity: 0;
                    transform: translateY(6px);
                }
                to {
                    opacity: 1;
                    transform: none;
                }
            }
        }
    </style>
</head>

<body>
<div class="layar" data-tab-awal="{{ old('login_type', session('tab', $tab ?? 'siswa')) }}">

    <!-- BAGIAN KIRI -->
    <section class="kiri">

        <div class="logo">
            <span class="logo-kotak">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                    <path d="M32 8 L12 54 H23 L32 31 L41 54 H52 L32 8Z"
                          fill="white"/>
                    <ellipse cx="32" cy="34"
                             rx="27" ry="11"
                             transform="rotate(-22 32 34)"
                             fill="none"
                             stroke="#7dd3fc"
                             stroke-width="4"/>
                </svg>
            </span>
            <span>Arsiva</span>
        </div>

        <div class="sambutan">
            <h1>Layanan dokumen akademik yang mudah dan tertata.</h1>

            <p>
                Ajukan kebutuhan dokumen akademik secara online,
                pantau prosesnya, lalu ambil dokumen yang sudah selesai
                langsung di sekolah.
            </p>

            <ul class="poin">
                <li>Ajukan dokumen dari rumah, cukup upload berkas pendukung</li>
                <li>Pantau status pengajuan: Pending, Diproses, atau Selesai</li>
                <li>Dokumen selesai diambil langsung melalui Tata Usaha sekolah</li>
            </ul>
        </div>

        <p class="kaki">
            &copy; {{ date('Y') }} Arsiva.
            Sistem Manajemen Dokumen Akademik Siswa.
        </p>

    </section>

    <!-- BAGIAN KANAN -->
    <section class="kanan">
        <div class="kotak">

            <div class="tab" role="tablist">
                <button type="button" id="tab-siswa"
                        role="tab" class="aktif"
                        data-target="siswa">
                    Login Siswa
                </button>

                <button type="button" id="tab-admin"
                        role="tab" data-target="admin">
                    Login Admin
                </button>
            </div>

            <!-- LOGIN SISWA -->
            <form id="siswa" class="panel aktif"
                  method="POST" action="{{ route('login.post') }}">
                @csrf

                <input type="hidden" name="login_type" value="siswa">

                <h2>Masuk sebagai siswa</h2>

                <p class="sub">
                    Masukkan NISN dan password yang diberikan oleh admin
                </p>

                @if (old('login_type', session('tab', 'siswa')) === 'siswa' && $errors->any())
                    <div class="error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="field">
                    <label for="login-nisn">NISN</label>
                    <input type="text"
                           id="login-nisn"
                           name="nisn"
                           value="{{ old('nisn') }}"
                           inputmode="numeric"
                           maxlength="10"
                           pattern="[0-9]{8,10}"
                           placeholder="Masukkan NISN"
                           required
                           autocomplete="username">
                </div>

                <div class="field">
                    <label for="login-password">Password</label>
                    <input type="password"
                           id="login-password"
                           name="password"
                           placeholder="Masukkan password dari admin"
                           required
                           autocomplete="current-password">
                </div>

                <label class="ingat">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button type="submit" class="btn">
                    Masuk
                </button>
            </form>

            <!-- LOGIN ADMIN -->
            <form id="admin" class="panel"
                  method="POST" action="{{ route('login.post') }}">
                @csrf

                <input type="hidden" name="login_type" value="admin">

                <h2>Masuk sebagai admin</h2>

                <p class="sub">
                    Admin Tata Usaha tetap menggunakan email dan kata sandi.
                </p>

                @if (old('login_type', session('tab')) === 'admin' && $errors->any())
                    <div class="error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="field">
                    <label for="admin-email">Email admin</label>
                    <input type="email"
                           id="admin-email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Email admin"
                           required
                           autocomplete="username">
                </div>

                <div class="field">
                    <label for="admin-password">Kata sandi</label>
                    <input type="password"
                           id="admin-password"
                           name="password"
                           placeholder="Kata sandi"
                           required
                           autocomplete="current-password">
                </div>

                <label class="ingat">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button type="submit" class="btn">
                    Masuk Admin
                </button>
            </form>

        </div>
    </section>

</div>

<script>
    const tombol = document.querySelectorAll('.tab button');
    const panel = document.querySelectorAll('.panel');

    function tampil(nama) {
        tombol.forEach(b => {
            b.classList.toggle('aktif', b.dataset.target === nama);
        });

        panel.forEach(p => {
            p.classList.toggle('aktif', p.id === nama);
        });
    }

    tombol.forEach(b => {
        b.addEventListener('click', () => tampil(b.dataset.target));
    });

    const tabAwal = document.querySelector('.layar').dataset.tabAwal || 'siswa';
tampil(tabAwal);

    // Tombol lihat/sembunyikan password
    document.querySelectorAll('input[type="password"]').forEach(input => {
        const wrap = document.createElement('div');
        wrap.className = 'pw-wrap';

        input.parentNode.insertBefore(wrap, input);
        wrap.appendChild(input);

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'pw-toggle';
        btn.textContent = 'Lihat';
        btn.setAttribute('aria-label', 'Tampilkan kata sandi');

        btn.addEventListener('click', () => {
            const tampilPassword = input.type === 'password';

            input.type = tampilPassword ? 'text' : 'password';
            btn.textContent = tampilPassword ? 'Tutup' : 'Lihat';
        });

        wrap.appendChild(btn);
    });
</script>

</body>
</html>
