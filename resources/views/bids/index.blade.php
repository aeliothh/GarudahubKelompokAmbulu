
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penawaran Saya - Garuda Hub</title>

    <style>
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
            margin-bottom: 25px;
        }

        .header h1 {
            color: #172554;
            font-size: 27px;
            margin-bottom: 8px;
        }

        .header p {
            color: #6b7280;
            font-size: 14px;
        }

        .bid-card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 18px;
        }

        .bid-header {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 18px;
        }

        .bid-header h3 {
            color: #172554;
            font-size: 18px;
            margin-bottom: 7px;
        }

        .category {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 12px;
        }

        .bid-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 15px;
            margin-bottom: 18px;
        }

        .info-item {
            background: #f9fafb;
            padding: 14px;
            border-radius: 7px;
        }

        .info-item span {
            display: block;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 7px;
        }

        .info-item strong {
            color: #172554;
            font-size: 15px;
        }

        .proposal {
            border-top: 1px solid #e5e7eb;
            padding-top: 16px;
            margin-bottom: 18px;
        }

        .proposal h4 {
            color: #172554;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .proposal p {
            font-size: 13px;
            line-height: 1.7;
            color: #6b7280;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: bold;
        }

        .status.winner {
            background: #dcfce7;
            color: #166534;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            background: #172554;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: bold;
        }

        .btn:hover {
            background: #1e40af;
        }

        .empty {
            background: white;
            padding: 50px 20px;
            border-radius: 10px;
            text-align: center;
            color: #6b7280;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 13px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .bid-header {
                flex-direction: column;
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
            <h1>Penawaran Saya</h1>
            <p>
                Lihat seluruh penawaran proyek yang pernah kamu ajukan.
            </p>
        </div>

        @if ($bids->count() > 0)

            @foreach ($bids as $bid)

                <div class="bid-card">

                    <div class="bid-header">
                        <div>
                            <h3>{{ $bid->project->judul }}</h3>

                            <span class="category">
                                {{ $bid->project->kategori }}
                            </span>
                        </div>

                        @if ($bid->is_winner)
                            <span class="status winner">
                                Terpilih sebagai Pemenang
                            </span>
                        @else
                            <span class="status">
                                {{ ucfirst($bid->project->status) }}
                            </span>
                        @endif
                    </div>

                    <div class="bid-info">

                        <div class="info-item">
                            <span>Harga Penawaran</span>
                            <strong>
                                Rp{{ number_format($bid->harga, 0, ',', '.') }}
                            </strong>
                        </div>

                        <div class="info-item">
                            <span>Durasi Pengerjaan</span>
                            <strong>{{ $bid->durasi }} Hari</strong>
                        </div>

                        <div class="info-item">
                            <span>Tanggal Penawaran</span>
                            <strong>
                                {{ $bid->created_at->format('d M Y') }}
                            </strong>
                        </div>

                    </div>

                    <div class="proposal">
                        <h4>Proposal Saya</h4>
                        <p>{{ $bid->proposal }}</p>
                    </div>

                    <a
                        href="{{ route('projects.show', $bid->project) }}"
                        class="btn"
                    >
                        Lihat Proyek
                    </a>

                </div>

            @endforeach

            <div class="pagination">
                {{ $bids->links() }}
            </div>

        @else

            <div class="empty">
                <h3>Belum Ada Penawaran</h3>
                <p style="margin-top: 10px;">
                    Kamu belum pernah mengajukan penawaran proyek.
                </p>
            </div>

        @endif

    </main>

</body>
</html>
