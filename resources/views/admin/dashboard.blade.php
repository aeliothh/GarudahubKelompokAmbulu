
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Garuda Hub</title>

    <style nonce="{{ $cspNonce }}">
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f3f4f6;
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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .admin-label {
            font-size: 13px;
            color: #dbeafe;
        }

        .logout-btn {
            background: white;
            color: #172554;
            padding: 9px 15px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }

        .container {
            max-width: 1150px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .welcome {
            margin-bottom: 30px;
        }

        .welcome h1 {
            color: #172554;
            font-size: 27px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #6b7280;
            font-size: 14px;
        }

        .section-title {
            color: #172554;
            font-size: 18px;
            margin-bottom: 17px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .menu-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .menu-card h3 {
            color: #172554;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .menu-card p {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #172554;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
        }

        .btn:hover {
            background: #1e40af;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .stat-card h3 {
            color: #6b7280;
            font-size: 13px;
            font-weight: normal;
            margin-bottom: 13px;
        }

        .stat-card p {
            color: #172554;
            font-size: 28px;
            font-weight: bold;
        }

        .stat-card span {
            display: block;
            color: #9ca3af;
            font-size: 12px;
            margin-top: 8px;
        }

        .secondary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .secondary-card {
            background: white;
            padding: 18px;
            border-radius: 9px;
            border: 1px solid #e5e7eb;
        }

        .secondary-card p {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .secondary-card strong {
            color: #172554;
            font-size: 20px;
        }

        .table-card {
            background: white;
            padding: 23px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .table-card h2 {
            color: #172554;
            font-size: 18px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        th {
            color: #6b7280;
            background: #f9fafb;
            font-weight: bold;
        }

        td {
            color: #374151;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
            background: #dcfce7;
            color: #166534;
        }

        .status.closed {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty {
            text-align: center;
            color: #9ca3af;
            padding: 25px;
            font-size: 13px;
        }

        .footer {
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            padding: 25px 0;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .navbar-right {
                gap: 10px;
            }

            .admin-label {
                display: none;
            }

            .container {
                margin-top: 28px;
            }

            .welcome h1 {
                font-size: 23px;
            }

            .table-card {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>Garuda Hub</h2>

        <div class="navbar-right">
            <span class="admin-label">Administrator</span>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <main class="container">

        <section class="welcome">
            <h1>Dashboard Administrator</h1>

            <p>
                Halo, {{ auth()->user()->nama }}.
                Pantau aktivitas dan pengelolaan Garuda Hub melalui dashboard ini.
            </p>
        </section>

        <h2 class="section-title">Menu Pengelolaan</h2>

        <section class="menu-grid">

            <div class="menu-card">
                <h3>Manajemen Pengguna</h3>

                <p>
                    Lihat seluruh akun yang terdaftar, cari pengguna,
                    dan filter berdasarkan role.
                </p>

                <a href="{{ route('admin.users') }}" class="btn">
                    Kelola Pengguna
                </a>
            </div>

            <div class="menu-card">
                <h3>Manajemen Proyek</h3>

                <p>
                    Pantau seluruh proyek, cari proyek berdasarkan
                    judul, kategori, dan status.
                </p>

                <a href="{{ route('admin.projects') }}" class="btn">
                    Kelola Proyek
                </a>
            </div>

            <div class="menu-card">
                <h3>Manajemen Bid</h3>

                <p>
                    Lihat seluruh penawaran developer, cari berdasarkan
                    proyek atau developer, dan pantau status pemenang.
                </p>

                <a href="{{ route('admin.bids') }}" class="btn">
                    Kelola Bid
                </a>
            </div>

        </section>

        <h2 class="section-title">Ringkasan Sistem</h2>

        <section class="stats-grid">

            <div class="stat-card">
                <h3>Total Pengguna</h3>
                <p>{{ number_format($stats['totalUsers']) }}</p>
                <span>Seluruh akun terdaftar</span>
            </div>

            <div class="stat-card">
                <h3>Total Proyek</h3>
                <p>{{ number_format($stats['totalProjects']) }}</p>
                <span>Seluruh proyek dalam sistem</span>
            </div>

            <div class="stat-card">
                <h3>Total Penawaran</h3>
                <p>{{ number_format($stats['totalBids']) }}</p>
                <span>Seluruh penawaran developer</span>
            </div>

            <div class="stat-card">
                <h3>Proyek Berpemenang</h3>
                <p>{{ number_format($stats['completedProjects']) }}</p>
                <span>Proyek yang sudah memiliki pemenang</span>
            </div>

        </section>

        <h2 class="section-title">Detail Aktivitas</h2>

        <section class="secondary-grid">

            <div class="secondary-card">
                <p>Total Klien</p>
                <strong>{{ $stats['totalClients'] }}</strong>
            </div>

            <div class="secondary-card">
                <p>Total Developer</p>
                <strong>{{ $stats['totalDevelopers'] }}</strong>
            </div>

            <div class="secondary-card">
                <p>Proyek Terbuka</p>
                <strong>{{ $stats['openProjects'] }}</strong>
            </div>

            <div class="secondary-card">
                <p>Proyek Ditutup</p>
                <strong>{{ $stats['closedProjects'] }}</strong>
            </div>

        </section>

        <section class="table-card">

            <h2>Proyek Terbaru</h2>

            @if ($latestProjects->count() > 0)

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Judul Proyek</th>
                                <th>Klien</th>
                                <th>Kategori</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($latestProjects as $project)
                                <tr>
                                    <td>{{ $project->judul }}</td>
                                    <td>{{ $project->client->nama }}</td>
                                    <td>{{ $project->kategori }}</td>
                                    <td>
                                        <span class="status {{ $project->status === 'ditutup' ? 'closed' : '' }}">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty">
                    Belum ada proyek.
                </div>

            @endif

        </section>

        <section class="table-card">

            <h2>Penawaran Terbaru</h2>

            @if ($latestBids->count() > 0)

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Proyek</th>
                                <th>Developer</th>
                                <th>Harga</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($latestBids as $bid)
                                <tr>
                                    <td>{{ $bid->project->judul }}</td>
                                    <td>{{ $bid->developer->nama }}</td>
                                    <td>
                                        Rp{{ number_format($bid->harga, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $bid->durasi }} hari</td>
                                    <td>
                                        @if ($bid->is_winner)
                                            <span class="status">
                                                Pemenang
                                            </span>
                                        @else
                                            <span class="status">
                                                Penawaran
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else

                <div class="empty">
                    Belum ada penawaran.
                </div>

            @endif

        </section>

        <footer class="footer">
            Garuda Hub &copy; {{ date('Y') }}. Admin Dashboard.
        </footer>

    </main>

</body>
</html>
