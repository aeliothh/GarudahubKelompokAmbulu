
<!DOCTYPE html>
<html lang="id">
    <link rel="stylesheet" href="{{ asset('css/security-fixes.css') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna - Garuda Hub</title>

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
            max-width: 1150px;
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
            margin-bottom: 20px;
            gap: 12px;
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
            min-width: 650px;
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

        .user-name {
            color: #172554;
            font-weight: bold;
        }

        .role {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: bold;
        }

        .role.admin {
            background: #ede9fe;
            color: #6d28d9;
        }

        .role.klien {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .role.developer {
            background: #dcfce7;
            color: #166534;
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
        <a href="{{ route('admin.dashboard') }}">Kembali ke Dashboard Admin</a>
    </nav>

    <main class="container">

        <a href="{{ route('admin.dashboard') }}" class="back-link">
            &larr; Kembali ke Dashboard
        </a>

        <section class="header">
            <h1>Manajemen Pengguna</h1>
            <p>
                Lihat dan pantau seluruh akun yang terdaftar di Garuda Hub.
            </p>
        </section>

        <!-- Form pencarian dan filter -->
        <section class="filter-card">

            <form action="{{ route('admin.users') }}" method="GET" class="filter-form">

                <input
                    type="text"
                    name="search"
                    class="search-input"
                    placeholder="Cari nama atau email pengguna..."
                    value="{{ request('search') }}"
                >

                <select name="role">
                    <option value="">Semua Role</option>

                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option value="klien" {{ request('role') == 'klien' ? 'selected' : '' }}>
                        Klien
                    </option>

                    <option value="developer" {{ request('role') == 'developer' ? 'selected' : '' }}>
                        Developer
                    </option>
                </select>

                <button type="submit" class="btn">
                    Cari
                </button>

                <a href="{{ route('admin.users') }}" class="btn btn-reset">
                    Reset
                </a>

            </form>

        </section>

        <!-- Tabel pengguna -->
        <section class="table-card">

            <div class="table-header">
                <h2>Daftar Pengguna</h2>

                <span class="total">
                    {{ $users->total() }} pengguna
                </span>
            </div>

            @if ($users->count() > 0)

                <div class="table-wrapper">

                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Pengguna</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Tanggal Terdaftar</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($users as $user)

                                <tr>
                                    <td>
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td class="user-name">
                                        {{ $user->nama }}
                                    </td>

                                    <td>
                                        {{ $user->email }}
                                    </td>

                                    <td>
                                        <span class="role {{ $user->role }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $user->created_at->format('d M Y') }}
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>
                    </table>

                </div>

                <div class="pagination">
                    {{ $users->links() }}
                </div>

            @else

                <div class="empty">
                    <h3>Pengguna Tidak Ditemukan</h3>

                    <p class="csp-mt-8">
                        Coba gunakan kata kunci atau filter role yang berbeda.
                    </p>
                </div>

            @endif

        </section>

    </main>

</body>
</html>
