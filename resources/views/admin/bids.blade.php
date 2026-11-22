<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bid - Garuda Hub</title>
    <style nonce="{{ $cspNonce }}">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6fa;
            color: #1e293b;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        h1 {
            font-size: 26px;
            color: #14213d;
            margin-bottom: 6px;
        }

        .subtitle {
            color: #64748b;
            font-size: 14px;
        }

        .back-link {
            text-decoration: none;
            color: #fff;
            background: #14213d;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .card {
            background: #fff;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input, select {
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
        }

        input {
            flex: 1;
        }

        button {
            background: #14213d;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover, .back-link:hover {
            background: #253b63;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            min-width: 900px;
        }

        th, td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
            color: #475569;
            font-weight: 600;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .winner {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #f1f5f9;
            color: #475569;
        }

        .proposal {
            max-width: 250px;
            line-height: 1.5;
            color: #64748b;
        }

        .pagination {
            margin-top: 20px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        .total {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 15px;
        }

        @media (max-width: 700px) {
            body {
                padding: 15px;
            }

            .header {
                align-items: flex-start;
                gap: 15px;
                flex-direction: column;
            }

            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">

        <div class="header">
            <div>
                <h1>Manajemen Bid</h1>
                <p class="subtitle">Kelola dan pantau seluruh penawaran proyek di Garuda Hub.</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="back-link">
                Kembali ke Dashboard
            </a>
        </div>

        <div class="card">

            <form action="{{ route('admin.bids') }}" method="GET" class="filters">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari nama proyek atau developer..."
                    value="{{ request('search') }}"
                >

                <select name="result">
                    <option value="">Semua Hasil</option>
                    <option value="winner" {{ request('result') === 'winner' ? 'selected' : '' }}>
                        Pemenang
                    </option>
                    <option value="pending" {{ request('result') === 'pending' ? 'selected' : '' }}>
                        Belum Terpilih
                    </option>
                </select>

                <button type="submit">Cari</button>
            </form>

            <p class="total">
                Menampilkan {{ $bids->count() }} dari {{ $bids->total() }} penawaran
            </p>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Proyek</th>
                            <th>Developer</th>
                            <th>Harga Penawaran</th>
                            <th>Durasi</th>
                            <th>Proposal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bids as $bid)
                            <tr>
                                <td>{{ $bids->firstItem() + $loop->index }}</td>

                                <td>
                                    {{ $bid->project->judul ?? '-' }}
                                </td>

                                <td>
                                    {{ $bid->developer->nama ?? '-' }}
                                </td>

                                <td>
                                    Rp{{ number_format($bid->harga, 0, ',', '.') }}
                                </td>

                                <td>
                                    {{ $bid->durasi }} hari
                                </td>

                                <td class="proposal">
                                    {{ \Illuminate\Support\Str::limit($bid->proposal, 90) }}
                                </td>

                                <td>
                                    {{ $bid->created_at->format('d M Y') }}
                                </td>

                                <td>
                                    @if ($bid->is_winner)
                                        <span class="badge winner">Pemenang</span>
                                    @else
                                        <span class="badge pending">Belum Terpilih</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    Belum ada penawaran yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $bids->withQueryString()->links() }}
            </div>

        </div>
    </div>
</body>
</html>
