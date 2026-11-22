
<!DOCTYPE html>
<html lang="id">
    <link rel="stylesheet" href="{{ asset('css/security-fixes.css') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proyek - Garuda Hub</title>

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

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            color: #172554;
            font-size: 27px;
            margin-bottom: 7px;
        }

        .header p {
            color: #6b7280;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            background: #172554;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn:hover {
            background: #1e40af;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .project-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .category {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 12px;
            margin-bottom: 13px;
        }

        .project-card h3 {
            color: #172554;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .description {
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .project-info {
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .info-label {
            color: #6b7280;
        }

        .info-value {
            font-weight: bold;
            text-align: right;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
            background: #dcfce7;
            color: #166534;
        }

        .status.closed {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-detail {
            display: block;
            width: 100%;
            padding: 11px;
            margin-top: 18px;
            background: #172554;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-detail:hover {
            background: #1e40af;
        }

        .empty {
            background: white;
            padding: 50px 20px;
            text-align: center;
            border-radius: 10px;
            color: #6b7280;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <h2>Garuda Hub</h2>
        <a href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
    </nav>

    <main class="container">

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="header">
            <div>
                <h1>
                    {{ auth()->user()->role === 'klien' ? 'Proyek Saya' : 'Proyek Tersedia' }}
                </h1>

                <p>
                    {{ auth()->user()->role === 'klien'
                        ? 'Kelola dan pantau proyek yang telah kamu pasang.'
                        : 'Temukan proyek yang sesuai dengan keahlianmu.' }}
                </p>
            </div>

            @if (auth()->user()->role === 'klien')
                <a href="{{ route('projects.create') }}" class="btn">
                    + Tambah Proyek
                </a>
            @endif
        </div>

        @if ($projects->count() > 0)

            <div class="project-grid">

                @foreach ($projects as $project)

                    <div class="project-card">

                        <span class="category">
                            {{ $project->kategori }}
                        </span>

                        <h3>{{ $project->judul }}</h3>

                        <p class="description">
                            {{ \Illuminate\Support\Str::limit($project->deskripsi, 120) }}
                        </p>

                        <div class="project-info">

                            @if (auth()->user()->role === 'developer')
                                <div class="info-row">
                                    <span class="info-label">Klien</span>
                                    <span class="info-value">
                                        {{ $project->client->nama }}
                                    </span>
                                </div>
                            @endif

                            <div class="info-row">
                                <span class="info-label">Budget</span>
                                <span class="info-value">
                                    Rp{{ number_format($project->budget_min, 0, ',', '.') }}
                                    -
                                    Rp{{ number_format($project->budget_max, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Batas Lelang</span>
                                <span class="info-value">
                                    {{ $project->batas_lelang->format('d M Y') }}
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Jumlah Penawaran</span>
                                <span class="info-value">
                                    {{ $project->bids_count }} penawaran
                                </span>
                            </div>

                            <div class="info-row">
                                <span class="info-label">Status</span>

                                <span class="status {{ $project->status === 'ditutup' ? 'closed' : '' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>

                        </div>

                        <!-- Tombol untuk membuka detail proyek -->
                        <a
                            href="{{ route('projects.show', $project) }}"
                            class="btn-detail"
                        >
                            Lihat Detail
                        </a>

                    </div>

                @endforeach

            </div>

            <div class="pagination">
                {{ $projects->links() }}
            </div>

        @else

            <div class="empty">
                <h3>Belum Ada Proyek</h3>
                <p class="csp-mt-8">
                    Belum ada proyek yang dapat ditampilkan.
                </p>
            </div>

        @endif

    </main>

</body>
</html>
