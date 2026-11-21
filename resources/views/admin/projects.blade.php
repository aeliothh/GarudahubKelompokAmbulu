<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Proyek - Garuda Hub</title>

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
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #172554;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
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

        .filter-card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            margin-bottom: 22px;
        }

        .filter-form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        input, select {
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
            background: white;
        }

        input:focus, select:focus {
            border-color: #2563eb;
        }

        .search-input {
            flex: 1;
            min-width: 200px;
        }

        .btn {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            background: #172554;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #1e40af;
        }

        .btn-reset {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-reset:hover {
            background: #d1d5db;
        }

        .table-card {
            background: white;
            padding: 23px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .table-header h2 {
            color: #172554;
            font-size: 18px;
        }

        .total {
            color: #6b7280;
            font-size: 13px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 850px;
        }

        th, td {
            padding: 15px 12px;
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

        .project-name {
            color: #172554;
            font-weight: bold;
        }

        .category {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 11px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
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
            padding: 35px 15px;
            font-size: 14px;
        }

        .pagination {
            margin-top: 25px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 16px 5%;
            }

            .container {
                margin-top: 25px;
            }

            .header h1 {
                font-size: 23px;
            }

            .filter-form {
                flex-direction: column;
            }

            .search-input {
                width: 100%;
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
        <a href="{{ route('admin.dashboard') }}">
            Kembali ke Dashboard Admin
        </a>
    </nav>

    <main class="container">

        <a href="{{ route('admin.dashboard') }}" class="back-link">
            &larr; Kembali ke Dashboard
        </a>

        <section class="header">
            <h1>Manajemen Proyek</h1>
            <p>
                Pantau seluruh proyek yang terdaftar di Garuda Hub.
            </p>
        </section>

        <!-- Pencarian dan filter proyek -->
        <section class="filter-card">

            <form action="{{ route('admin.projects') }}" method="GET"
                  class="filter-form">

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Cari judul, deskripsi, atau nama klien..."
                    value="{{ request('search') }}"
                >

                <select name="kategori">
                    <option value="">Semua Kategori</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category }}"
                            {{ request('kategori') == $category ? 'selected' : '' }}
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>

                    <option value="terbuka"
                        {{ request('status') == 'terbuka' ? 'selected' : '' }}>
                        Terbuka
                    </option>

                    <option value="ditutup"
                        {{ request('status') == 'ditutup' ? 'selected' : '' }}>
                        Ditutup
                    </option>
                </select>

                <button type="submit" class="btn">
                    Cari
                </button>

                <a href="{{ route('admin.projects') }}" class="btn btn-reset">
                    Reset
                </a>

            </form>

        </section>

        <!-- Tabel seluruh proyek -->
        <section class="table-card">

            <div class="table-header">
                <h2>Daftar Proyek</h2>

                <span class="total">
                    {{ $projects->total() }} proyek
                </span>
            </div>

            @if ($projects->count() > 0)

                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Judul Proyek</th>
                                <th>Klien</th>
                                <th>Kategori</th>
                                <th>Budget</th>
                                <th>Penawaran</th>
                                <th>Batas Lelang</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($projects as $project)

                                <tr>
                                    <td>
                                        {{ $projects->firstItem() + $loop->index }}
                                    </td>

                                    <td class="project-name">
                                        {{ $project->judul }}
                                    </td>

                                    <td>
                                        {{ $project->client->nama }}
                                    </td>

                                    <td>
                                        <span class="category">
                                            {{ $project->kategori }}
                                        </span>
                                    </td>

                                    <td>
                                        Rp{{ number_format($project->budget_min, 0, ',', '.') }}
                                        -
                                        Rp{{ number_format($project->budget_max, 0, ',', '.') }}
                                    </td>

                                    <td>
                                        {{ $project->bids_count }}
                                    </td>

                                    <td>
                                        {{ $project->batas_lelang->format('d M Y') }}
                                    </td>

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

                <div class="pagination">
                    {{ $projects->links() }}
                </div>

            @else

                <div class="empty">
                    <h3>Proyek Tidak Ditemukan</h3>

                    <p style="margin-top: 8px;">
                        Coba gunakan kata kunci atau filter yang berbeda.
                    </p>
                </div>

            @endif

        </section>

    </main>

</body>
</html>
