
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Garuda Hub</title>

    <style nonce="{{ $cspNonce }}">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
            min-height: 100vh;
            color: #1f2937;
        }

        .navbar {
            background: #172554;
            color: white;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 21px;
        }

        .logout-btn {
            background: white;
            color: #172554;
            padding: 9px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .container {
            max-width: 1100px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            color: #172554;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #6b7280;
            font-size: 14px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .section-title {
            color: #172554;
            font-size: 19px;
            margin-bottom: 17px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .menu-card h3 {
            color: #172554;
            margin-bottom: 10px;
            font-size: 17px;
        }

        .menu-card p {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 11px 16px;
            background: #172554;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn:hover {
            background: #1e40af;
        }

        .account-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-top: 25px;
            border: 1px solid #e5e7eb;
        }

        .account-card h3 {
            color: #172554;
            margin-bottom: 18px;
        }

        .account-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .account-row:last-child {
            border-bottom: none;
        }

        .account-label {
            color: #6b7280;
        }

        .account-value {
            color: #172554;
            font-weight: bold;
        }

        .role-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .container {
                margin-top: 30px;
            }

            .welcome h1 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>Garuda Hub</h2>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                Logout
            </button>
        </form>
    </nav>

    <main class="container">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <section class="welcome">
            <h1>
                Selamat Datang, {{ auth()->user()->nama }}!
            </h1>

            <p>
                Selamat datang di dashboard Garuda Hub.
                Kelola aktivitasmu melalui menu yang tersedia.
            </p>
        </section>

        <h2 class="section-title">Menu Utama</h2>

        <section class="menu-grid">

            {{-- Menu khusus klien --}}
            @if (auth()->user()->role === 'klien')

                <div class="menu-card">
                    <h3>Kelola Proyek</h3>

                    <p>
                        Lihat dan pantau seluruh proyek yang telah kamu pasang.
                    </p>

                    <a href="{{ route('projects.index') }}" class="btn">
                        Lihat Proyek
                    </a>
                </div>

                <div class="menu-card">
                    <h3>Pasang Proyek Baru</h3>

                    <p>
                        Publikasikan proyek baru agar developer dapat mengajukan penawaran.
                    </p>

                    <a href="{{ route('projects.create') }}" class="btn">
                        Tambah Proyek
                    </a>
                </div>

            @endif

            {{-- Menu khusus developer --}}
            @if (auth()->user()->role === 'developer')

                <div class="menu-card">
                    <h3>Cari Proyek</h3>

                    <p>
                        Jelajahi proyek yang tersedia dan temukan pekerjaan yang sesuai dengan kemampuanmu.
                    </p>

                    <a href="{{ route('projects.index') }}" class="btn">
                        Jelajahi Proyek
                    </a>
                </div>

                <div class="menu-card">
                    <h3>Penawaran Saya</h3>

                    <p>
                        Lihat daftar penawaran yang pernah kamu ajukan kepada klien.
                    </p>

                    <a href="{{ route('bids.index') }}" class="btn">
                        Lihat Penawaran
                    </a>
                </div>

            @endif

            {{-- Menu khusus admin --}}
            @if (auth()->user()->role === 'admin')

                <div class="menu-card">
                    <h3>Panel Admin</h3>

                    <p>
                        Kelola pengguna, pantau seluruh proyek, dan lihat aktivitas penawaran Garuda Hub.
                    </p>

                    <a href="{{ route('admin.dashboard') }}" class="btn">
                        Buka Panel Admin
                    </a>
                </div>

            @endif

        </section>

        <section class="account-card">

            <h3>Informasi Akun</h3>

            <div class="account-row">
                <span class="account-label">Nama Pengguna</span>

                <span class="account-value">
                    {{ auth()->user()->nama }}
                </span>
            </div>

            <div class="account-row">
                <span class="account-label">Email</span>

                <span class="account-value">
                    {{ auth()->user()->email }}
                </span>
            </div>

            <div class="account-row">
                <span class="account-label">Role</span>

                <span class="role-badge">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
            </div>

        </section>

    </main>

</body>
</html>
